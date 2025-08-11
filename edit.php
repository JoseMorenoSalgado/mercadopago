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

require('../../config.php');
require_once('edit_form.php');

$courseid = required_param('courseid', PARAM_INT);
$instanceid = optional_param('id', 0, PARAM_INT);

$course = $DB->get_record(
    'course',
    array(
    'id' => $courseid
    ),
    '*',
    MUST_EXIST
);
$context = context_course::instance($course->id, MUST_EXIST);

require_login($course);

require_capability('enrol/mpcheckoutpro:config', $context);

$PAGE->set_url(
    '/enrol/mpcheckoutpro/edit.php',
    array(
    'courseid' => $course->id,
    'id' => $instanceid,
    )
);
$PAGE->set_pagelayout('admin');

$return = new moodle_url(
    '/enrol/instances.php',
    array(
    'id' => $course->id
    )
);
if (!enrol_is_enabled('mpcheckoutpro')) {
    redirect($return);
}

$plugin = enrol_get_plugin('mpcheckoutpro');

if ($instanceid) {
    $instance = $DB->get_record(
        'enrol',
        array(
        'courseid' => $course->id,
        'enrol' => 'mpcheckoutpro',
        'id' => $instanceid,
        ),
        '*',
        MUST_EXIST
    );
    $instance->cost = format_float($instance->cost, 2, true);
    $instance->customint1 = format_float($instance->customint1, 2, true);
} else {
    require_capability('moodle/course:enrolconfig', $context);

    navigation_node::override_active_url(
        new moodle_url(
            '/enrol/instances.php',
            array(
            'id' => $course->id
            )
        )
    );
    $instance = new stdClass();
    $instance->id = null;
    $instance->courseid = $course->id;
}

$mform = new enrol_mpcheckoutpro_edit_form(
    null,
    array(
    $instance,
    $plugin,
    $context
    )
);

if ($mform->is_cancelled()) {
    redirect($return);
} elseif ($data = $mform->get_data()) {
    if ($instance->id) {
        $reset = ($instance->status != $data->status);
        $instance->status = $data->status;
        $instance->name = $data->name;
        $instance->cost = unformat_float($data->cost);
        $instance->customint1 = unformat_float($data->tax);
        $instance->currency = $data->currency;
        $instance->roleid = $data->roleid;
        $instance->enrolperiod = $data->enrolperiod;
        $instance->enrolstartdate = $data->enrolstartdate;
        $instance->enrolenddate = $data->enrolenddate;
        $instance->timemodified = time();
        $DB->update_record('enrol', $instance);

        if ($reset) {
            $context->mark_dirty();
        }
    } else {
        $fields = array(
            'status' => $data->status,
            'name' => $data->name,
            'cost' => unformat_float($data->cost),
            'customint1' => unformat_float($data->tax),
            'currency' => $data->currency,
            'roleid' => $data->roleid,
            'enrolperiod' => $data->enrolperiod,
            'enrolstartdate' => $data->enrolstartdate,
            'enrolenddate' => $data->enrolenddate,
        );
        $plugin->add_instance($course, $fields);
    }

    redirect($return);
}

$PAGE->set_heading($course->fullname);
$PAGE->set_title(get_string('pluginname', 'enrol_mpcheckoutpro'));

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('pluginname', 'enrol_mpcheckoutpro'));
$mform->display();
echo $OUTPUT->footer();
