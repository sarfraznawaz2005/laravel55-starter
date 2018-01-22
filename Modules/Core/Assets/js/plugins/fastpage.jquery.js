/**
 * Plugin to load pages in background for faster opening.
 * Author: Sarfraz Ahmed
 * Version: 1.0.0
 */
(function ($) {
    $.fn.fastpage = function (settings) {
        var opts = $.extend({}, $.fn.fastpage.defaults, settings);
        var options = $.extend({}, opts, $(this).data());
        var outputElement = options.container || document.body;
        var pages = [];
        var timeDiff = 0;
        var $overlay = $('<div>');

        $overlay.text('Loading...');

        $overlay.css({
            "background": "#fff",
            "opacity": 0.9,
            "color": "black",
            "font-weight": "bold",
            "font-size": "24px",
            "text-align": "center",
            "position": "fixed",
            "padding-top": "20%",
            "left": '0px',
            "right": '0px',
            "top": '0px',
            "width": '100%',
            "height": '100%',
            "z-index": 99999
        });

        // preload data
        return this.each(function (el) {
            var $this = $(this);
            var url = this.href;

            timeDiff += 1000;

            // send ajax requests
            setTimeout(function () {
                $.ajax({
                    "type": "GET",
                    "url": url,
                    "cache": false,
                    "success": function (response) {
                        pages.push({"url": url, "data": response});
                    }
                });

            }, timeDiff);

            // override link click handler
            $this.on('click', function (e) {
                var url = $(this).get(0).href;
                var title = $(this).text();

                $('body').append($overlay);

                for (var i = 0; i < pages.length; i++) {
                    if (pages[i].url !== url) {
                        continue;
                    }

                    if (pages[i].data) {
                        history.pushState({href: pages[i].url}, title, pages[i].url);

                        $(outputElement).html(pages[i].data);

                        e.preventDefault();
                    }
                }
            });

        });

    }
})(jQuery);