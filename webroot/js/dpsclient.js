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
        var response = JXON.build(xmlDoc);

        if (null != response.message) {
            var messageType = response.message['@type'];

            if ('Status' == messageType) {
                var ready = response.message.ready;
                var readylink = response.message.readylink;
                var readypinpad = response.message.readypinpad;
                var dpsReady = (1 == ready && 1 == readylink && 1 == readypinpad);

                if (dpsReady) {
                } else {

                }

                if (callback) {
                    callback(dpsReady);
                }
            }

            console.log(response.message);
            console.log('-------------------------------------------------------');
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
        var response = JXON.build(xmlDoc);

        if (null != response.message) {
            var messageType = response.message['@type'];

            if ('Display' == messageType) {
                var text1 = response.message.text1;
                var text2 = response.message.text2;
                if(text1 == true) {
	                text1 = "";
                }
                if(text2 == true) {
	                text2 = "";
                }
                //Show status box
                $(".pay").hide();
                $(".eftpos_status").show();
                $(".display-msg").text(text1 +' '+ text2);
                
                //IF transaction cancelled
                if("TRANS. CANCELLED" == text1) {
	                $(".pay").show();
	                $(".eftpos_status").hide();
                }
                
                if ("SIGNATURE REQD" == text1) {
                
                } else if ("SIGNATURE OK Y/N?" == text1) {
                    presssButton(self.socket, 'No');
                }
            } else if ('ClearDisplay' == messageType) {
            } else if ('Transaction' == messageType) {
                var responsetext = response.message.responsetext;
                var txndatetime = response.message.txndatetime;
                var txndatetime = response.message.txndatetime;
                var txnref = response.message.txnref;
                var txntype = response.message.txntype;

                if("INCORRECT PIN" == responsetext) {
                	$(".eftpos_status").hide();
	                $(".pay").show();
                } else if("ACCEPTED" == responsetext) {
	                $(".modal-backdrop").hide();
	                $(".eftpos_status").hide();
	            }
                if (callback) {
                    callback(response.message, null);
                }
            }

            console.log(response.message);
            console.log('======================================================================');
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

function presssButton(socket, button) {
    var message = '<Message type="Button" id="1234">';
    message += '<Button>' + button + '</Button>';
    message += '</Message>';
    socket.send(message);
}
