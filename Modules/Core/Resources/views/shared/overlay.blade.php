<style>
    #__cover__ {
        position: fixed;
        top: 0;
        left: 0;
        background: rgba(0, 0, 0, 0.6);
        z-index: 999999999999999;
        width: 100%;
        height: 100%;
        display: none;
        justify-content: center;
        flex-direction: column;
        text-align: center;
        font-size: 175%;
        font-weight: bold;
        color: #fff;
    }
</style>

<script>
    function showOverlay(message) {
        var message = message || 'Please wait...';

        $('#__cover__').html(message).css('display', 'flex');
    }

    function hideOverlay() {
        $('#__cover__').css('display', 'none');
    }
</script>

<div id="__cover__" align="center">
    <span>Please wait...</span>
</div>
