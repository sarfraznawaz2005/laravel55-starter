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
        var cusrid = {{auth()->check() ? user()->id : 0}};

        // don't show notification to originator/same user
        //if (cusrid != data.user_id) {
            notify(data.message);
        //}
    };

    socket.onerror = function (error) {
        console.log("Error " + error.message);
    };

    // To send data using the method socket.send(data).
    // socket.send("Hello");

    function notify(message, heading, type, sticky) {
        $.toast({
            heading: heading || 'Notification',
            text: message || '',
            icon: type || 'success',
            showHideTransition: 'slide',
            loader: true,
            allowToastClose: true,
            stack: 10,
            position: 'bottom-right',
            hideAfter: sticky || 10000,
            loaderBg: '#9EC600'
        })
    }
</script>
