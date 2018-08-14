<script>
    var socket = new WebSocket("{{Modules\Core\Facades\Socket::getSocketUrl()}}");

    socket.onopen = function () {
        console.log("CONNECTED");
    };

    socket.onclose = function (event) {
        console.log('Key: ' + event.code + ' cause: ' + event.reason);
    };

    socket.onmessage = function (event) {
        var data = JSON.parse(event.data);
        var message = data.message + '<br><small>' + data.time + '</small>';

        notify(message, 'success', true);
    };

    socket.onerror = function (error) {
        console.log("Error " + error.message);
    };

    // To send data using the method socket.send(data).
    // socket.send("Hello");

    function notify(message, type, sticky) {
        new Noty({
            text: message,
            type: type || 'info',
            layout: 'bottomRight',
            theme: 'metroui',
            timeout: sticky ? false : 4000,
            progressBar: true,
            closeWith: ['button', 'click'],
            animation: {
                open: 'animated bounceInRight',
                close: 'animated bounceOutRight'
            },
            maxVisible: 10
        }).show();
    }
</script>
