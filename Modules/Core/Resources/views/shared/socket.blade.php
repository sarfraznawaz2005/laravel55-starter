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

        notify(data.time, data.message, true);
    };

    socket.onerror = function (error) {
        console.log("Error " + error.message);
    };

    // To send data using the method socket.send(data).
    // socket.send("Hello");

    function notify(message, heading, sticky) {
        $.toast({
            heading: heading || 'Notification',
            text: message || '',
            //icon: type || 'success',
            bgColor: '#3C763D',
            textColor: 'white',
            showHideTransition: 'slide',
            loader: true,
            //textAlign: 'center',
            allowToastClose: true,
            stack: 10,
            position: 'bottom-right',
            hideAfter: sticky || 10000,
            loaderBg: '#fff'
        })
    }
</script>
