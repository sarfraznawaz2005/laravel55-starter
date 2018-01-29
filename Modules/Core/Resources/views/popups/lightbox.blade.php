<div id="lightbox" class="modal fade animated rotateIn" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <button type="button" class="close hidden" data-dismiss="modal" aria-hidden="true">×</button>
        <div class="modal-content">
            <div class="modal-body">
                <img src="" alt=""/>
            </div>
        </div>
    </div>
</div>

<style>
    #lightbox .modal-content {
        display: inline-block;
        text-align: center;
    }

    #lightbox .close {
        opacity: 1;
        color: rgb(255, 255, 255);
        background-color: rgb(25, 25, 25);
        padding: 5px 8px;
        border-radius: 30px;
        border: 2px solid rgb(255, 255, 255);
        position: absolute;
        top: -15px;
        right: -55px;

        z-index: 1032;
    }
</style>

<script>

    // example
    // <img data-lightbox="path to original big image" data-toggle="modal" data-target="#lightbox" src="path to small image">

    $.fn.lightbox = function () {
        var $lightbox = $('#lightbox');

        $(this).on('click', function (event) {
            var $img = $(this).is('img') ? $(this) : $(this).find('img');
            var
                src = $img.data('lightbox'),
                alt = $img.attr('alt'),
                css = {
                    'maxWidth': $(window).width() - 100,
                    'maxHeight': $(window).height() - 100
                };

            $lightbox.find('.close').addClass('hidden');
            $lightbox.find('img').attr('src', src);
            $lightbox.find('img').attr('alt', alt);
            $lightbox.find('img').css(css);
        });

        $lightbox.on('shown.bs.modal', function (e) {
            var $img = $lightbox.find('img');

            // remove modal cache
            $(this).removeData('bs.modal');

            $lightbox.find('.modal-dialog').css({'width': $img.width()});
            $lightbox.find('.close').removeClass('hidden');
        });
    };

    $(document).ready(function () {
        $('[data-target="#lightbox"]').lightbox();
    });
</script>
