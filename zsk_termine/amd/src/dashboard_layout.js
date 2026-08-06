// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

/**
 * Place the upcoming-events block at the top of the dashboard centre column.
 *
 * @module     local_zsk_termine/dashboard_layout
 * @copyright  2025 Silvio Kuhn
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
define([], function() {
    /**
     * Move the pending dashboard block into the centre column.
     */
    const placeDashboardTermine = function() {
        const pending = document.getElementById('local-termine-dashboard-pending');
        if (!pending) {
            return;
        }

        let section = document.getElementById('dashboard-upcoming-events');
        if (!section || section.closest('#local-termine-dashboard-pending')) {
            section = pending.querySelector('#dashboard-upcoming-events');
        }
        if (!section) {
            return;
        }

        const main = document.querySelector('#region-main');
        if (!main) {
            return;
        }

        pending.removeAttribute('id');
        pending.classList.remove('local-termine-dashboard-pending');
        main.insertBefore(pending, main.firstChild);
    };

    /**
     * Initialise dashboard placement.
     */
    const init = function() {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', placeDashboardTermine);
        } else {
            placeDashboardTermine();
        }
    };

    return {
        init: init,
    };
});
