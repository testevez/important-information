/**
 * @file
 */

(function ($, Drupal) {

    'use strict';

    /**
     * @type {Drupal~behavior}
     */
    Drupal.behaviors.importantInformationBottom = {
        attach: function (context, settings) {

            var container = drupalSettings.important_information.importantInformationBottom.container;
            var markup = drupalSettings.important_information.importantInformationBottom.markup;
            
            if (!jQuery('#important-bottom-block-wrap').length) { //TODO: find a better way to check if its already appended
                jQuery(container).append(markup);
            }

            window.onscroll = function(ev) {
                if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
                    // You're at the bottom of the page.
                    //alert("You're at the bottom of the page! " + container);

                    // Hide all open II blocks if not hidden - hide
                    //$('block-importantinformationsidebar:visible').hide();
                    //$('block-importantinformationfooter:visible').hide();


                    // Append the II to the bottom of the page
                    // TODO: Make the page DOM configurable

                }
            };


            // Later in the script - Show it but only If it's not visible.
            //$('.trigger:hidden').show();
        }
    };

})(jQuery, Drupal);
