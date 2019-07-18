/**
* @file
*/

(function ($, Drupal) {

    'use strict';

    /**
     * @type {Drupal~behavior}
     */
    Drupal.behaviors.importantInformationSidebar = {
        attach: function (context, settings) {

            var sidebar = new StickySidebar('.region-sidebar', {innerWrapperSelector: '#block-importantinformationsidebar'});
        }
    };

})(jQuery, Drupal);
