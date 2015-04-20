var DpsClient = function DpsClient(config) {
    // TODO: Implement extensions
    this.config = {
        // account number.
        accountNumber: 1,

        // hostname or ip address.
        hostname: 'localhost',

        // port number.
        portNumber: 1025,

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

DpsClient.prototype.connect = function (callback) {
    var self = this;

    // Host we are connecting to
    var host_url = 'ws://' + self.config.hostname + ':' + self.config.portNumber;

    self.socket = new WebSocket(host_url);
    self.connected = false;

    self.socket.onopen = function () {
        console.log('connected!');
        self.connected = true;
    };

    self.socket.onclose = function () {
        console.log('disconnected!');
        self.connected = false;
    };

    self.socket.onmessage = function (message) {
        var xmlDoc = new DOMParser().parseFromString(message.data, "text/xml");
        var jObject = JXON.build(xmlDoc);

        console.log(JSON.stringify(jObject));
        console.log('======================================================================');

        if (callback) {
            callback(true);
        }
    };

    self.socket.onerror = function (error) {
        console.log('WebSocket error: ' + error);

        if (callback) {
            callback(false, error);
        }
    };
};

DpsClient.prototype.payment = function (txnRef, amount, callback) {
    var self = this;

    console.log(self.connected);
    console.log(self.socket);
    if (!self.connected || !self.socket)
        return;

    self.socket.onclose = function () {
        console.log('disconnected!');
    };

    self.socket.onmessage = function (message) {
        var xmlDoc = new DOMParser().parseFromString(message.data, "text/xml");
        var jObject = JXON.build(xmlDoc);

        console.log(JSON.stringify(jObject));

        if (callback) {
            callback(message.data, null);
        }
    };

    self.socket.onerror = function (error) {
        console.log('WebSocket error: ' + error);

        if (callback) {
            callback(null, error);
        }
    };

    purchase(self.socket, txnRef, amount);
};

DpsClient.prototype.close = function () {
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

function getLastTransaction(socket) {
    var message = '<Message type="LastTransaction" id="1234">';
    message += '</Message>\n';
    socket.send(message);
}

function purchase(socket, txnRef, amount) {
    var message = '<Message type="Transaction" id="1234">';
    message += '<TxnType>Purchase</TxnType>';
    message += '<TxnRef>' + txnRef + '</TxnRef>';
    message += '<AmountPurchase>' + amount + '</AmountPurchase>';
    message += '</Message>\n';
    socket.send(message);
}
