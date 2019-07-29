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

            // Expand and contract footer
            var sidebarParent = drupalSettings.important_information.importantInformationSidebar.sidebarParent;
            var sidebarContainer = drupalSettings.important_information.importantInformationSidebar.sidebarContainer;

            console.log('sidebarParent: '+sidebarParent);
            console.log('sidebarContainer: '+sidebarContainer);


            var sidebar = new StickySidebar(sidebarParent, {innerWrapperSelector: sidebarContainer});
        }
    };

})(jQuery, Drupal);
