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
            var verticalOffset = drupalSettings.important_information.importantInformationBottom.verticalOffset;

            if (!jQuery('#important-bottom-block-wrap').length) { //TODO: find a better way to check if its already appended
                jQuery(container).append(markup);
            }

            window.onscroll = function(ev) {

                var height = $('#important-bottom-block-wrap').height();

                if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
                    // You're at the bottom of the page.

                    // Show / hide all the stuff.
                    $('#block-importantinformationsidebar:visible').hide();
                    $('#block-importantinformationfooter:visible').hide();
                    $('#important-bottom-block-wrap:hidden').show();
                    // TODO: Make the selectors configurable
                }

                if ($('#important-bottom-block-wrap').is(":visible")) {

                    var pos = window.innerHeight + window.scrollY + height + verticalOffset;
                    var limit = document.body.offsetHeight ;


                    if (pos < limit) {
                        // Show / hide all the stuff.
                        $('#block-importantinformationsidebar').show();
                        $('#block-importantinformationfooter').show();
                        $('#important-bottom-block-wrap').hide();

                    }

                }

            };

        }
    };

})(jQuery, Drupal);
