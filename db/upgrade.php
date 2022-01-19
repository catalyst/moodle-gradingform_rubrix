<?php
// This file is part of Moodle - http://moodle.org/
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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * This file keeps track of upgrades to plugin gradingform_rubrix
 *
 * @package    gradingform_rubrix
 * @copyright  2011 David Mudrak <david@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Keeps track or rubric plugin upgrade path
 *
 * @param int $oldversion the DB version of currently installed plugin
 * @return bool true
 */
function xmldb_gradingform_rubrix_upgrade($oldversion) {
    global $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2022011900) {

        // Define field criteriatype to be added to gradingform_rubrix_criteria.
        $table = new xmldb_table('gradingform_rubrix_criteria');
        $field = new xmldb_field('criteriatype', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0', 'descriptionformat');

        // Conditionally launch add field criteriatype.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Define field cap to be added to gradingform_rubrix_criteria.
        $table = new xmldb_table('gradingform_rubrix_criteria');
        $field = new xmldb_field('cap', XMLDB_TYPE_INTEGER, '10', null, null, null, null, 'criteriatype');

        // Conditionally launch add field cap.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Rubrix savepoint reached.
        upgrade_plugin_savepoint(true, 2022011900, 'gradingform', 'rubrix');
    }

    return true;
}
