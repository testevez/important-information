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
            var hideSidebar = drupalSettings.important_information.importantInformationBottom.hideSidebar;
            var hideFooter = drupalSettings.important_information.importantInformationBottom.hideFooter;


            var footerSelector = '.layout-bottom'; // TODO: Make configurable

            if (!jQuery('#important-bottom-block-wrap').length) { //TODO: find a better way to check if its already appended
                jQuery(container).append(markup);
            }

            window.onscroll = function(ev) {

                var height = $('#important-bottom-block-wrap').height();

                if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
                    // You're at the bottom of the page.

                    // Show / hide all the stuff (if we are supposed to)
                    if (hideSidebar) {
                        $('#block-importantinformationsidebar:visible').hide();
                        $('#block-importantinformationfooter:visible').hide();
                    }
                    if (hideFooter) {

                        $(footerSelector).addClass('important-information-footer-transparent');
                        $('#block-importantinformationfooter').hide();
                        $(footerSelector).removeClass('important-information-footer-opaque');


                    }
                }

                if ($('#important-bottom-block-wrap').is(":visible")) {

                    var pos = window.innerHeight + window.scrollY + height + verticalOffset;
                    var limit = document.body.offsetHeight ;


                    if (pos < limit) {

                        // Show / hide all the stuff (if we are supposed to)
                        if (hideSidebar) {
                            $('#block-importantinformationsidebar:hidden').show();
                            $('#block-importantinformationfooter:hidden').show();
                        }
                        if (hideFooter) {
                            console.log('show footer');
                            $(footerSelector).removeClass('important-information-footer-transparent');
                            $(footerSelector).addClass('important-information-footer-opaque');
                            $('#block-importantinformationfooter').show();

                        }

                    }

                }


            };

        }
    };

})(jQuery, Drupal);
