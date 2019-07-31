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

            // Keep the footer at the right size
            var footerResize = function() {
                $('#block-importantinformationfooter').css('position', $("body").height() + $("#block-importantinformationfooter").innerHeight() > $(window).height() ? "inherit" : "fixed");
            };
            $(window).resize(footerResize).ready(footerResize);

            // Expand and contract footer
            var expandable = drupalSettings.important_information.importantInformationFooter.expandable;
            var expandMarkup = drupalSettings.important_information.importantInformationFooter.expandMarkup;
            var shrinkMarkup = drupalSettings.important_information.importantInformationFooter.shrinkMarkup;
            var expandAmount = drupalSettings.important_information.importantInformationFooter.expandAmount;

            if (expandable) {

                $('.expand-button').click(function() {

                    if ($(this).hasClass('not-expanded')) {
                        $('#block-importantinformationfooter').stop();
                        $('.expand-button').html(expandMarkup);
                        $('#block-importantinformationfooter').animate({height:expandAmount+'%'}, 333, 'swing', function(){
                            $('.expand-button').addClass('expanded');
                            $('.expand-button').removeClass('not-expanded');
                        });
                    }

                    if ($(this).hasClass('expanded')) {
                        $('#block-importantinformationfooter').stop();
                        $('.expand-button').html(shrinkMarkup);
                        $('#block-importantinformationfooter').animate({height:'33%'}, 333, 'swing', function(){
                            $('.expand-button').addClass('not-expanded');
                            $('.expand-button').removeClass('expanded');
                        });
                    }

                });



            }

        }
    };

})(jQuery, Drupal);
