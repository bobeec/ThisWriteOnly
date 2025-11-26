/**
 * BLOGthemeWP Customizer Live Preview
 */

(function($) {
    'use strict';

    // Primary Color
    wp.customize('blogthemewp_primary_color', function(value) {
        value.bind(function(newval) {
            // Calculate lighter and darker versions
            var hex = newval.replace('#', '');
            var r = parseInt(hex.substr(0, 2), 16);
            var g = parseInt(hex.substr(2, 2), 16);
            var b = parseInt(hex.substr(4, 2), 16);
            
            // Lighter (90% toward white)
            var lr = Math.round(r + (255 - r) * 0.9);
            var lg = Math.round(g + (255 - g) * 0.9);
            var lb = Math.round(b + (255 - b) * 0.9);
            var light = '#' + lr.toString(16).padStart(2, '0') + lg.toString(16).padStart(2, '0') + lb.toString(16).padStart(2, '0');
            
            // Darker (20% darker)
            var dr = Math.round(r * 0.8);
            var dg = Math.round(g * 0.8);
            var db = Math.round(b * 0.8);
            var dark = '#' + dr.toString(16).padStart(2, '0') + dg.toString(16).padStart(2, '0') + db.toString(16).padStart(2, '0');
            
            // Update CSS variables
            document.documentElement.style.setProperty('--blog-primary', newval);
            document.documentElement.style.setProperty('--blog-primary-light', light);
            document.documentElement.style.setProperty('--blog-primary-dark', dark);
        });
    });

    // Site Title
    wp.customize('bloginfo[name]', function(value) {
        value.bind(function(newval) {
            $('.site-title a').text(newval);
        });
    });

    // Site Description
    wp.customize('bloginfo[description]', function(value) {
        value.bind(function(newval) {
            $('.site-description').text(newval);
        });
    });

})(jQuery);
