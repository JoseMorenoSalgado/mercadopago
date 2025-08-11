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
 * This page handles settings for the MercadoPago Checkout Pro enrolment plugin.
 *
 * @package   enrol_mpcheckoutpro
 * @copyright 2025 Jose Erasmo Moreno Salgado - Elearning Cloud <soporte@elearningcloud.org>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
require_login();

if ($ADMIN->fulltree) {

    // Settings header.
    $settings->add(
        new admin_setting_heading(
            'enrol_mpcheckoutpro_settings',
            '',
            get_string('pluginname_desc', 'enrol_mpcheckoutpro')
        )
    );

    // Access Token setting.
    $settings->add(
        new admin_setting_configtext(
            'enrol_mpcheckoutpro/accesstoken',
            get_string('accesstoken', 'enrol_mpcheckoutpro'),
            get_string('deskaccesstoken', 'enrol_mpcheckoutpro'),
            '',
            PARAM_RAW
        )
    );

    // Public Key setting.
    $settings->add(
        new admin_setting_configtext(
            'enrol_mpcheckoutpro/publickey',
            get_string('publickey', 'enrol_mpcheckoutpro'),
            get_string('deskpublickey', 'enrol_mpcheckoutpro'),
            '',
            PARAM_RAW
        )
    );

    // SDK Path setting.
    $settings->add(
        new admin_setting_configtext(
            'enrol_mpcheckoutpro/sdk',
            get_string('sdk', 'enrol_mpcheckoutpro'),
            get_string('sdkdescription', 'enrol_mpcheckoutpro'),
            '/var/www/vendor/autoload.php',
            PARAM_RAW
        )
    );

    // IPN URL setting.
    $settings->add(
        new admin_setting_configtext(
            'enrol_mpcheckoutpro/ipn',
            get_string('ipn', 'enrol_mpcheckoutpro'),
            get_string('ipn', 'enrol_mpcheckoutpro'),
            '',
            PARAM_RAW
        )
    );

    // New setting for Ventor.
    $settings->add(
        new admin_setting_configtext(
            'enrol_mpcheckoutpro/ventor',
            get_string('ventor', 'enrol_mpcheckoutpro'), // You need to add this string to your language file.
            get_string('ventordesc', 'enrol_mpcheckoutpro'), // You need to add this string to your language file.
            '',
            PARAM_RAW
        )
    );

    // Expiration action setting.
    $options = array(
        ENROL_EXT_REMOVED_KEEP => get_string('extremovedkeep', 'enrol'),
        ENROL_EXT_REMOVED_SUSPENDNOROLES => get_string(
            'extremovedsuspendnoroles',
            'enrol'
        ),
        ENROL_EXT_REMOVED_UNENROL => get_string('extremovedunenrol', 'enrol')
    );

    $settings->add(
        new admin_setting_configselect(
            'enrol_mpcheckoutpro/expiredaction',
            get_string('expiredaction', 'enrol_mpcheckoutpro'),
            get_string('expiredaction_help', 'enrol_mpcheckoutpro'),
            ENROL_EXT_REMOVED_SUSPENDNOROLES,
            $options
        )
    );

    // Default settings header.
    $settings->add(
        new admin_setting_heading(
            'enrol_mpcheckoutpro_defaults',
            get_string('enrolinstancedefaults', 'admin'),
            get_string('enrolinstancedefaults_desc', 'admin')
        )
    );

    // Default status setting.
    $enableoptions = array(
        ENROL_INSTANCE_ENABLED => get_string('yes'),
        ENROL_INSTANCE_DISABLED => get_string('no')
    );

    $settings->add(
        new admin_setting_configselect(
            'enrol_mpcheckoutpro/status',
            get_string('status', 'enrol_mpcheckoutpro'),
            get_string('status_desc', 'enrol_mpcheckoutpro'),
            ENROL_INSTANCE_DISABLED,
            $enableoptions,
        )
    );

    // Default cost setting.
    $settings->add(
        new admin_setting_configtext(
            'enrol_mpcheckoutpro/cost',
            get_string('cost', 'enrol_mpcheckoutpro'),
            '',
            0,
            PARAM_FLOAT,
            4,
        )
    );

    // Default tax setting.
    $settings->add(
        new admin_setting_configtext(
            'enrol_mpcheckoutpro/tax',
            get_string('tax', 'enrol_mpcheckoutpro'),
            '',
            0,
            PARAM_FLOAT,
            4,
        )
    );

    // Country setting.
    $countries = array(
        'ar' => 'Argentina',
        'br' => 'Brasil',
        'cl' => 'Chile',
        'co' => 'Colombia',
        'mx' => 'México',
        'pe' => 'Perú',
        'uy' => 'Uruguay',
        'ec' => 'Ecuador',
        'py' => 'Paraguay',
        'bo' => 'Bolivia',
    );
    $settings->add(
        new admin_setting_configselect(
            'enrol_mpcheckoutpro/country',
            get_string('country', 'enrol_mpcheckoutpro'), // You need to add this string to your language file.
            get_string('country_desc', 'enrol_mpcheckoutpro'), // You need to add this string to your language file.
            'co', // Default country
            $countries
        )
    );

    // Default currency setting with a comprehensive list.
    $currencies = array(
        'ARS' => 'Peso Argentino (ARS)',
        'BRL' => 'Real Brasileño (BRL)',
        'CLP' => 'Peso Chileno (CLP)',
        'COP' => 'Peso Colombiano (COP)',
        'MXN' => 'Peso Mexicano (MXN)',
        'PEN' => 'Sol Peruano (PEN)',
        'UYU' => 'Peso Uruguayo (UYU)',
        'USD' => 'Dólar Americano (USD)',
        'PYG' => 'Guaraní Paraguayo (PYG)',
        'BOB' => 'Boliviano (BOB)',
    );
    $settings->add(
        new admin_setting_configselect(
            'enrol_mpcheckoutpro/currency',
            get_string('currency', 'enrol_mpcheckoutpro'),
            '',
            'COP',
            $currencies
        )
    );
    
    // Default role setting.
    if (!during_initial_install()) {
        $defoptions = get_default_enrol_roles(context_system::instance());
        $student = get_archetype_roles('student');
        $student = reset($student);
        $settings->add(
            new admin_setting_configselect(
                'enrol_mpcheckoutpro/roleid',
                get_string('defaultrole', 'enrol_mpcheckoutpro'),
                get_string('defaultrole_desc', 'enrol_mpcheckoutpro'),
                $student->id,
                $defoptions,
            )
        );
    }

    // Default enrolment period setting.
    $settings->add(
        new admin_setting_configduration(
            'enrol_mpcheckoutpro/enrolperiod',
            get_string('enrolperiod', 'enrol_mpcheckoutpro'),
            get_string('enrolperiod_desc', 'enrol_mpcheckoutpro'),
            0
        )
    );
}