// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

/**
 * Place the upcoming-events block in the front page centre column.
 *
 * @module     local_zsk_termine/frontpage_layout
 * @copyright  2025 Silvio Kuhn
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
define([], function() {
    const centreSelector = '#site-news-forum, #frontpage-course-list, #frontpage-available-course-list, ' +
        '#frontpage-category-names, #frontpage-category-combo, #frontpage-course-tiles, ' +
        '#frontpage-upcoming-events, .local-zsk-fp-element-section';
    const pendingSelector = '.local-termine-frontpage-pending';

    /**
     * @param {Element} node
     * @returns {number}
     */
    const getCentreSlotIndex = function(node) {
        let value = node.getAttribute('data-centre-slot-index');
        if (value === null || value === '') {
            value = node.getAttribute('data-slot-index');
        }
        return parseInt(value || '0', 10);
    };

    /**
     * @param {Element} main
     * @returns {Element[]}
     */
    const collectExisting = function(main) {
        const existing = [];
        main.querySelectorAll(centreSelector).forEach(function(el) {
            if (!el.closest(pendingSelector)) {
                existing.push(el);
            }
        });
        return existing;
    };

    /**
     * @param {Element} main
     * @returns {Element|null}
     */
    const findCourseSearchBox = function(main) {
        const form = main.querySelector('form[action*="course/search"]');
        if (!form) {
            return null;
        }
        return form.closest('.box') || form.parentElement;
    };

    /**
     * Move the pending front page block into the configured layout slot.
     */
    const placeFrontpageTermine = function() {
        const pending = document.getElementById('local-termine-frontpage-pending');
        if (!pending) {
            return;
        }

        const main = document.querySelector('#region-main');
        if (!main) {
            return;
        }

        const centreSlot = getCentreSlotIndex(pending);
        const existing = collectExisting(main);
        const ref = existing[centreSlot] || null;

        pending.removeAttribute('id');
        pending.classList.remove('local-termine-frontpage-pending');

        if (ref) {
            main.insertBefore(pending, ref);
            return;
        }

        if (centreSlot === 0) {
            const searchBox = findCourseSearchBox(main);
            if (searchBox && searchBox.parentElement === main) {
                if (searchBox.nextSibling) {
                    main.insertBefore(pending, searchBox.nextSibling);
                } else {
                    main.appendChild(pending);
                }
                return;
            }
            main.insertBefore(pending, main.firstChild);
            return;
        }

        main.appendChild(pending);
    };

    /**
     * Initialise front page placement.
     */
    const init = function() {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', placeFrontpageTermine);
        } else {
            placeFrontpageTermine();
        }
    };

    return {
        init: init,
    };
});
