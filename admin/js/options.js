// executed for /wp-admin/options-general.php?page=qtranslate-x
jQuery(document).ready(
    function ($) {
        /**
         * Get cookie value by name
         *
         * @param {string} name Cookie name
         * @returns {string} Cookie value
         */
        function getCookie(name) {
            var nm = name + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var ce = ca[i];
                var p  = ce.indexOf(nm);
                if (p >= 0) return ce.substring(p + nm.length, ce.length);
            }
            return '';
        }

        /**
         * Set cookie value
         *  
         * @param {string} name Cookie name
         * @param {string} value Cookie value
         */
        function setCookie(name, value) {
            document.cookie = name + '=' + value;
        }

        /**
         * Replace the hash in the form action.
         *
         * @param hash
         */
        function addHashToFormAction(hash) {
            var f = jQuery('#qtranxs-configuration-form');
            var a = f.attr('action');
            a     = a.replace(/(#.*|$)/, hash);
            f.attr('action', a);
        }

        /**
         * Switch to the given tab.
         *
         * @param anchor
         * @param hash
         */
        function switchTabTo(anchor, hash) {
            // Activate the tab
            anchor.parent().children().removeClass('nav-tab-active');
            anchor.addClass('nav-tab-active');

            // Activate the tab content
            var tabcontents = $('.tabs-content');
            tabcontents.children().addClass('hidden');
            var tab_id = hash.replace('#', '#tab-');
            tabcontents.find('div' + tab_id).removeClass('hidden');

            addHashToFormAction(hash);
            setCookie('qtrans_admin_section', hash);
        }

        /**
         * Switch to the given default tab, unless the location contains a hash or a cookie is set.
         */
        function onHashChange() {
            var default_hash = '#general';

            // Bail if there are no tabs
            var tabs = $('.nav-tab-wrapper');
            if (!tabs || !tabs.length) return;

            // Try the current location first
            var hash = window.location.hash;

            // Then try to get the hash from the cookie
            if (!hash) {
                hash = getCookie('qtrans_admin_section');
            }

            // Finally, use the default hash
            if (!hash) {
                hash = default_hash;
            }

            // Find the link that refers to this hash
            var anchor = tabs.find('a[href="' + hash + '"]');

            // In case the anchor does not exist, use the default one
            if (!anchor || !anchor.length) {
                anchor = tabs.find('a[href="' + default_hash + '"]');
            }

            switchTabTo(anchor, hash);
        }

        $(window).bind('hashchange', function (e) {
            onHashChange();
        });

        // Switch to the correct tab on load
        onHashChange();
    });