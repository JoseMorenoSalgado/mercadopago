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
 * This page handles successful responses from MercadoPago and enrols users.
 *
 * @package   enrol_mpcheckoutpro
 * @copyright 2025 Jose Erasmo Moreno Salgado - Elearning Cloud <soporte@elearningcloud.org>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require("../../config.php");
require_once("lib.php");
require_once($CFG->libdir . '/enrollib.php');

global $DB, $CFG, $SESSION, $PAGE;

require_login();

// Get parameters from MercadoPago response
$payid = optional_param('payment_id', 0, PARAM_INT);
$status = optional_param('status', '', PARAM_TEXT);
$extref = optional_param('external_reference', '', PARAM_TEXT);
$prefid = optional_param('preference_id', '', PARAM_TEXT);
$collectionstatus = optional_param('collection_status', '', PARAM_TEXT); // 'collection_status' is the correct parameter for final status.
$token = optional_param('token', '', PARAM_RAW);

// 1. Security Check: Validate the session token.
if (empty($token) || !isset($SESSION->mpcheckoutpro_token) || !hash_equals($SESSION->mpcheckoutpro_token, $token)) {
    // Invalid token, redirect to home to prevent unauthorized access.
    throw new moodle_exception('invalidtoken', 'error');
}
// Clean the token immediately after validation.
unset($SESSION->mpcheckoutpro_token);

// 2. Check if the payment was approved.
if ($status !== "approved" || $collectionstatus !== "approved" || empty($extref)) {
    // Payment was not successful, redirect with a generic message.
    $a = new stdClass();
    $a->payment_status = $status;
    redirect($CFG->wwwroot . '/my/', get_string('paymentsorry', 'enrol_mpcheckoutpro', $a), \core\output\notification::INFO);
}

// 3. Process the successful payment.
$transaction = $DB->start_delegated_transaction();

try {
    list($courseid, $userid, $instanceid, $contextid) = explode("-", $extref);

    // Validate that the user and course exist.
    if (!$course = $DB->get_record('course', array('id' => $courseid))) {
        throw new moodle_exception('invalidcourseid');
    }
    if (!$user = $DB->get_record('user', array('id' => $userid, 'deleted' => 0))) {
        throw new moodle_exception('invaliduserid');
    }
    $plugin = enrol_get_plugin('mpcheckoutpro');
    if (!$instance = $DB->get_record('enrol', array('id' => $instanceid, 'enrol' => 'mpcheckoutpro', 'courseid' => $courseid))) {
        throw new moodle_exception('invalidinstance', 'enrol');
    }

    // 4. Enrol the user directly.
    $plugin->enrol_user($instance, $userid, $instance->roleid, time());

    // 5. Save the transaction record for reference.
    $record = new stdClass();
    $record->preference_id = $prefid;
    $record->courseid = $courseid;
    $record->userid = $userid;
    $record->instanceid = $instanceid;
    $record->contextid = $contextid;
    $record->payment_id = $payid;
    $record->payment_status = $status;
    $record->external_reference = $extref;
    $record->timeupdated = time();
    $DB->insert_record('enrol_mpcheckoutpro', $record);

    // If everything went well, commit the transaction.
    $transaction->allow_commit();

    // Redirect to the course with a success message.
    $courseurl = new moodle_url('/course/view.php', array('id' => $course->id));
    $a = new stdClass();
    $a->payment_id = $payid;
    $a->payment_status = $status;
    $a->userid = $userid;
    redirect($courseurl, get_string('paymentconfirm', 'enrol_mpcheckoutpro', $a), 5);

} catch (Exception $e) {
    // Something went wrong, rollback the transaction and show an error.
    $transaction->rollback($e);
    // You can also send a notification to the admin here if you want.
    redirect($CFG->wwwroot . '/my/', $e->getMessage(), \core\output\notification::ERROR);
}