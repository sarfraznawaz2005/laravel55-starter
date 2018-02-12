<?php

// Routes for WebSocket

$socket->route('/socket', new App\Http\Sockets\AppSocket, ['*']);
