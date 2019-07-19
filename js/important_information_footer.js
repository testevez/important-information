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

            var footerResize = function() {
                $('.layout-bottom').css('position', $("body").height() + $(".layout-bottom").innerHeight() > $(window).height() ? "inherit" : "fixed");
            };
            $(window).resize(footerResize).ready(footerResize);
        }
    };

})(jQuery, Drupal);
