// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

/**
 * Confirm dialog helper for destructive admin actions.
 *
 * @module     local_zsk_termine/confirm_delete
 * @copyright  2025 Silvio Kuhn
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
define(['core/notification'], function(Notification) {
    /**
     * @param {object} config
     * @param {string} config.selector
     * @param {string} config.message
     */
    const init = function(config) {
        document.querySelectorAll(config.selector).forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const href = link.getAttribute('href');
                Notification.confirm(
                    config.title || '',
                    config.message,
                    config.yeslabel || 'OK',
                    config.nolabel || 'Cancel',
                    function() {
                        window.location.href = href;
                    }
                );
            });
        });
    };

    return {init: init};
});
