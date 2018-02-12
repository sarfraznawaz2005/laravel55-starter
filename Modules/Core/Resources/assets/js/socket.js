var socket = new WebSocket("ws://localhost:8080/socket");

socket.onopen = function () {
    console.log("CONNECTED");
};

socket.onclose = function (event) {
    if (!event.wasClean) {
        console.log('Connection closed cleanly');
    }

    console.log('Key: ' + event.code + ' cause: ' + event.reason);
};

socket.onmessage = function (event) {
    var data = JSON.parse(event.data);

    //if (window.cuid != data.user_id) {
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