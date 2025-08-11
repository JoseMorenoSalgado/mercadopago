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
 * This page handles responses from MercadoPago for failed payments.
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
    // If tokens don't match, redirect without a message.
    redirect($CFG->wwwroot);
}

// Clean the session token after use.
unset($SESSION->mpcheckoutpro_token);

$status = optional_param('status', 'failed', PARAM_TEXT);

$a = new stdClass();
$a->payment_status = $status; // Pass the failure reason to the language string.

// Prepare the user-friendly message.
$message = get_string('paymentreject', 'enrol_mpcheckoutpro', $a);

// Redirect the user to their main course page with the failure message.
redirect($CFG->wwwroot . '/my/', $message, \core\output\notification::ERROR);