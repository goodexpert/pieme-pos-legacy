


Datastore_sqlite = function() {
  //var e, t = function() {};

  // Web SQL Database
  var db = openDatabase('onzsadb', '1.0', 'onzsa database', 2 * 1024 * 1024);
  return {
    _doDSTransaction: function(exec, suc, err) {
      //console.log("[TRANS] START: "),
      //exec ? console.log(exec) : console.log("[TRANS] START: exec: null"),
      //suc ? console.log(suc) : console.log("[TRANS] START: suc: null"),
      //err ? console.log(err) : console.log("[TRANS] START: err: null")

      var success, error;
      success = function() {
        "function" == typeof suc && suc()
      },
      error = function() {
        "function" == typeof err && err()
      };
      try {
        //console.log("[TRANS] BEFORE TRANSACTION: ")
        db.transaction(exec, error, success)
      } catch (o) {
        //console.log("[TRANS] TRANSACTION: Exception")
        err(o)
      }
    },
    _executeDSSql: function(tr, sql, param, suc, err) {
      var continueCall, success, error;
      try {
        //console.log("[EXEC] START: "),
        //tr ? console.log(tr) : console.log("[EXEC] START: tr: null"),
        //sql ? console.log(sql) : console.log("[EXEC] START: sql: null"),
        //param ? console.log(param) : console.log("[EXEC] START: param: null"),
        //suc ? console.log(suc) : console.log("[EXEC] START: suc: null")
        //err ? console.log(err) : console.log("[EXEC] START: err: null")

        //console.log("[EXEC] BEFORE MAKE CONTINUECALL: "),
        continueCall = function(tr2) {
          //console.log("[EXEC] CONTINUECALL START: "),tr2 ? console.log(tr2) : console.log("[EXEC] CONTINUECALL START: tr2: null"),

          success = function(tr3, rs) {
            //console.log("[EXEC] CONTINUECALL TR2 SUCCESS START: "),tr3 ? console.log(tr3) : console.log("[EXEC] CONTINUECALL TR2 SUCCESS: tr3: null"),
            "function" == typeof suc && suc(tr3, rs)
          },

          error = function(e) {
            var errInfo = {
              sql: sql,
              params: param
            };
            //console.log("[EXEC] CONTINUECALL TR2 ERR START: "),console.log(e),
            "function" == typeof err && err(errInfo)
          },

          //console.log("[EXEC] CONTINUECALL BEFORE TR2 EXECUTE : "),
          tr2.executeSql(sql, param, success, error)
        },
        //console.log("[EXEC] BEFORE CONTINUECALL : "),
        tr ? continueCall(tr) : db.transaction(continueCall, err, suc)
        //console.log("[EXEC] END: ")
      } catch (s) {
        console.log("[EXEC] EXECUTE ERROR " + s.message)
      }
    },

    // 콜벡 처리 필요없는 여러개의 쿼리를 트랜젝션 처리 하는 예제
    // 중간에 쿼리가 실패하면 트랜젝션 처리 되어서 저장 않되고 실패한 쿼리의 에러가 호출된 후
    // 트랜젝션의 성공처리가 실행됨.
    testCall: function(e) {
      console.log("[TEST] START: "),
      e ? console.log(e) : console.log("[TEST] START: e: null");
      var t = this;
      console.log("[TEST] BEFORE TRANSACTION: "),
      t._doDSTransaction(
        function(tr) {
          console.log("[TEST] BEFORE EXECUTE: "), tr ? console.log(tr) : console.log("[TEST] BEFORE EXECUTE: tr: null")
          t._executeDSSql(tr, "DROP TABLE IF EXISTS TEST1", []),
          t._executeDSSql(tr, "DROP TABLE IF EXISTS TEST2", []),
          t._executeDSSql(tr, "DROP TABLE IF EXISTS TEST3", []),
          t._executeDSSql(tr, "DROP TABLE IF EXISTS TEST4", []),
          t._executeDSSql(tr, "CREATE TABLE IF NOT EXISTS TEST1 (id TEXT PRIMARY KEY ON CONFLICT REPLACE, name TEXT)", [], function() {console.log("[TEST] TRANS EXEC TEST1: SUCCESS")}, function() {console.log("[TEST] TRANS EXEC TEST1: ERROR")}),
          t._executeDSSql(tr, "CREATE TABLE IF NOT EXISTS TEST2 (id TEXT PRIMARY KEY ON CONFLICT REPLACE, name TEXT)", [], function() {console.log("[TEST] TRANS EXEC TEST2: SUCCESS")}, function() {console.log("[TEST] TRANS EXEC TEST2: ERROR")}),
          t._executeDSSql(tr, "CREATE TABLE IF NOT EXISTS TEST3 (id TEXT PRIMARY KEY ON CONFLICT REPLACE, name TEXT)", [], function() {console.log("[TEST] TRANS EXEC TEST3: SUCCESS")}, function() {console.log("[TEST] TRANS EXEC TEST3: ERROR")}),
          t._executeDSSql(tr, "CREATE TABLE IF NOT EXISTS TEST4 (id TEXT PRIMARY KEY ON CONFLICT REPLACE, name TEXT)", [], function() {console.log("[TEST] TRANS EXEC TEST4: SUCCESS")}, function() {console.log("[TEST] TRANS EXEC TEST4: ERROR")})
        },
        function() {console.log("[TEST] TRANS: SUCCESS")},
        function() {console.log("[TEST] TRANS: ERROR")}
      )
    },
    // 콜벡을 받아와서 각 쿼리에 세팅하면 각 쿼리의 성공여부에 따라서 콜러에게 전달 할 수 있다.
    // 각 쿼리의 성공/실패 함수에 변수 셋팅하도록 하면 전체 결과에 대해 판단 가능하다.
    // 트랜젝션은 성공 처리됨.
    testCall2: function(callback) {
      console.log("[TEST] START: "),
      callback ? console.log(callback) : console.log("[TEST] START: callback: null");
      var t = this, f1 = false, f2 = false, f3 = false, f4 = false;
      console.log("[TEST] BEFORE TRANSACTION: "),
      t._doDSTransaction(
        function(tr) {
          console.log("[TEST] BEFORE EXECUTE: "), tr ? console.log(tr) : console.log("[TEST] BEFORE EXECUTE: tr: null")
          t._executeDSSql(tr, "CREATE1 TABLE IF NOT EXISTS TEST1 (id TEXT PRIMARY KEY ON CONFLICT REPLACE, name TEXT)", [], function() { callback("[TEST] CALL-BACK1 OK"), f1 = true }, function() { callback("[TEST] CALL-BACK1 NG")} )
          t._executeDSSql(tr, "CREATE TABLE IF NOT EXISTS TEST2 (id TEXT PRIMARY KEY ON CONFLICT REPLACE, name TEXT)", [], function() { callback("[TEST] CALL-BACK2 OK"), f2 = true }, function() { callback("[TEST] CALL-BACK2 NG")} )
          t._executeDSSql(tr, "CREATE1 TABLE IF NOT EXISTS TEST3 (id TEXT PRIMARY KEY ON CONFLICT REPLACE, name TEXT)", [], function() { callback("[TEST] CALL-BACK3 OK"), f3 = true }, function() { callback("[TEST] CALL-BACK3 NG")} )
          t._executeDSSql(tr, "CREATE TABLE IF NOT EXISTS TEST4 (id TEXT PRIMARY KEY ON CONFLICT REPLACE, name TEXT)", [], function() { callback("[TEST] CALL-BACK4 OK"), f4 = true }, function() { callback("[TEST] CALL-BACK4 NG")} )
        },
        function() {console.log("[TEST] TRANS: SUCCESS"),
            console.log("Sub Query F1 success: " + f1),
            console.log("Sub Query F2 success: " + f2),
            console.log("Sub Query F3 success: " + f3),
            console.log("Sub Query F4 success: " + f4)
        },
        function() {console.log("[TEST] TRANS: ERROR")}
      )
    },
    _log: function(funcName, logText, logData) {
      console.log("[ONZSA-DS] " + funcName + ": " + logText)
      if(logData != null)console.log(logData)
    },

    initLocalDataStore: function() {
      var t = this;
      t._log("initLocalDataStore", "Start");
      t._doDSTransaction(function(tr) {
        t.initPriceBook(tr), t.initProducts(tr), t.initRegisterSaleItems(tr), t.initRegisterSales(tr), t.initRegisterSalePayment(tr)
      })
    },
    initPriceBook: function(tr){
      var e = this;
      t._log("initPriceBook", "Start");
      e._doDSTransaction(function(t) {
        e._executeDSSql(t, "DROP TABLE IF EXISTS PriceBookEntry", [], null, function(){ } );
        e._executeDSSql(t, "CREATE TABLE IF NOT EXISTS PriceBookEntry ( id TEXT PRIMARY KEY ON CONFLICT REPLACE, product_id TEXT, customer_group_id TEXT, outlet_id TEXT, markup REAL, discount REAL, price REAL, tax REAL, price_include_tax REAL, loyalty_value REAL, min_units REAL, max_units REAL, is_default INT, valid_from TEXT, valid_to TEXT)");
      })
    },
    initProducts: function(){
      var e = this;
      e._doDSTransaction(function(t) {
        e._executeDSSql(t, "DROP TABLE IF EXISTS Products", []);
        e._executeDSSql(t, "CREATE TABLE IF NOT EXISTS Products ( " +
            "id TEXT PRIMARY KEY ON CONFLICT REPLACE" +
            ", name TEXT" +
            ", handle TEXT" +
            ", description TEXT" +
            ", brand_name TEXT" +
            ", supplier_name TEXT" +
            ", sku TEXT" +
            ", supplier_price REAL" +
            ", price REAL" +
            ", tax REAL" +
            ", tax_name TEXT" +
            ", tax_rate REAL" +
            ", retail_price REAL" +
            ", thumbnail TEXT" +
            ", image TEXT" +
            " )");
      })
    },
    initRegisterSales: function(){
      var e = this;
      e._doDSTransaction(function(t) {
        e._executeDSSql(t, "DROP TABLE IF EXISTS RegisterSales", []);
        e._executeDSSql(t, "CREATE TABLE IF NOT EXISTS RegisterSales  ( id TEXT PRIMARY KEY ON CONFLICT REPLACE, register_id TEXT, user_id TEXT, customer_id TEXT, xero_invoice_id TEXT, receipt_number INTEGER, status TEXT, total_cost REAL, total_price REAL, total_price_incl_tax REAL, total_discount REAL, total_tax REAL, note TEXT, sale_date TEXT)");
      })
    },

    initRegisterSaleItems: function(){
      var e = this;
      e._doDSTransaction(function(t) {
        e._executeDSSql(t, "DROP TABLE IF EXISTS RegisterSaleItems", []);
        e._executeDSSql(t, "CREATE TABLE IF NOT EXISTS RegisterSaleItems ( id TEXT PRIMARY KEY ON CONFLICT REPLACE, sale_id TEXT, product_id TEXT, name TEXT, quantity REAL, supply_price REAL, price REAL, price_include_tax REAL, tax REAL, tax_rate REAL, discount REAL, loyalty_value  REAL, sequence INTEGER, status TEXT)")
      })
    },

    initRegisterSalePayment: function(tr){
      var t = this;
      t._doDSTransaction(function(tr) {
        t._executeDSSql(tr, "DROP TABLE IF EXISTS RegisterSalePayments", []);
        t._executeDSSql(tr, "CREATE TABLE IF NOT EXISTS RegisterSalePayments (" +
            "id TEXT PRIMARY KEY ON CONFLICT REPLACE, sale_id TEXT, register_id TEXT, " +
            "payment_type_id INTEGER, merchant_payment_type_id TEXT, amount REAL, payment_date TEXT)")
      })
    },

    saveRegisterSalePayments: function(data, suc, err) {
      var t = this, input = [data.id, data.sale_id, data.register_id, data.payment_type_id, data.merchant_payment_type_id, data.amount, data.payment_date];
      t._doDSTransaction(function(tr) {
        t._executeDSSql(tr, "INSERT or replace INTO RegisterSalePayments " +
            "(id, sale_id, register_id, payment_type_id, merchant_payment_type_id, amount, payment_date) " +
            "VALUES (?, ?, ?, ?, ?, ?, ?)", input, suc, err);
      });
    },

    deleteRegisterSalePayments: function(data, suc, err) {
      var t = this, condition = [data.sale_id];
      //console.log(condition),
      t._doDSTransaction(function(tr) {
        t._executeDSSql(tr, "DELETE FROM RegisterSalePayments WHERE sale_id = ?", condition, suc, err);
      });
    },

    getRegisterSalePayments: function(data, suc, err) {
      var t = this, input = [data.sale_id],success;
      success = function(tr, rt) {
        var rs = rt.rows, i=0, resultSet = [];
        for(i = 0; i < rs.length; i++){
          resultSet.push(rs.item(i));
        }
        suc(resultSet);
      };
      t._doDSTransaction(function(tr) {
        t._executeDSSql(tr, "SELECT * FROM RegisterSalePayments WHERE sale_id = ?" , input, success, err);
      });
    },

    saveRegisterSales: function(saveArray, suc, err){
      var i = saveArray;
      var n = this;
      var inputValues = [i.id, i.register_id, i.user_id, i.customer_id, i.xero_invoice_id, i.receipt_number, i.status, i.total_cost, i.total_price, i.total_price_incl_tax, i.total_discount, i.total_tax, i.note, i.sale_date];
      try{
        n._doDSTransaction(function(e) {
          n._executeDSSql(e, "INSERT or replace INTO RegisterSales (id, register_id, user_id, customer_id, xero_invoice_id, receipt_number, status, total_cost, total_price, total_price_incl_tax, total_discount, total_tax, note, sale_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", inputValues, suc, err);
        });
      }catch(ex){
        n._logDBError(ex.message);
      }
    },

    changeStatusRegisterSales: function(data, suc, err) {
      var t = this, condition = [data.status, data.id];
          t._doDSTransaction(function(tr) {
            t._executeDSSql(tr, "UPDATE RegisterSales SET status = ? WHERE id = ?", condition, suc, err);
          });
    },

    // 1 item
    saveRegisterSalesItem: function(saveArray, suc, err){
      var i = saveArray;
      var n = this;
      var inputValues = [i.id, i.sale_id, i.product_id, i.name, i.quantity, i.supply_price, i.price, i.price_include_tax, i.tax, i.tax_rate, i.discount, i.loyalty_value, i.sequence, i.status];
      try{
        n._doDSTransaction(function(e) {
          n._executeDSSql(e, "INSERT or replace INTO RegisterSaleItems (id, sale_id, product_id, name, quantity, supply_price, price, price_include_tax, tax, tax_rate, discount, loyalty_value, sequence, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", inputValues, suc, err);
        });
      }catch(ex){
        n._logDBError(ex.message);
      }
    },

    // lots items
    saveRegisterSalesItems: function(e, saveArray){
      var i = [];
      var n = this;
      var inputValues = [];

      for(var k=0; k < saveArray.length; k++)	{
        i = saveArray[k];
        inputValues.push([i.id, i.sale_id, i.product_id, i.name, i.quantity, i.supply_price, i.price, i.price_include_tax, i.tax, i.tax_rate, i.discount, i.loyalty_value, i.sequence, i.status]);
      }

      try{
        n._doDSTransaction(function(e) {
          for(var j=0; j < inputValues.length; j++){
            var inputValue = inputValues[j];
            n._executeDSSql(e, "INSERT or replace INTO RegisterSaleItems (id, sale_id, product_id, name, quantity, supply_price, price, price_include_tax, tax, tax_rate, discount, loyalty_value, sequence, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", inputValue);
          }
        });
      }catch(ex){
        n._logDBError(ex.message);
      }
    },

    saveRegisterAll: function(callBack, salesArray, salesItems){
      var self = this;
      var inputSale = [salesArray.id, salesArray.register_id, salesArray.user_id, salesArray.customer_id, salesArray.xero_invoice_id, salesArray.receipt_number, salesArray.status, salesArray.total_cost, salesArray.total_price, salesArray.total_price_incl_tax, salesArray.total_discount, salesArray.total_tax, salesArray.note, salesArray.sale_date];
      var i = [];
      var inputItems = [];

      for(var k=0; k < salesItems.length; k++)	{
        i = salesItems[k];
        inputItems.push([i.id, i.sale_id, i.product_id, i.name, i.quantity, i.supply_price, i.price, i.price_include_tax, i.tax, i.tax_rate, i.discount, i.loyalty_value, i.sequence, i.status]);
      }

      try{
        self._doDSTransaction(function(e) {
          self._executeDSSql(e, "INSERT or replace INTO RegisterSales (id, register_id, user_id, customer_id, xero_invoice_id, receipt_number, status, total_cost, total_price, total_price_incl_tax, total_discount, total_tax, note, sale_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", inputSale,
              function(e) {
                console.log("CallBack");
              });
          //for(var j=0; j < inputItems.length; j++){
          //  var inputValue = inputItems[j];
          //  self._executeDSSql(e, "INSERT or replace INTO RegisterSaleItems (id, sale_id, product_id, name, quantity, supply_price, price, price_include_tax, tax, tax_rate, discount, loyalty_value, sequence, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", inputValue);
          //}
        }, function(e) {
          console.log("Transaction Error: " + e.message);
        }, function(rs) {
          console.log("Transaction Success: ");
        });
      }catch(ex){
        self._logDBError(ex.message);
      }
    },

    getRegisterSales: function(statusCode, suc, err) {

      var t, a, n = this, searchValue = [], queryString = '';

      if(statusCode == null){
        queryString = "SELECT * FROM RegisterSales";
      }else if(statusCode == 'all'){
        queryString = "SELECT * FROM RegisterSales where status in ('sale_status_open', 'sale_status_layby', 'sale_status_saved', 'sale_status_onaccount')";
      }else{
        queryString = "SELECT * FROM RegisterSales where status = ? ";
        searchValue.push(statusCode);
      }

      t = function(t, a) {
        var rs = a.rows, i=0;
        var resultSet = [];
        for(i = 0; i < rs.length; i++){
          resultSet.push(rs.item(i));
        }
        typeof(suc) == 'function' && suc(resultSet);

      }, n._doDSTransaction(function(e) {
        n._executeDSSql(e, queryString, searchValue, t, err)
      })
    },

    getRegisterSaleItems: function(saleId, suc, err) {

      var t = this, searchValue = [], queryString = '', success;

      if(saleId == null){
        console.log('1');
        queryString = "SELECT * FROM RegisterSaleItems where status = 'sale_item_status_open'";
      }else{
        queryString = "SELECT * FROM RegisterSaleItems where sale_id = ? ";
        searchValue = [saleId];
      }
      success = function(tr, rt) {
        var rs = rt.rows, i=0;
        var resultSet = [];

        for(i = 0; i < rs.length; i++){
          resultSet.push(rs.item(i));
        }

        typeof(suc) == 'function' && suc(resultSet);
      }, t._doDSTransaction(function(tr) {
            t._executeDSSql(tr, queryString, searchValue, success, err)
      })
    },

    getPriceBook: function(e, productInfo) {

      var t, a, n = this,
          outletId, productId, customergroupId, pqty = null,
          queryString = "", searchValue = [];
      var today = new Date();
      var strToday = today.getFullYear() + "-" + (today.getMonth() + 1) + "-" + today.getDate();

      if(productInfo.outletId == null){
        queryString = "SELECT * FROM PriceBookEntry WHERE is_default = 1 and product_id = ?";
        if( productInfo.productId !== null){ searchValue.push(productInfo.productId);}
      }else if(productInfo.pqty==null || productInfo.pqty <= 1){
        queryString = "SELECT * FROM PriceBookEntry WHERE product_id = ? and outlet_id = ? and customer_group_id = ? and valid_from <= ? and valid_to >= ?";
        if( productInfo.productId !== null){ searchValue.push(productInfo.productId);}
        if( productInfo.outletId !== null){ searchValue.push(productInfo.outletId);}
        if( productInfo.customergroupId !== null){ searchValue.push(productInfo.customergroupId);} else { searchValue.push(null); }
        searchValue.push(strToday); searchValue.push(strToday);
      }else{
        queryString = "SELECT * FROM PriceBookEntry WHERE product_id = ? and outlet_id = ? and customer_group_id = ? and valid_from <= ? and valid_to >= ? and min_units <= ? and max_units >= ?";
        if( productInfo.productId !== null){ searchValue.push(productInfo.productId);}
        if( productInfo.outletId !== null){ searchValue.push(productInfo.outletId);}
        if( productInfo.customergroupId !== null){ searchValue.push(productInfo.customergroupId);} else { searchValue.push(null); }
        searchValue.push(strToday); searchValue.push(strToday);
        if( productInfo.pqty !== null){ searchValue.push(productInfo.pqty); searchValue.push(productInfo.pqty);}
        console.log(searchValue);
      }

      t = function(t, a) {
        var rs = a.rows, i=0;
        var resultSet = [];
        for(i = 0; i < rs.length; i++){
          resultSet.push(rs.item(i));
        }
        e(resultSet);
      }, n._doDSTransaction(function(e) {
        n._executeDSSql(e, queryString, searchValue, t)
      })
    },

    savePriceBook: function(e, saveArray) {
      var i = saveArray;
      var n = this;
      var inputValues = [i.id, i.customer_group_id, i.product_id, i.outlet_id, i.markup, i.discount, i.price, i.tax, i.price_include_tax, i.loyalty_value, i.min_units, i.max_units, i.is_default, i.valid_from, i.valid_to];
      try{
        n._doDSTransaction(function(e) {
          console.log(saveArray);
          n._executeDSSql(e, "INSERT or replace INTO PriceBookEntry (id, customer_group_id, product_id, outlet_id, markup, discount, price, tax, price_include_tax, loyalty_value, min_units, max_units, is_default, valid_from, valid_to) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", inputValues);
        });
      }catch(ex) {
        n._logDBError(ex.message);
      }
    },

    getProduct: function(successCallback, searchData) {
      var excuteCallback, t = this;
      var sqlQuery = "SELECT * FROM Products WHERE id = ? or name like ? or sku like ? or name like ? ";
      var searchValues = [null, null, null, null];

			if(searchData != null && searchData.id != null){searchValues[0] = searchData.id;}
			else if(searchData != null && searchData.handle != null){searchValues[1] = "%" + searchData.handle + "%";}
			else if(searchData != null && searchData.sku != null){searchValues[2] = "%" + searchData.sku + "%";}
			else if(searchData != null && searchData.name != null){searchValues[3] = "%" + searchData.name + "%";}

      excuteCallback = function(e, a) {
        var resultset = a.rows, i=0;
        var outputData = [];
        for(i = 0; i < resultset.length; i++){
          outputData.push(resultset.item(i));
        }
        successCallback(outputData);
      },
          t._doDSTransaction(
              function(e) {
                t._executeDSSql(e, sqlQuery, searchValues, excuteCallback, t._logDBError)
              }
          )
    },

    setProducts: function(successCallback, setData) {
      var t = this;
      var sqlQuery = "INSERT  INTO Products (" +
          "  id, name, handle, description, brand_name, supplier_name, sku" +
          ", supplier_price, price, tax, tax_name, tax_rate, retail_price" +
          ", thumbnail, image" +
          ") values (" +
          "  ?, ?, ?, ?, ?, ?, ?" +
          ", ?, ?, ?, ?, ?, ?" +
          ", ?, ?" +
          ")";
      var setValues = [], i = 0;
      for(i = 0; i < setData.length; i++){
        var data = [
          setData[i].id, setData[i].name, setData[i].handle, setData[i].description, setData[i].brand_name, setData[i].supplier_name, setData[i].sku,
          setData[i].supplier_price, setData[i].price, setData[i].tax, setData[i].tax_name, setData[i].tax_rate, setData[i].price_include_tax,
          setData[i].image, setData[i].image_large
        ];
        setValues.push(data);
      }
      try{
        t._doDSTransaction(function(e) {
          for(i = 0; i < setValues.length; i++) {
            t._executeDSSql(e, sqlQuery, setValues[i], function(ts, rs) {
              console.log("Success Set execute: " + rs.insertId);
            }, t._logDBError);
          }
        }, function(e) {
          console.log("Transaction Error: " + e.message);
        }, function() {
          console.log("Transaction Success: ");
        });
      }catch(e){
        n._logDBError(e.message);
      }
    },

  }
}();

// -----------------    BEGIN Local Storage   ---------------
var Database_localstorage = function() {
  return {
    setLSKey: function(key) {
      localStorage.setItem(key, '');
    },
    removeLSKey: function(key) {
      localStorage.removeItem(key);
    },
    changeLSKey: function(fromKey, toKey) {
      var data = localStorage.getItem(fromKey);
      localStorage.removeItem(fromKey);
      localStorage.setItem(toKey, data);
    },
    setLSData: function(key, data) {
      localStorage.setItem(key, data);
    },
    getLSData: function(key) {
      return localStorage.getItem(key);
    },
    removeLSData: function(key) {
      localStorage.setItem(key, '');
    },
    clearLSData: function() {
      localStorage.clear();
    }
  }
};
// -----------------     END Local Storage   ---------------
