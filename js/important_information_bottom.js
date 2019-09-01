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
            var embeddedBottomSelector =  '.block-embedded-bottom';
            var showHideFloatingContainer =  drupalSettings.important_information.importantInformationBottom.showHideFloatingContainer;
            var floatingContainerSelector = '.block-floating-container';

            window.onscroll = function(ev) {

                if (showHideFloatingContainer)  {
                    var position = window.innerHeight + window.scrollY - jQuery(floatingContainerSelector).height();
                    // Position value refers to bottom of the viewport (the bottom edge of the user's view)
                    // We subtract the value of the height of the Floating Container  because it makes the viewport smaller
                    console.log('position: ' + position);
                    var bottomStart = jQuery(embeddedBottomSelector).offset().top;
                    console.log('bottomStart: ' + bottomStart);

                    //  Check  if the  Embedded  Bottom is viewable
                    if (position >= bottomStart ) {
                        // The Embedded Bottom is in  view
                        jQuery(floatingContainerSelector).hide();
                    }

                    if (position <=  bottomStart)  {
                        console.log('Bring back the FC');
                        jQuery(floatingContainerSelector).show();
                    }

                }

            };

        }
    };

})(jQuery, Drupal);
