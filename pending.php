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
 * This page handles responses from MercadoPago for pending payments.
 *
 * @package   enrol_mpcheckoutpro
 * @copyright 2025 Jose Erasmo Moreno Salgado - Elearning Cloud <soporte@elearningcloud.org>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require("../../config.php");
require_once("lib.php");
global $CFG, $SESSION;

require_login();

// Security check: Validate the token from the session.
$token = optional_param('token', '', PARAM_RAW);
if (empty($token) || !isset($SESSION->mpcheckoutpro_token) || !hash_equals($SESSION->mpcheckoutpro_token, $token)) {
    // If tokens don't match, redirect without a message or show a generic error.
    redirect($CFG->wwwroot);
}

// Clean the session token after use.
unset($SESSION->mpcheckoutpro_token);

$paymentid = optional_param('payment_id', 0, PARAM_INT);
$status = optional_param('status', 'pending', PARAM_TEXT);
$externalreference = optional_param('external_reference', 'none', PARAM_TEXT);
$merchantorderid = optional_param('merchant_order_id', 0, PARAM_INT);

$a = new stdClass();
$a->payment_status = $status; // Pass only the status to the language string for a cleaner message.

// We just need to inform the user that the payment is pending.
// The detailed information is useful for logging, but not for the end-user message.
if ($paymentid && $externalreference) {
    // The payment is pending, show a friendly message.
    $message = get_string('paymentsorry', 'enrol_mpcheckoutpro', $a);
} else {
    // This case should not happen in a normal flow.
    $message = get_string('errnoparameters', 'enrol_mpcheckoutpro');
}

// Redirect the user to their main course page with the message.
redirect($CFG->wwwroot . '/my/', $message, \core\output\notification::INFO);