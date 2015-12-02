var DpsClient = function DpsClient(config) {
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

DpsClient.prototype.connect = function (callback) {
  var self = this;

  // Host we are connecting to
  var url = 'wss://' + self.config.hostname + ':' + self.config.portNumber + '/dps-gateway';
  var wsCtor = window['MozWebSocket'] ? MozWebSocket : WebSocket;

  self.socket = new wsCtor(url);
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
          alert("ERROR: "+response.message.description);
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

DpsClient.prototype.refund = function (txnRef, amount, callback) {
  var self = this;
  console.debug(amount);
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
        $(".eftpos_status").find("button").remove();
        if(text1 == true) {
          text1 = "";
        }
        if(text2 == true) {
          text2 = "";
        }
        //Show status box
        $(".pay").hide();
        $(".eftpos_status").show();
        var a =text1 +' '+ text2;
        $(".display-msg").empty();
        $(".display-msg").append('<p>' +a + '</p>');
        if("PRESENT/INSERT" == text1) {
          $(".display-msg").empty();
          $(".display-msg").append('<p>' +a + '</p>');
          $(".display-msg").append('<div><img style="width: 30%" class="payment-img" src ="images/payment/icon-01.png"></img></div>');
        }
        else if("AWAITING ACCOUNT" == text1 ||"PROCESSING NOW" == text1 ||"AWAITING PIN" == text1){
          $(".display-msg").empty();
          $(".display-msg").append(text1 +' ' + text2 );
          $(".display-msg").append('<div><img style="width: 30%" class="payment-img" src ="images/payment/icon-02.png"></img></div>');
        }
        else if ("ACCEPTED" == text1 ||"SIG ACCEPTED" == text1 ) {
          $(".display-msg").empty();
          $(".display-msg").text(text1 +' '+ text2);
          $(".display-msg").append('<div><img style="width: 30%" class="payment-img" src ="images/payment/icon-03.png"></img></div>');
        }
        else if ("INCORRECT PIN" == text1) {
          $(".display-msg").empty();
          $(".display-msg").text(text1 +' '+ text2);
          $(".display-msg").append('<div><img style="width: 30%" class="payment-img" src ="images/payment/icon-05.png"></img></div>');
        }

        //IF transaction cancelled
        else if("TRANS. CANCELLED" == text1) {
          $(".display-msg").empty();
          $(".pay").show();
          $(".eftpos_status").hide();
        }
        else if ("SIGNATURE REQD" == text1) {
          $(".display-msg").empty();
          $(".display-msg").text(text1 +' '+ text2);
          $(".display-msg").append('<img style="width: 30%" src ="images/payment/icon-06.png"></img>');

        } else if ("SIGNATURE OK Y/N?" == text1) {
          $(".display-msg").empty();
          $(".display-msg").text(text1 +' '+ text2);
          $(".display-msg").append('<img style="width: 30%" src ="images/payment/icon-06.png"></img>');
          $(".eftpos_status").find("button").remove();
          $(".eftpos_status").find(".modal-content").append('<button class="btn btn-success accept-sign">Yes</button><button class="btn btn-primary decline-sign">No</button>');
          $(".accept-sign").click(function(){
            presssButton(self.socket, 'Yes');
          });
          $(".decline-sign").click(function(){
            presssButton(self.socket, 'No');
          });
        }
        else if("SIG DECLINED" == text1 || "DECLINED" == text1 || "ACCOUNT ERROR" == text1){
          $(".display-msg").empty();
          $(".display-msg").append('<p>' +a + '</p>');
          $(".display-msg").append('<div><img style="width: 30%" class="payment-img" src ="images/payment/icon-04.png"></img></div>');
        }

      } else if ('ClearDisplay' == messageType) {
        $(".eftpos_status").hide();
        $(".modal-backdrop").hide();
      } else if ('Transaction' == messageType) {
        var responsetext = response.message.responsetext;
        var txndatetime = response.message.txndatetime;
        var txndatetime = response.message.txndatetime;
        var txnref = response.message.txnref;
        var txntype = response.message.txntype;

        if("INCORRECT PIN" == responsetext || "SIGN DECLINED" == responsetext) {
          $(".eftpos_status").hide();
          $(".pay").show();
          $(".modal-backdrop").show();
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

  refund(self.socket, txnRef, amount);
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
        $(".eftpos_status").find("button").remove();
        if(text1 == true) {
          text1 = "";
        }
        if(text2 == true) {
          text2 = "";
        }
        //Show status box
        $(".pay").hide();
        $(".eftpos_status").show();
        var a =text1 +' '+ text2;
        $(".display-msg").empty();
        $(".display-msg").append('<p>' +a + '</p>');
        if("PRESENT/INSERT" == text1) {
          $(".display-msg").empty();
          $(".display-msg").append('<p>' +a + '</p>');
          $(".display-msg").append('<div><img style="width: 30%" class="payment-img" src ="app/images/payment/icon-01.png"></img></div>');
        }
        else if("AWAITING ACCOUNT" == text1 ||"PROCESSING NOW" == text1 ||"AWAITING PIN" == text1){
          $(".display-msg").empty();
          $(".display-msg").append(text1 +' ' + text2 );
          $(".display-msg").append('<div><img style="width: 30%" class="payment-img" src ="app/images/payment/icon-02.png"></img></div>');
        }
        else if ("ACCEPTED" == text1 ||"SIG ACCEPTED" == text1 ) {
          $(".display-msg").empty();
          $(".display-msg").text(text1 +' '+ text2);
          $(".display-msg").append('<div><img style="width: 30%" class="payment-img" src ="app/images/payment/icon-03.png"></img></div>');
        }
        else if ("INCORRECT PIN" == text1) {
          $(".display-msg").empty();
          $(".display-msg").text(text1 +' '+ text2);
          $(".display-msg").append('<div><img style="width: 30%" class="payment-img" src ="app/images/payment/icon-05.png"></img></div>');
        }

        //IF transaction cancelled
        else if("TRANS. CANCELLED" == text1) {
          $(".display-msg").empty();
          $(".pay").show();
          $(".eftpos_status").hide();
        }
        else if ("SIGNATURE REQD" == text1) {
          $(".display-msg").empty();
          $(".display-msg").text(text1 +' '+ text2);
          $(".display-msg").append('<img style="width:30%" src ="app/images/payment/icon-06.png"></img>');

        } else if ("SIGNATURE OK Y/N?" == text1) {
          $(".display-msg").empty();
          $(".display-msg").text(text1 +' '+ text2);
          $(".display-msg").append('<img  style = "width:30%" src ="app/images/payment/icon-06.png"></img>');
          $(".eftpos_status").find("button").remove();
          $(".eftpos_status").find(".modal-content").append('<button class="btn btn-success accept-sign">Yes</button><button class="btn btn-primary decline-sign">No</button>');
          $(".accept-sign").click(function(){
            presssButton(self.socket, 'Yes');
          });
          $(".decline-sign").click(function(){
            presssButton(self.socket, 'No');
          });
        }
        else if("SIG DECLINED" == text1 || "DECLINED" == text1 || "ACCOUNT ERROR" == text1){
          $(".display-msg").empty();
          $(".display-msg").append('<p>' +a + '</p>');
          $(".display-msg").append('<div><img style="width: 30%" class="payment-img" src ="app/images/payment/icon-04.png"></img></div>');
        }

      } else if ('ClearDisplay' == messageType) {
        $(".eftpos_status").hide();
        $(".modal-backdrop").hide();
      } else if ('Transaction' == messageType) {
        var responsetext = response.message.responsetext;
        var txndatetime = response.message.txndatetime;
        var txndatetime = response.message.txndatetime;
        var txnref = response.message.txnref;
        var txntype = response.message.txntype;

        if("INCORRECT PIN" == responsetext || "SIGN DECLINED" == responsetext) {
          $(".eftpos_status").hide();
          $(".pay").show();
          $(".modal-backdrop").show();
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

function refund(socket, txnRef, amount){
  var message = '<Message type="Transaction" id="1234">';
  message += '<TxnType>Refund</TxnType>';
  message += '<TxnRef>' + txnRef + '</TxnRef>';
  message += '<AmountRefund>' + amount + '</AmountRefund>';
  message += '</Message>\n';
  socket.send(message);
}

function purchase(socket, txnRef, amount, remains) {
  var message = '<Message type="Transaction" id="1234">';
  message += '<TxnType>Purchase</TxnType>';
  message += '<TxnRef>' + txnRef + '</TxnRef>';
  message += '<AmountPurchase>' + amount + '</AmountPurchase>';
  message += '<AmountChasOut>' + remains + '</AmounCashOut>';
  message += '</Message>\n';
  socket.send(message);
}

function presssButton(socket, button) {
  var message = '<Message type="Button" id="1234">';
  message += '<Button>' + button + '</Button>';
  message += '</Message>';
  socket.send(message);
}
