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
 * Upgrade script for Purge old assignments
 *
 * @package    local_purgeoldassignments
 * @copyright  Catalyst IT
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * upgrade code
 * @param int $oldversion The old version of the plugin
 * @return bool
 */
function xmldb_local_purgeoldassignments_upgrade($oldversion) {
    global $DB;
    $dbman = $DB->get_manager();

    if ($oldversion < 2025031300) {

        // Define table local_purgeoldassignments to be created.
        $table = new xmldb_table('local_purgeoldassignments');

        // Adding fields to table local_purgeoldassignments.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('cmid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('component', XMLDB_TYPE_CHAR, '50', null, XMLDB_NOTNULL, null, null);
        $table->add_field('timespan', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, null);
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('usermodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);

        // Adding keys to table local_purgeoldassignments.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Conditionally launch create table for local_purgeoldassignments.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Purgeoldassignments savepoint reached.
        upgrade_plugin_savepoint(true, 2025031300, 'local', 'purgeoldassignments');
    }

    if ($oldversion < 2025051300) {

        // Delete broken table rows.
        $DB->delete_records('local_purgeoldassignments', ['timespan' => '0']);

        // Purgeoldassignments savepoint reached.
        upgrade_plugin_savepoint(true, 2025051300, 'local', 'purgeoldassignments');
    }

    return true;
}
