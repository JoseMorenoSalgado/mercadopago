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
 * @copyright 2020 Jonathan López <jonathan.lopez.garcia@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once("$CFG->libdir/externallib.php");

class enrol_mpcheckoutpro_external extends external_api {
    /**
     * Returns description of method parameters.
     *
     * @return external_function_parameters
     */
    public static function unenrol_users_parameters() {
        return new external_function_parameters(
            array(
            'enrolments' => new external_multiple_structure(
                new external_single_structure(
                    array(
                    'userid' => new external_value(PARAM_INT, 'The user that is going to be unenrolled'),
                    'courseid' => new external_value(PARAM_INT, 'The course to unenrol the user from'),
                    'roleid' => new external_value(PARAM_INT, 'The user role', VALUE_OPTIONAL)
                    )
                )
            )
            )
        );
    }

    /**
     * Unenrolment of users.
     *
     * @param  array $enrolments
     *            an array of course user and role ids
     * @throws coding_exception
     * @throws dml_transaction_exception
     * @throws invalid_parameter_exception
     * @throws moodle_exception
     * @throws required_capability_exception
     * @throws restricted_context_exception
     */
    public static function unenrol_users($enrolments) {
        global $CFG, $DB;
        $params = self::validate_parameters(
            self::unenrol_users_parameters(),
            array(
            'enrolments' => $enrolments
            )
        );
        include_once($CFG->libdir . '/enrollib.php');
        $transaction = $DB->start_delegated_transaction(); // Rollback all enrolment if an error occurs.
        $enrol = enrol_get_plugin('manual');
        if (empty($enrol)) {
            throw new moodle_exception('manualpluginnotinstalled', 'enrol_manual');
        }

        foreach ($params['enrolments'] as $enrolment) {
            $context = context_course::instance($enrolment['courseid']);
            self::validate_context($context);
            require_capability('enrol/manual:unenrol', $context);
            $instance = $DB->get_record(
                'enrol',
                array(
                'courseid' => $enrolment['courseid'],
                'enrol' => 'manual'
                )
            );
            if (!$instance) {
                throw new moodle_exception('wsnoinstance', 'enrol_manual', $enrolment);
            }
            $user = $DB->get_record(
                'user',
                array(
                'id' => $enrolment['userid']
                )
            );
            if (!$user) {
                throw new invalid_parameter_exception('User id not exist: ' . $enrolment['userid']);
            }
            if (!$enrol->allow_unenrol($instance)) {
                throw new moodle_exception('wscannotenrol', 'enrol_manual', '', $enrolment);
            }
            $enrol->unenrol_user($instance, $enrolment['userid']);
        }
        $transaction->allow_commit();
    }

    /**
     * Returns description of method result value.
     *
     * @return null
     */
    public static function unenrol_users_returns() {
        return null;
    }
}
