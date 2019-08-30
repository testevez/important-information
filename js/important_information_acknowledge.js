/**
* @file
*/

(function ($, Drupal) {

    'use strict';

    /**
     * @type {Drupal~behavior}
     */
    Drupal.behaviors.importantInformationAcknowledge = {
        attach: function (context, settings) {
            // Check for cookie
            // TODO: Consider making cookie name configurable
            if  (jQuery.cookie('impoortant_information_intro_acknowledged') != "true")  {
                jQuery('#block-importantinformationacknowledge  .use-ajax').click();
            }
            // Set the cookie, make  it available throughout the site, and make it last 7 days
            // If it was already set, renew it for another  7 days
            jQuery.cookie("impoortant_information_intro_acknowledged", "true", { path: '/', expires: 7 });
        }
    };

})(jQuery, Drupal);
