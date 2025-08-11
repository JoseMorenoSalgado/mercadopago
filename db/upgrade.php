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

/**
 * Upgrade the mpcheckoutpro enrolment plugin.
 *
 * @param int $oldversion The old version number of the plugin.
 * @return bool True if the upgrade was successful, false otherwise.
 */
function xmldb_enrol_mpcheckoutpro_upgrade($oldversion) {
    // upgrade function.
    if ($oldversion < 2025032503) {
        upgrade_plugin_savepoint(true, 2025032503, 'enrol', 'mpcheckoutpro');
    }

    return true;
}
