/**
* @file
*/

(function ($, Drupal) {

    'use strict';

    /**
     * @type {Drupal~behavior}
     */
    Drupal.behaviors.importantInformationFooter = {
        attach: function (context, settings) {

            // Keep the Floating Container at the right size
            var floatingContainerResize = function() {
                $('#block-importantinformationfloatingcontainerr').css('position', $("body").height() + $("#block-importantinformationfloatingcontainerr").innerHeight() > $(window).height() ? "inherit" : "fixed");
            };
            $(window).resize(floatingContainerResize).ready(floatingContainerResize);

            // Expand and contract Floating Container
            var expandable = drupalSettings.important_information.importantInformationFloatingContainer.expandable;
            var expandMarkup = drupalSettings.important_information.importantInformationFloatingContainer.expandMarkup;
            var shrinkMarkup = drupalSettings.important_information.importantInformationFloatingContainer.shrinkMarkup;
            var expandAmount = drupalSettings.important_information.importantInformationFloatingContainer.expandAmount;

            if (expandable) {

                $('.expand-button').click(function() {

                    if ($(this).hasClass('not-expanded')) {
                        $('#block-importantinformationfloatingcontainerr').stop();
                        $('.expand-button').html(shrinkMarkup);
                        $('#block-importantinformationfloatingcontainerr').animate({height:expandAmount+'%'}, 333, 'swing', function(){
                            $('.expand-button').addClass('expanded');
                            $('.expand-button').removeClass('not-expanded');
                        });
                    }

                    if ($(this).hasClass('expanded')) {
                        $('#block-importantinformationfloatingcontainerr').stop();
                        $('.expand-button').html(expandMarkup);
                        // TODO: Make the base percentage configurable (like expand amount)
                        $('#block-importantinformationfloatingcontainerr').animate({height:'33%'}, 333, 'swing', function(){
                            $('.expand-button').addClass('not-expanded');
                            $('.expand-button').removeClass('expanded');
                        });
                    }

                });



            }

        }
    };

})(jQuery, Drupal);
