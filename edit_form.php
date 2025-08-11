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

require_once($CFG->libdir . '/formslib.php');

/**
 * Sets up moodle edit form class methods.
 *
 * @copyright 2017 Exam Tutor, Venkatesan R Iyengar
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class enrol_mpcheckoutpro_edit_form extends moodleform {
    /**
     * Sets up moodle form.
     *
     * @return void
     */
    public function definition() {
        global $CFG;

        $mform = $this->_form;

        list($instance, $plugin, $context) = $this->_customdata;

        $pixicon = $CFG->wwwroot . '/enrol/mpcheckoutpro/pix/icon.png'; // Replace your_icon_name.png with the actual filename
        $mform->addElement('html', '<div class="pix_icon"><img src="' . $pixicon . '" alt="MP Icon" style="width:5%;" /></div>');
        $mform->addElement('static', 'description', get_string('owner', 'enrol_mpcheckoutpro'), null);
        $mform->addElement('static', 'description', get_string('descriptionower', 'enrol_mpcheckoutpro'), null);

        $mform->addElement('text', 'name', get_string('custominstancename', 'enrol'));
        $mform->setType('name', PARAM_TEXT);
        $options = array(
            ENROL_INSTANCE_ENABLED => get_string('yes'),
            ENROL_INSTANCE_DISABLED => get_string('no')
        );
        $mform->addElement('select', 'status', get_string('status', 'enrol_mpcheckoutpro'), $options);
        $mform->setDefault('status', $plugin->get_config('status'));

        $mform->addElement(
            'text',
            'cost',
            get_string('cost', 'enrol_mpcheckoutpro'),
            array(
            'size' => 4
            ),
        );
        $mform->setType('cost', PARAM_RAW); // Use unformat_float to get real value.
        $mform->setDefault('cost', format_float($plugin->get_config('cost'), 2, true));

        $mform->addElement(
            'text',
            'tax',
            get_string('tax', 'enrol_mpcheckoutpro'),
            array(
            'size' => 4
            ),
        );
        $mform->setType('tax', PARAM_RAW); // Use unformat_float to get real value.
        $mform->setDefault('tax', format_float($plugin->get_config('tax'), 2, true));

        $currencies = $plugin->get_currencies();
        $mform->addElement('select', 'currency', get_string('currency', 'enrol_mpcheckoutpro'), $currencies);
        $mform->setDefault('currency', $plugin->get_config('currency'));

        if ($instance->id) {
            $roles = get_default_enrol_roles($context, $instance->roleid);
        } else {
            $roles = get_default_enrol_roles($context, $plugin->get_config('roleid'));
        }
        $mform->addElement('select', 'roleid', get_string('assignrole', 'enrol_mpcheckoutpro'), $roles);
        $mform->setDefault('roleid', $plugin->get_config('roleid'));

        $mform->addElement(
            'duration',
            'enrolperiod',
            get_string('enrolperiod', 'enrol_mpcheckoutpro'),
            array(
            'optional' => true,
            'defaultunit' => 86400
            ),
        );
        $mform->setDefault('enrolperiod', $plugin->get_config('enrolperiod'));
        $mform->addHelpButton('enrolperiod', 'enrolperiod', 'enrol_mpcheckoutpro');

        $mform->addElement(
            'date_time_selector',
            'enrolstartdate',
            get_string('enrolstartdate', 'enrol_mpcheckoutpro'),
            array(
            'optional' => true
            ),
        );
        $mform->setDefault('enrolstartdate', 0);
        $mform->addHelpButton('enrolstartdate', 'enrolstartdate', 'enrol_mpcheckoutpro');

        $mform->addElement(
            'date_time_selector',
            'enrolenddate',
            get_string('enrolenddate', 'enrol_mpcheckoutpro'),
            array(
            'optional' => true
            ),
        );
        $mform->setDefault('enrolenddate', 0);
        $mform->addHelpButton('enrolenddate', 'enrolenddate', 'enrol_mpcheckoutpro');

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('hidden', 'courseid');
        $mform->setType('courseid', PARAM_INT);

        if ($CFG->version >= '2013111801') {
            if (enrol_accessing_via_instance($instance)) {
                $mform->addElement(
                    'static',
                    'selfwarn',
                    get_string('instanceeditselfwarning', 'core_enrol'),
                    get_string('instanceeditselfwarningtext', 'core_enrol')
                );
            }
        }

        $this->add_action_buttons(true, ($instance->id ? null : get_string('addinstance', 'enrol')));

        $this->set_data($instance);
    }

    /**
     * Sets up moodle form validation.
     *
     * @param  stdClass $data
     * @param  stdClass $files
     * @return $error error list
     */
    public function validation($data, $files) {
        global $DB, $CFG;
        $errors = parent::validation($data, $files);

        list($instance, $plugin, $context) = $this->_customdata;

        if (!empty($data['enrolenddate']) and $data['enrolenddate'] < $data['enrolstartdate']) {
            $errors['enrolenddate'] = get_string('enrolenddaterror', 'enrol_mpcheckoutpro');
        }

        $cost = str_replace(get_string('decsep', 'langconfig'), '.', $data['cost']);
        if (!is_numeric($cost)) {
            $errors['cost'] = get_string('costerror', 'enrol_mpcheckoutpro');
        }

        $tax = str_replace(get_string('decsep', 'langconfig'), '.', $data['tax']);
        if (!is_numeric($tax)) {
            $errors['tax'] = get_string('taxerror', 'enrol_mpcheckoutpro');
        }

        return $errors;
    }
}
