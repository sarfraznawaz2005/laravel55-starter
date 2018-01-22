/**
 * Plugin to load ajax content while showing loading message.
 * Author: Sarfraz Ahmed
 * Version: 1.0.0
 *
 * Example Usage:
 * $('.someClass').contentloader({
    "type": "post",
    "url": "request url",
    "data": [],
    "output": "p",
    "loadtext": "Loading..."
    "css": {}
});
 *
 * url: url to send request to.
 * type: type of ajax requests: GET or POST. Default is GET.
 * data: any data to pass
 * output : inside element where ajax response will be placed. If none, main selector will be used.
 * loadtext : Loading text to be displayed. Default "Loading..."
 * css : Optional Object containing CSS properties for ajax loading overlay
 *
 * Note: url to send requests to should be passed either by "url" option or by element by
 * using data-url="url here" for element whose content comes through ajax. Priority is given to
 * option passed. The "url" is only required thing for the plugin.
 */

(function ($) {
    $.fn.contentloader = function (settings) {
        var opts = $.extend({}, $.fn.contentloader.defaults, settings);
        var timeDiff = 0;

        return this.each(function () {
            var options = $.extend({}, opts, $(this).data());
            var $this = $(this);
            var width = $this.outerWidth();
            var height = $this.height();
            var pos = $this.offset();
            var url = options.url || $this.data('url');
            var ajaxType = options.type || 'get';
            var data = options.data || '';
            var outputElement = options.output;
            var loadtext = options.loadtext || 'Loading...';

            timeDiff += 500;

            if (url) {
                var $overlay = $('<div>');

                if (options.css) {
                    $overlay.css(options.css);
                }
                else {
                    $overlay.css({
                        "background": "#333",
                        "opacity": 0.9,
                        "color": "white",
                        "font-weight": "bold",
                        "font-size": "16px",
                        "text-align": "center",
                        "position": "absolute",
                        "left": pos.left,
                        "top": pos.top,
                        "margin-top": $this.css('padding-top'),
                        "margin-bottom": $this.css('padding-bottom'),
                        "margin-left": $this.css('padding-left'),
                        "margin-right": $this.css('padding-right'),
                        "border-width": $this.css('border-width'),
                        "width": width + 'px',
                        "height": height + 'px',
                        "line-height": height + 'px',
                        "z-index": 99999
                    });
                }

                $overlay.addClass('__contentloader__');
                $overlay.text(loadtext);
                
                $('body').append($overlay);

                // send ajax requests
                setTimeout(function () {
                    $.ajax({
                        "type": ajaxType,
                        "url": url,
                        "cache": false,
                        //"async": false,
                        "data": data,
                        "success": function (response) {
                            if (outputElement) {
                                $this.find(outputElement).html(response);
                            } else {
                                $this.html(response);
                            }

                            $overlay.slideUp('fast');
                        }
                    });
                }, timeDiff);
            }
        });
    };
})(jQuery);