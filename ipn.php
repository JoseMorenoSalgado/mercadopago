<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * This page handles Instant Payment Notifications (IPN) from MercadoPago.
 *
 * @package   enrol_mpcheckoutpro
 * @copyright 2025 Jose Erasmo Moreno Salgado - Elearning Cloud
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// We need to be a Moodle page but we don't want to require login or send any output.
require('../../config.php');

// We don't want any output from this page, just a 200 OK header to MercadoPago.
define('NO_OUTPUT_BUFFERING', true);
ob_start();

// Get the notification data from the POST request.
$input = file_get_contents("php://input");
$data = json_decode($input);

// Set header to acknowledge receipt of the notification to MercadoPago.
header("HTTP/1.1 200 OK");
ob_end_flush();

// Basic validation: Check if we have data and a topic.
if (!$data || !isset($data->topic) || !isset($data->resource)) {
    exit(); // Not a valid notification
}

// Process only payment notifications.
if ($data->topic === 'payment') {
    $plugin = enrol_get_plugin('mpcheckoutpro');
    $accesstoken = $plugin->get_config('accesstoken');

    // Load MercadoPago SDK from local vendor folder (included in plugin).
    $sdk = __DIR__ . '/vendor/autoload.php';
    if (!class_exists('MercadoPago\\SDK')) {
        if (file_exists($sdk)) {
            require_once($sdk);
        } else {
            error_log('MercadoPago IPN Error: SDK not found at path: ' . $sdk);
            exit();
        }
    }

    // Set Access Token
    MercadoPago\SDK::setAccessToken($accesstoken);

    // Get the payment ID from the resource URL.
    $payment_info = MercadoPago\Payment::find_by_id(basename($data->resource));

    if ($payment_info === null || $payment_info->status !== 'approved') {
        exit(); // Payment not found or not approved
    }

    // Get our custom reference to find the user and course.
    $extref = $payment_info->external_reference;
    if (empty($extref)) {
        exit();
    }

    // Use a transaction for database operations.
    $transaction = $DB->start_delegated_transaction();

    try {
        list($courseid, $userid, $instanceid, $contextid) = explode("-", $extref);

        $instance = $DB->get_record('enrol', ['id' => $instanceid, 'enrol' => 'mpcheckoutpro'], '*', MUST_EXIST);

        // Check if the user is already enrolled to prevent duplicates.
        if ($plugin->is_user_enrolled($instance->courseid, $userid)) {
            $transaction->allow_commit();
            exit();
        }

        // Enrol the user.
        $plugin->enrol_user($instance, $userid, $instance->roleid, time());

        // Save the transaction record for reference.
        $record = new stdClass();
        $record->preference_id = $payment_info->order->id ?? '';
        $record->courseid = $courseid;
        $record->userid = $userid;
        $record->instanceid = $instanceid;
        $record->contextid = $contextid;
        $record->payment_id = $payment_info->id;
        $record->payment_status = $payment_info->status;
        $record->external_reference = $extref;
        $record->timeupdated = time();
        $DB->insert_record('enrol_mpcheckoutpro', $record);

        // Commit transaction
        $transaction->allow_commit();

    } catch (Exception $e) {
        error_log('MercadoPago IPN Error: ' . $e->getMessage());
        $transaction->rollback($e);
    }
}

exit();
