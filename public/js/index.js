/**
 * YAWIK
 *
 * License: MIT
 * (c) 2013 - 2017 CROSS Solution <http://cross-solution.de>
 */

/**
 *
 * Author: Mathias Gelhausen <gelhausen@cross-solution.de>
 */
;(function ($) {

    $(function() {
        $('.eq_height .rpt_head').matchHeight({
            byRow: true,
            property: 'height',
            target: null,
            remove: false
        });
    });

})(jQuery); 
 
