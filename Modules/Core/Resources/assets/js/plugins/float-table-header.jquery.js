/**
 * Plugin to float table header on page scroll.
 * Author: Sarfraz Ahmed
 * Version: 1.0.0
 *
 * Example Usage:
 $('.mytable').floatTableHeader({
    start: 200, // scroll position to show float header from
    top: 200, // how far from top to show float header from
    background: "#fff", // (optional) background color of float header
    color: "#000" // (optional) text color of float header
});
 *
 */

(function ($) {
    $.fn.floatTableHeader = function (settings) {
        var opts = $.extend({}, $.fn.floatTableHeader.defaults, settings);

        return this.each(function () {
            var options = $.extend({}, opts, $(this).data());
            var $this = $(this);
            var $headerOriginal = $this.find('thead');
            var $table = $this.clone();
            var $header = $table.find('thead');
            var start = options.start || 200;
            var top = options.top || 0;
            var background = options.background || '#fff';
            var color = options.color || '#000';

            // delete table body or all rows except for first
            $table.find('tbody').remove();
            $table.find('tr:gt(0)').remove();

            $table.css({
                "position": "fixed",
                "top": top,
                "left": $this.offset().left,
                "width": $this.outerWidth(),
                "z-index": 99999,
                "opacity": 1,
                "display": "none"
            });

            // if no <head>, assume first row to be head
            if (typeof $headerOriginal === 'undefined' || !$headerOriginal) {
                $headerOriginal = $this.find('tr:first');
            }

            if (typeof $header === 'undefined' || !$header) {
                $header = $table.find('tr:first');
            }

            // match width
            $('td, th', $headerOriginal).each(function (index) {
                var $column = $header.find('th').eq(index) || $header.find('td').eq(index);
                $column.width($(this).outerWidth());
            });

            $header.css({
                "background": background,
                "opacity": 1,
                "color": color
            });

            $('body').append($table);

            $(window).scroll(function () {
                // only show floating header if table is visible
                if ($this.is(':visible')) {
                    if ($(window).scrollTop() > start) {
                        $table.fadeIn('slow');
                    }
                    else {
                        $table.fadeOut('slow');
                    }
                }
            });

        });
    };
})(jQuery);

