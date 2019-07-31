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

            var attach_to = drupalSettings.important_information.importantInformationBottom.attach_to;
            var markup = drupalSettings.important_information.importantInformationBottom.markup;
            var verticalOffset = drupalSettings.important_information.importantInformationBottom.verticalOffset;
            var hideSidebar = drupalSettings.important_information.importantInformationBottom.hideSidebar;
            var hideFooter = drupalSettings.important_information.importantInformationBottom.hideFooter;
            var footerSelector = '.layout-bottom'; // TODO: Make configurable

            if (!jQuery('#important-bottom-block-wrap').length) { //TODO: find a better way to check if its already appended
                jQuery('#block-appendedii').append(markup);
            }

            window.onscroll = function(ev) {

                //var height = $(attach_to).height();

                var position = (window.innerHeight + window.scrollY);
                var appendedIIStart = jQuery(attach_to).offset().top;

                if (position >= appendedIIStart + verticalOffset) {
                    // You're at the start of the appended II
                    console.log('You\'re at the start of the appended II');

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



                    if (position < appendedIIStart + verticalOffset) {

                        // Show / hide all the stuff (if we are supposed to)
                        if (hideSidebar) {
                            $('#block-importantinformationsidebar:hidden').show();
                            $('#block-importantinformationfooter:hidden').show();
                        }
                        if (hideFooter) {
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
