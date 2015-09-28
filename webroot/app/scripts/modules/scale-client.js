var ScaleClient = function ScaleClient(config) {
    // TODO: Implement extensions
    this.config = {
        // account number.
        accountNumber: 1,

        // hostname or ip address.
        hostname: 'localhost',

        // port number.
        portNumber: 8443,

        // socket type.
        socket: 'websocket',

        // receipt print.
        print: 0,

        // The number of milliseconds to wait after sending a close frame
        // for an acknowledgement to come back before giving up and just
        // closing the socket.
        closeTimeout: 5000
    };

    if (config) {
        extend(this.config, config);
    }
};

ScaleClient.prototype.connect = function (callback) {
    var self = this;

    // Host we are connecting to
    var url = 'wss://' + self.config.hostname + ':' + self.config.portNumber + '/scale-gateway';
    var wsCtor = window['MozWebSocket'] ? MozWebSocket : WebSocket;

    self.socket = new wsCtor(url);
    self.connected = false;

    self.socket.onopen = function () {
        console.log('sacle - connected!');
        self.connected = true;
        if (callback) {
        callback(self.connected);
       }
    };

    self.socket.onclose = function () {
        console.log('scale - disconnected!');
        self.connected = false;
    };

    self.socket.onmessage = function (message) {
    };

    self.socket.onerror = function (error) {
        console.log('WebSocket error: ' + error);

        if (callback) {
            callback(false, error);
        }
    };
};

ScaleClient.prototype.doEnquiry = function (callback) {
    var self = this;

    console.log(self.connected);
    console.log(self.socket);
    if (!self.connected || !self.socket)
        return;

    self.socket.onclose = function () {
        console.log('disconnected!');

        if (callback) {
            callback(null, 'closed');
        }
    };

    self.socket.onmessage = function (message) {
        console.log('received: ' + message);

        if (callback) {
            callback(message);
        }
    };

    self.socket.onerror = function (error) {
        console.log('WebSocket error: ' + error);

        if (callback) {
            callback(null, error);
        }
    };

    enquiry(self.socket);
};

ScaleClient.prototype.close = function () {
    var self = this;

    if (!self.connected || !self.socket)
        return;

    self.socket.onclose = function () {
        console.log('disconnected!');
    };

    self.socket.onerror = function (error) {
        console.log('WebSocket error: ' + error);
    };
};

function enquiry(socket) {
    var message = '<Message type="command">';
    message += '<Command>ENQ</Command>';
    message += '</Message>\n';
    socket.send(message);
}
