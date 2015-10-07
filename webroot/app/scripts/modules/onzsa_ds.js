Datastore_sqlite = function () {
  //var e, t = function() {};

  // Web SQL Database
  var version = {
    'major': 1,
    'minor': 0,
  }
  var volumes = 2 * 1024 * 1024;
  var db = openDatabase('onzsadb', version.major + '.' + version.minor, 'onzsa database', volumes);

  return {
    // == List ==
    // [Inside]
    // [Test]
    // [Common]
    // [RegisterTaxRates]
    // [RegisterPaymentTypes]
    // [Products]
    // [Registers]
    // [PriceBookEntery]
    // [RegisterSales]
    // [RegisterSaleItems]
    // [RegisterSalePayments]
    // [ETC]

    _logDBError: function (e) {
      var errorInfo = JSON.stringify(arguments);
      console.log("WebSQL Error: " + errorInfo + " " + arguments.error);
    },
    // -------------------
    //  [Inside] _doDSTransaction
    // ------------------- 
    _doDSTransaction: function (exec, suc, err) {
      //console.log("[TRANS] START: "),
      //exec ? console.log(exec) : console.log("[TRANS] START: exec: null"),
      //suc ? console.log(suc) : console.log("[TRANS] START: suc: null"),
      //err ? console.log(err) : console.log("[TRANS] START: err: null")

      var success, error;
      success = function () {
        "function" == typeof suc && suc()
      },
          error = function () {
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
    // -------------------
    //  [Inside] _executeDSSql
    // ------------------- 
    _executeDSSql: function (tr, sql, param, suc, err) {
      var continueCall, success, error;
      try {
        //console.log("[EXEC] START: "),
        //tr ? console.log(tr) : console.log("[EXEC] START: tr: null"),
        //sql ? console.log(sql) : console.log("[EXEC] START: sql: null"),
        //param ? console.log(param) : console.log("[EXEC] START: param: null")
        //suc ? console.log(suc) : console.log("[EXEC] START: suc: null")
        //err ? console.log(err) : console.log("[EXEC] START: err: null")

        //console.log("[EXEC] BEFORE MAKE CONTINUECALL: "),
        continueCall = function (tr2) {
          //console.log("[EXEC] CONTINUECALL START: "),tr2 ? console.log(tr2) : console.log("[EXEC] CONTINUECALL START: tr2: null"),

          success = function (tr3, rs) {
            //console.log("[EXEC] CONTINUECALL TR2 SUCCESS START: "),tr3 ? console.log(tr3) : console.log("[EXEC] CONTINUECALL TR2 SUCCESS: tr3: null"),
            "function" == typeof suc && suc(tr3, rs)
          },

              error = function (e) {
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

    // -------------------
    //  [Inside] _log
    // ------------------- 
    _log: function (funcName, logText, logData) {

      console.log("[ONZSA-DS] " + funcName + ": " + logText)
      if (logData != null && typeof(logData) == 'object') console.log(logData)
    },

    // ------------------------------------------------------------------------------------------------------------ //
    // [Common] ------------------------------------------------------------------------------------------ [Common] //
    // ------------------------------------------------------------------------------------------------------------ //

    // -------------------
    //  [Common] dropAllLocalDataStore
    // ------------------- 
    dropAllLocalDataStore: function () {
      var t = this, success, error;
      t._doDSTransaction(function (tr) {
        t._log("dropAllLocalDataStore", "Start");

        //TODO: RegisterTaxRates

        // RegisterPaymentTypes
        t._executeDSSql(tr, "DROP TABLE IF EXISTS RegisterPaymentTypes", [], function () {
          t._log("dropAllLocalDataStore", "RegisterPaymentTypes : Success")
        }, function (e) {
          t._log("dropAllLocalDataStore", "RegisterPaymentTypes : Error : " + e)
        });

        // Products
        t._executeDSSql(tr, "DROP TABLE IF EXISTS Products", [], function () {
          t._log("dropAllLocalDataStore", "Products : Success")
        }, function (e) {
          t._log("dropAllLocalDataStore", "Products : Error : " + e)
        });

        //TODO: Registers

        // PriceBookEntery
        t._executeDSSql(tr, "DROP TABLE IF EXISTS PriceBookEntry", [], function () {
          t._log("dropAllLocalDataStore", "PriceBookEntry : Success")
        }, function (e) {
          t._log("dropAllLocalDataStore", "PriceBookEntry : Error : " + e)
        });

        // RegisterSales
        t._executeDSSql(tr, "DROP TABLE IF EXISTS RegisterSales", [], function () {
          t._log("dropAllLocalDataStore", "RegisterSales : Success")
        }, function (e) {
          t._log("dropAllLocalDataStore", "RegisterSales : Error : " + e)
        });

        // RegisterSaleItems
        t._executeDSSql(tr, "DROP TABLE IF EXISTS RegisterSaleItems", [], function () {
          t._log("dropAllLocalDataStore", "RegisterSaleItems : Success")
        }, function (e) {
          t._log("dropAllLocalDataStore", "RegisterSaleItems : Error : " + e)
        });

        // RegisterSalePayments
        t._executeDSSql(tr, "DROP TABLE IF EXISTS RegisterSalePayments", [], function () {
          t._log("dropAllLocalDataStore", "RegisterSalePayments : Success")
        }, function (e) {
          t._log("dropAllLocalDataStore", "RegisterSalePayments : Error : " + e)
        });

      })
    },

    // -------------------
    //  [Common] initLocalDataStore
    // ------------------- 
    initLocalDataStore: function () {
      var t = this, success, error;
      t._doDSTransaction(function (tr) {
        t._log("initLocalDataStore", "Start");

        // Taxes
        t._executeDSSql(tr, "CREATE TABLE IF NOT EXISTS Taxes (id TEXT PRIMARY KEY ON CONFLICT REPLACE, merchant_id TEXT, name TEXT, rate TEXT, tax_type TEXT, is_default TEXT, is_deleted TEXT, created TEXT, modified TEXT, deleted TEXT)", [], function () {
          t._log("initLocalDataStore", "Taxes : Success")
        }, function (e) {
          t._log("initLocalDataStore", "Taxes : Error : " + e)
        });

        // RegisterPaymentTypes
        t._executeDSSql(tr, "CREATE TABLE IF NOT EXISTS RegisterPaymentTypes (id TEXT PRIMARY KEY ON CONFLICT REPLACE, merchant_id TEXT, payment_type_id INTEGER, name TEXT, config TEXT, account_code TEXT, is_active INTEGER, is_deleted INTEGER, created TEXT, modified TEXT, deleted TEXT)", [], function () {
          t._log("initLocalDataStore", "RegisterPaymentTypes : Success")
        }, function (e) {
          t._log("initLocalDataStore", "RegisterPaymentTypes : Error : " + e)
        })

        // Products
        t._executeDSSql(tr, "CREATE TABLE IF NOT EXISTS Products (id TEXT PRIMARY KEY ON CONFLICT REPLACE, merchant_id TEXT, name TEXT, handle TEXT, description TEXT, brand_name TEXT, supplier_name TEXT, sku TEXT, supply_price REAL, price REAL, product_uom TEXT, tax REAL, tax_name TEXT, tax_rate REAL, retail_price REAL, image TEXT, image_large TEXT)", [], function () {
          t._log("initLocalDataStore", "Products : Success")
        }, function (e) {
          t._log("initLocalDataStore", "Products : Error : " + e)
        });

        //TODO: Registers

        // PriceBookEntery
        t._executeDSSql(tr, "CREATE TABLE IF NOT EXISTS PriceBookEntry ( id TEXT PRIMARY KEY ON CONFLICT REPLACE, product_id TEXT, customer_group_id TEXT, outlet_id TEXT, markup REAL, discount REAL, price REAL, tax REAL, price_include_tax REAL, loyalty_value REAL, min_units REAL, max_units REAL, is_default INT, valid_from TEXT, valid_to TEXT, price_book_created TEXT)", [], function () {
          t._log("initLocalDataStore", "PriceBookEntry : Success")
        }, function (e) {
          t._log("initLocalDataStore", "PriceBookEntry : Error : " + e)
        });

        // RegisterSales
        t._executeDSSql(tr, "CREATE TABLE IF NOT EXISTS RegisterSales  ( id TEXT PRIMARY KEY ON CONFLICT REPLACE, register_id TEXT, user_id TEXT, user_name TEXT, customer_id TEXT, customer_name TEXT, customer_code TEXT, xero_invoice_id TEXT, receipt_number INTEGER, status TEXT, total_cost REAL, total_price REAL, total_price_incl_tax REAL, total_discount REAL, total_tax REAL, total_payment REAL, line_discount REAL, line_discount_type INTEGER, note TEXT, sale_date TEXT, sync_status TEXT, sync_date TEXT)", [], function () {
          t._log("initLocalDataStore", "RegisterSales : Success")
        }, function (e) {
          t._log("initLocalDataStore", "RegisterSales : Error : " + e)
        });

        // RegisterSaleItems
        t._executeDSSql(tr, "CREATE TABLE IF NOT EXISTS RegisterSaleItems ( id TEXT PRIMARY KEY ON CONFLICT REPLACE, sale_id TEXT, product_id TEXT, name TEXT, quantity REAL, product_uom TEXT, supply_price REAL, price REAL, sale_price REAL, tax REAL, tax_rate REAL, discount REAL, loyalty_value  REAL, sequence INTEGER, status TEXT)", [], function () {
          t._log("initLocalDataStore", "RegisterSaleItems : Success")
        }, function (e) {
          t._log("initLocalDataStore", "RegisterSaleItems : Error : " + e)
        })

        // RegisterSalePayments
        t._executeDSSql(tr, "CREATE TABLE IF NOT EXISTS RegisterSalePayments (id TEXT PRIMARY KEY ON CONFLICT REPLACE, sale_id TEXT, register_id TEXT, payment_type_id INTEGER, merchant_payment_type_id TEXT, amount REAL, payment_date TEXT)", [], function () {
          t._log("initLocalDataStore", "RegisterSalePayments : Success")
        }, function (e) {
          t._log("initLocalDataStore", "RegisterSalePayments : Error : " + e)
        })

      })
    },

    // ------------------------------------------------------------------------------------------------------------ //
    // [Taxes] -------------------------------------------------------------------------------------------- [Taxes] //
    // ------------------------------------------------------------------------------------------------------------ //
    //
    // CREATE TABLE IF NOT EXISTS Taxes
    // ( id TEXT PRIMARY KEY ON CONFLICT REPLACE,
    //  merchant_id TEXT,
    //  name TEXT,
    //  rate TEXT,
    //  tax_type TEXT,
    //  is_default TEXT,
    //  is_deleted TEXT,
    //  created TEXT,
    //  modified TEXT,
    //  deleted TEXT)
     //

    // -------------------
    //  [INIT] DROP & CREATE
    // ------------------- 
    initTaxes: function (tr) {
      var t = this;
      t._doDSTransaction(function (tr) {
        t._executeDSSql(tr, "DROP TABLE IF EXISTS Taxes", []);
        t._executeDSSql(tr, "CREATE TABLE IF NOT EXISTS Taxes (id TEXT PRIMARY KEY ON CONFLICT REPLACE, merchant_id TEXT, name TEXT, rate TEXT, tax_type TEXT, is_default TEXT, is_deleted TEXT, created TEXT, modified TEXT, deleted TEXT)")
      })
    },

    // -------------------
    //  [SAVE] INSERT OR REPLACE
    // ------------------- 
    saveTaxes: function (dataArray, suc, err) {
      var t = this;
      try {
        t._doDSTransaction(function (tr) {
          for (var idx = 0; idx < dataArray.length; idx++) {
            data = dataArray[idx];
            var value = [data.id, data.merchant_id, data.name, data.rate, data.tax_type, data.is_default, data.is_deleted, data.created, data.modified, data.deleted];
            t._executeDSSql(tr, "INSERT OR REPLACE INTO Taxes" +
                " (id, merchant_id, name, rate, tax_type, is_default, is_deleted, created, modified, deleted) " +
                " VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", value, suc, err);
          }

        });
      } catch (ex) {
        t._logDBError(ex.message);
      }
    },

    // -------------------
    //  [GET] SELECT
    // ------------------- 
    getTaxes: function (suc, dataArray /* Not use */, err) {
      var t = this,
          success = function (tr, result) {
            var rs = result.rows, i = 0;
            var resultSet = [];
            for (var i = 0; i < rs.length; i++) {
              resultSet.push(rs.item(i));
            }
            typeof(suc) == 'function' && suc(resultSet);
          };

      t._doDSTransaction(function (tr) {
        t._executeDSSql(tr, "SELECT * FROM Taxes", [], success, err)
      })
    },

    // ------------------------------------------------------------------------------------------------------------ //
    // [RegisterPaymentTypes] -------------------------------------------------------------- [RegisterPaymentTypes] //
    // ------------------------------------------------------------------------------------------------------------ //
    //
    // CREATE TABLE IF NOT EXISTS RegisterPaymentTypes
    // ( id TEXT PRIMARY KEY ON CONFLICT REPLACE,
    //  merchant_id TEXT,
    //  payment_type_id INTEGER,
    //  name TEXT,
    //  config TEXT,
    //  account_code TEXT,
    //  is_active TEXT,
    //  is_deleted TEXT,
    //  created TEXT,
    //  modified TEXT,
    //  deleted TEXT)
     //

    // -------------------
    //  [INIT] DROP & CREATE
    // ------------------- 
    initPaymentTypes: function (tr) {
      var t = this;
      t._doDSTransaction(function (tr) {
        t._executeDSSql(tr, "DROP TABLE IF EXISTS RegisterPaymentTypes", []);
        t._executeDSSql(tr, "CREATE TABLE IF NOT EXISTS RegisterPaymentTypes (id TEXT PRIMARY KEY ON CONFLICT REPLACE, merchant_id TEXT, payment_type_id INTEGER, name TEXT, config TEXT, account_code TEXT, is_active INTEGER, is_deleted INTEGER, created TEXT, modified TEXT, deleted TEXT)")
      })
    },

    // -------------------
    //  [SAVE] INSERT OR REPLACE
    // ------------------- 
    saveRegisterPaymentTypes: function (dataArray, suc, err) {
      var t = this;
      try {
        t._doDSTransaction(function (tr) {
          for (var idx = 0; idx < dataArray.length; idx++) {
            data = dataArray[idx];
            var value = [data.id, data.merchant_id, data.payment_type_id, data.name, data.config, data.account_code, data.is_active, data.is_deleted, data.created, data.modified, data.deleted];
            t._executeDSSql(tr, "INSERT OR REPLACE INTO RegisterPaymentTypes" +
                " (id, merchant_id, payment_type_id, name, config, account_code, is_active, is_deleted, created, modified, deleted) " +
                " VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", value, suc, err);
          }

        });
      } catch (ex) {
        t._logDBError(ex.message);
      }
    },

    // -------------------
    //  [GET] SELECT
    // ------------------- 
    getRegisterPaymentTypes: function (suc, dataArray /* Not use */, err) {
      var t = this,
          success = function (tr, result) {
            var rs = result.rows, i = 0;
            var resultSet = [];
            for (var i = 0; i < rs.length; i++) {
              resultSet.push(rs.item(i));
            }
            typeof(suc) == 'function' && suc(resultSet);
          };

      t._doDSTransaction(function (tr) {
        t._executeDSSql(tr, "SELECT * FROM RegisterPaymentTypes", [], success, err)
      })
    },


    // ------------------------------------------------------------------------------------------------------------ //
    // [Products] -------------------------------------------------------------------------------------- [Products] //
    // ------------------------------------------------------------------------------------------------------------ //
    //
    // CREATE TABLE IF NOT EXISTS Products (
    // id TEXT PRIMARY KEY ON CONFLICT REPLACE,
    // merchant_id TEXT,
    // name TEXT,
    // handle TEXT,
    // description TEXT,
    // brand_name TEXT,
    // supplier_name TEXT,
    // sku TEXT,
    // supply_price REAL,
    // price REAL,
    // product_uom TEXT,
    // tax REAL,
    // tax_name TEXT,
    // tax_rate REAL,
    // retail_price REAL,
    // image TEXT,
    // image_large TEXT)
     //

    // -------------------
    //  [INIT] DROP & CREATE
    // ------------------- 
    initProducts: function () {
      var e = this;
      e._doDSTransaction(function (t) {
        e._executeDSSql(t, "DROP TABLE IF EXISTS Products", []);
        e._executeDSSql(t, "CREATE TABLE IF NOT EXISTS Products ( " +
            "id TEXT PRIMARY KEY ON CONFLICT REPLACE" +
            ", merchant_id TEXT" +
            ", name TEXT" +
            ", handle TEXT" +
            ", description TEXT" +
            ", brand_name TEXT" +
            ", supplier_name TEXT" +
            ", sku TEXT" +
            ", supply_price REAL" +
            ", price REAL" +
            ", product_uom TEXT" +
            ", tax REAL" +
            ", tax_name TEXT" +
            ", tax_rate REAL" +
            ", retail_price REAL" +
            ", image TEXT" +
            ", image_large TEXT" +
            " )");
      })
    },

    // -------------------
    //  [GET] SELECT
    // ------------------- 
    getProduct: function (successCallback, searchData) {
      var excuteCallback, t = this;
      var sqlQuery = "SELECT * FROM Products WHERE (id = ? or name like ? or sku like ? or name like ?)";

      var searchValues = [null, null, null, null];
      if (searchData != null && searchData.discountProduct != null) {
        searchValues = [null, null, null, null, null];
        searchValues[4] = searchData.discountProduct;
        sqlQuery += " and id <> ? ";
      }

      if (searchData != null && searchData.id != null) {
        searchValues[0] = searchData.id;
      }
      else if (searchData != null && searchData.handle != null) {
        searchValues[1] = "%" + searchData.handle + "%";
      }
      else if (searchData != null && searchData.sku != null) {
        searchValues[2] = "%" + searchData.sku + "%";
      }
      else if (searchData != null && searchData.name != null) {
        searchValues[3] = "%" + searchData.name + "%";
      }

      excuteCallback = function (e, a) {
        var resultset = a.rows, i = 0;
        var outputData = [];
        for (i = 0; i < resultset.length; i++) {
          outputData.push(resultset.item(i));
        }
        successCallback(outputData);
      },
          t._doDSTransaction(
              function (e) {
                t._executeDSSql(e, sqlQuery, searchValues, excuteCallback, t._logDBError)
              }
          )
    },

    // -------------------
    //  [SAVE] INSERT OR REPLACE
    // ------------------- 
    saveProducts: function (successCallback, setData) {
      var t = this;
      var sqlQuery = "INSERT or REPLACE INTO Products (" +
          "  id, merchant_id, name, handle, description, brand_name, supplier_name, sku" +
          ", supply_price, price, product_uom, tax, tax_name, tax_rate, retail_price" +
          ", image, image_large" +
          ") values (" +
          "  ?, ?, ?, ?, ?, ?, ?, ?" +
          ", ?, ?, ?, ?, ?, ?, ?" +
          ", ?, ?" +
          ")";
      var setValues = [], i = 0;
      for (i = 0; i < setData.length; i++) {
        var data = [
          setData[i].id, setData[i].merchant_id, setData[i].name, setData[i].handle, setData[i].description, setData[i].brand_name, setData[i].supplier_name, setData[i].sku,
          setData[i].supply_price, setData[i].price, setData[i].product_uom, setData[i].tax, setData[i].tax_name, setData[i].tax_rate, setData[i].price_include_tax,
          setData[i].image, setData[i].image_large
        ];
        setValues.push(data);
      }
      try {
        t._doDSTransaction(function (e) {
          for (i = 0; i < setValues.length; i++) {
            t._executeDSSql(e, sqlQuery, setValues[i], function (ts, rs) {
              console.log("Success Set execute: " + rs.insertId);
            }, t._logDBError);
          }
        }, function (e) {
          console.log("Transaction Error: ");
        }, function () {
          console.log("Transaction Success: ");
        });
      } catch (e) {
        n._logDBError(e.message);
      }
    },

    // ------------------------------------------------------------------------------------------------------------ //
    // [Registers] ------------------------------------------------------------------------------------ [Registers] //
    // ------------------------------------------------------------------------------------------------------------ //
    //TODO: Registers

    // ------------------------------------------------------------------------------------------------------------ //
    // [PriceBookEntry] -------------------------------------------------------------------------- [PriceBookEntry] //
    // ------------------------------------------------------------------------------------------------------------ //

    // -------------------
    //  [INIT] DROP & CREATE
    // ------------------- 
    initPriceBook: function () {
      var e = this;
      //t._log("initPriceBook", "Start");
      e._doDSTransaction(function (t) {
        e._executeDSSql(t, "DROP TABLE IF EXISTS PriceBookEntry", [], null, function () {
        });
        e._executeDSSql(t, "CREATE TABLE IF NOT EXISTS PriceBookEntry ( id TEXT PRIMARY KEY ON CONFLICT REPLACE, product_id TEXT, customer_group_id TEXT, outlet_id TEXT, markup REAL, discount REAL, price REAL, tax REAL, price_include_tax REAL, loyalty_value REAL, min_units REAL, max_units REAL, is_default INT, valid_from TEXT, valid_to TEXT, price_book_created TEXT)");
      })
    },

    // -------------------
    //  [GET] SELECT
    // ------------------- 
    getPriceBook: function (e, productInfo) {

      var t, a, n = this,
          outletId, productId, customergroupId, pqty = null,
          queryString = "", searchValue = [];
      var strToday = (new Date()).format("yyyy-MM-dd");

      queryString = "SELECT * FROM PriceBookEntry WHERE" +
          " product_id = ? " +
          " and (outlet_id = ? or outlet_id is NULL) " +
          " and (customer_group_id = ? or customer_group_id = ?) " +
          " and ((valid_from <= ? and valid_to >= ?) or (valid_from <= ? and valid_to is NULL) or (valid_from is NULL and valid_to is NULL)) " +
          " and ((min_units <= ? and max_units >= ?) or (min_units is NULL and max_units is NULL))" +
          "order by price_book_created desc";
      if (productInfo.productId !== null) {
        searchValue.push(productInfo.productId);
      }
      if (productInfo.outletId !== null) {
        searchValue.push(productInfo.outletId);
      } else {
        searchValue.push(null);
      }
      if (productInfo.customerGroupId !== null) {
        searchValue.push(productInfo.customerGroupId);
      } else {
        searchValue.push(null);
      }
      if (productInfo.defCustomerGroupId !== null) {
        searchValue.push(productInfo.defCustomerGroupId);
      } else {
        searchValue.push(null);
      }

      searchValue.push(strToday);
      searchValue.push(strToday);
      searchValue.push(strToday);

      if (productInfo.pqty !== null) {
        searchValue.push(productInfo.pqty);
        searchValue.push(productInfo.pqty);
      } else {
        searchValue.push(null);
        searchValue.push(null);
      }
      //console.debug("GetPriceBook: sql: %s", queryString);
      //console.debug("GetPriceBook: val: %o", searchValue);


      t = function (t, a) {
        var rs = a.rows, i = 0;
        var resultSet = [];
        //console.debug("GetPriceBook: rs.length: %d", rs.length);
        for (i = 0; i < rs.length; i++) {
          resultSet.push(rs.item(i));
        }
        e(resultSet);
      }, n._doDSTransaction(function (tr) {
        n._executeDSSql(tr, queryString, searchValue, t, function(e){console.error(e)})
      })
    },

    // -------------------
    //  [SAVE] INSERT OR REPLACE
    // ------------------- 
    savePriceBook: function (e, saveArray) {
      var i = saveArray;
      var n = this;
      var inputValues = [i.id, i.customer_group_id, i.product_id, i.outlet_id, i.markup, i.discount, i.price, i.tax, i.price_include_tax, i.loyalty_value, i.min_units, i.max_units, i.is_default, i.valid_from, i.valid_to, i.price_book_created];
      try {
        n._doDSTransaction(function (e) {
          //console.log(saveArray);
          n._executeDSSql(e, "INSERT or replace INTO PriceBookEntry (id, customer_group_id, product_id, outlet_id, markup, discount, price, tax, price_include_tax, loyalty_value, min_units, max_units, is_default, valid_from, valid_to, price_book_created) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", inputValues);
        });
      } catch (ex) {
        n._logDBError(ex.message);
      }
    },

    // ------------------------------------------------------------------------------------------------------------ //
    // [RegisterSales] ---------------------------------------------------------------------------- [RegisterSales] //
    // ------------------------------------------------------------------------------------------------------------ //
    //
    // CREATE TABLE IF NOT EXISTS RegisterSales
    // ( id TEXT PRIMARY KEY ON CONFLICT REPLACE,
    //  register_id TEXT,
    //  user_id TEXT,
    //  user_name TEXT,
    //  customer_id TEXT,
    //  customer_name TEXT,
    //  customer_code TEXT,
    //  xero_invoice_id TEXT,
    //  receipt_number INTEGER,
    //  status TEXT,
    //  total_cost REAL,                // supply_price
    //  total_price REAL,               // price_exclude_tax (supply_price * markup)
    //  total_price_incl_tax REAL,      // retail_price (price + tax)
    //  total_discount REAL,
    //  total_tax REAL,                 // price * tax_rate
    //  total_payment REAL,             // Paid amount
    //  line_discount REAL,             // line discount number
    //  line_discount_type INTEGER,     // line discount type (0: percent, 1: currency)
    //  note TEXT,
    //  sale_date TEXT,
    //  sync_status TEXT,               // sync_wait | sync_success
    //  sync_date TEXT)
     //

    // -------------------
    //  [INIT] DROP & CREATE
    // ------------------- 
    initRegisterSales: function () {
      var e = this;
      e._doDSTransaction(function (t) {
        e._executeDSSql(t, "DROP TABLE IF EXISTS RegisterSales", []);
        e._executeDSSql(t, "CREATE TABLE IF NOT EXISTS RegisterSales  ( id TEXT PRIMARY KEY ON CONFLICT REPLACE, register_id TEXT, user_id TEXT, user_name TEXT, customer_id TEXT, customer_name TEXT, customer_code TEXT, xero_invoice_id TEXT, receipt_number INTEGER, status TEXT, total_cost REAL, total_price REAL, total_price_incl_tax REAL, total_discount REAL, total_tax REAL, total_payment REAL, line_discount REAL, line_discount_type INTEGER, note TEXT, sale_date TEXT, sync_status TEXT, sync_date TEXT)");
      })
    },

    // -------------------
    //  [SAVE] INSERT OR REPLACE
    // ------------------- 
    saveRegisterSales: function (suc, saveArray, err) {
      var i = [];
      var n = this;

      try {
        n._doDSTransaction(function (e) {
          for (var k = 0; k < saveArray.length; k++) {
            i = saveArray[k];
            var inputValues = [i.id, i.register_id, i.user_id, i.user_name, i.customer_id, i.customer_name, i.customer_code, i.xero_invoice_id, i.receipt_number, i.status, i.total_cost, i.total_price, i.total_price_incl_tax, i.total_discount, i.total_tax, i.total_payment, i.line_discount, i.line_discount_type, i.note, i.sale_date, i.sync_status, i.sync_date];
            //console.log("inputValues : %o",inputValues);
            n._executeDSSql(e, "INSERT or replace INTO RegisterSales (id, register_id, user_id, user_name, customer_id, customer_name, customer_code, xero_invoice_id, receipt_number, status, total_cost, total_price, total_price_incl_tax, total_discount, total_tax, total_payment, line_discount, line_discount_type, note, sale_date, sync_status, sync_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", inputValues, suc, err);
          }
        });
      } catch (ex) {
        n._logDBError(ex.message);
      }
    },

    // -------------------
    //  [CHANGE] UPDATE
    // ------------------- 
    changeRegisterSales: function (data, suc, err) {
      var t = this, condition = [], sqlParamString = "";

      if (data.customer_id != null) {
        condition.push(data.customer_id);
        if (sqlParamString != "") sqlParamString += ",";
        sqlParamString += " customer_id = ?";
      }
      if (data.customer_name != null) {
        condition.push(data.customer_name);
        if (sqlParamString != "") sqlParamString += ",";
        sqlParamString += " customer_name = ?";
      }
      if (data.customer_code != null) {
        condition.push(data.customer_code);
        if (sqlParamString != "") sqlParamString += ",";
        sqlParamString += " customer_code = ?";
      }
      if (data.status != null) {
        condition.push(data.status);
        if (sqlParamString != "") sqlParamString += ",";
        sqlParamString += " status = ?";
      }
      if (data.total_cost != null) {
        condition.push(data.total_cost);
        if (sqlParamString != "") sqlParamString += ",";
        sqlParamString += " total_cost = ?";
      }
      if (data.total_price != null) {
        condition.push(data.total_price);
        if (sqlParamString != "") sqlParamString += ",";
        sqlParamString += " total_price = ?";
      }
      if (data.total_price_incl_tax != null) {
        condition.push(data.total_price_incl_tax);
        if (sqlParamString != "") sqlParamString += ",";
        sqlParamString += " total_price_incl_tax = ?";
      }
      if (data.total_discount != null) {
        condition.push(data.total_discount);
        if (sqlParamString != "") sqlParamString += ",";
        sqlParamString += " total_discount = ?";
      }
      if (data.total_tax != null) {
        condition.push(data.total_tax);
        if (sqlParamString != "") sqlParamString += ",";
        sqlParamString += " total_tax = ?";
      }
      if (data.total_payment != null) {
        condition.push(data.total_payment);
        if (sqlParamString != "") sqlParamString += ",";
        sqlParamString += " total_payment = ?";
      }
      if (data.line_discount != null) {
        condition.push(data.line_discount);
        if (sqlParamString != "") sqlParamString += ",";
        sqlParamString += " line_discount = ?";
      }
      if (data.line_discount_type != null) {
        condition.push(data.line_discount_type);
        if (sqlParamString != "") sqlParamString += ",";
        sqlParamString += " line_discount_type = ?";
      }
      if (data.sale_date != null) {
        condition.push(data.sale_date);
        if (sqlParamString != "") sqlParamString += ",";
        sqlParamString += " sale_date = ?";
      }
      if (data.sync_status != null) {
        condition.push(data.sync_status);
        if (sqlParamString != "") sqlParamString += ",";
        sqlParamString += " sync_status = ?";
      }
      if (data.sync_date != null) {
        condition.push(data.sync_date);
        if (sqlParamString != "") sqlParamString += ",";
        sqlParamString += " sync_date = ?";
      }
      if (data.note != null) {
        condition.push(data.note);
        if (sqlParamString != "") sqlParamString += ",";
        sqlParamString += " note = ?";
      }
      if (data.id != null) {
        condition.push(data.id);
        sqlParamString = "UPDATE RegisterSales SET " + sqlParamString + " WHERE id = ?";
      }
      t._doDSTransaction(function (tr) {
        t._executeDSSql(tr, sqlParamString, condition, suc, err);
      });
    },


    // -------------------
    //  [DEL] DELETE
    // ------------------- 
    deleteRegisterSales: function (data, suc, err) {
      var t = this, condition = data.id;
      t._doDSTransaction(function (tr) {
        t._executeDSSql(tr, "DELETE FROM RegisterSales WHERE id = ?", condition, suc, err);
      });
    },

    // -------------------
    //  [GET] SELECT
    // ------------------- 
    getRegisterSales: function (data, suc, err) {
      var t = this, condition = [], queryString = "";

      //console.debug(" %o", data);
      if (data != null) {
        if (data.id != null) {
          condition.push(data.id);
          queryString += " WHERE id = ?";
        }
        if (data.status != null) {
          if (queryString == "") {
            queryString += " WHERE ";
          } else {
            queryString += " AND ";
          }
          if (data.status == 'history') {
            queryString += " (status != 'sale_status_voided' and status != 'sale_status_open')";
          }
          else if (data.status == 'recall') {
            queryString += " (status == 'sale_status_saved' or status == 'sale_status_layby' or status == 'sale_status_onaccount')";
          }
          else {
            condition.push(data.status);
            queryString += " status = ?";
          }
        }

        if (data.register_id != null) {
          if (queryString == "") {
            queryString += " WHERE ";
          } else {
            queryString += " AND ";
          }
          queryString += " register_id = ?";
          condition.push(data.register_id);
        }

        if (data.sale_date != null) {
          if (queryString == "") {
            queryString += " WHERE ";
          } else {
            queryString += " AND ";
          }
          queryString += " sale_date >= ?";
          condition.push(data.sale_date);
        }

        if (data.sync == 'date') {
          if (data.sale_date != null) {
            if (queryString == "") {
              queryString += " WHERE ";
            } else {
              queryString += " AND ";
            }
            condition.push(data.sale_date);
            queryString += " sale_date is not null and sale_date > ? and sync_status <> 'sync_success'";
          }
        }
      }
      queryString = "SELECT * FROM RegisterSales " + queryString;

      console.debug(queryString); //TODO: for debug
      console.debug(condition);

      var success = function (t, a) {
        var rs = a.rows, i = 0;
        var resultSet = [];
        for (i = 0; i < rs.length; i++) {
          resultSet.push(rs.item(i));
        }
        typeof(suc) == 'function' && suc(resultSet);

      };
      t._doDSTransaction(function (tr) {
        t._executeDSSql(tr, queryString, condition, success, err)
      })
    },

    // ------------------------------------------------------------------------------------------------------------ //
    // [RegisterSaleItems] -------------------------------------------------------------------- [RegisterSaleItems] //
    // ------------------------------------------------------------------------------------------------------------ //
    // CREATE TABLE IF NOT EXISTS RegisterSaleItems (
    // id TEXT PRIMARY KEY ON CONFLICT REPLACE,
    // sale_id TEXT,
    // product_id TEXT,
    // name TEXT,
    // quantity REAL,
    // product_uom TEXT,
    // supply_price REAL,
    // price REAL,
    // sale_price REAL,
    // tax REAL,
    // tax_rate REAL,
    // discount REAL,
    // loyalty_value  REAL,
    // sequence INTEGER,
    // status TEXT ) //

    // -------------------
    //  [INIT] DROP & CREATE
    // ------------------- 
    initRegisterSaleItems: function () {
      var e = this;
      e._doDSTransaction(function (t) {
        e._executeDSSql(t, "DROP TABLE IF EXISTS RegisterSaleItems", []);
        e._executeDSSql(t, "CREATE TABLE IF NOT EXISTS RegisterSaleItems ( id TEXT PRIMARY KEY ON CONFLICT REPLACE, sale_id TEXT, product_id TEXT, name TEXT, quantity REAL, product_uom TEXT, supply_price REAL, price REAL, sale_price REAL, tax REAL, tax_rate REAL, discount REAL, loyalty_value  REAL, sequence INTEGER, status TEXT)")
      })
    },


    // -------------------
    //  [DEL] DELETE
    // ------------------- 
    deleteRegisterSaleItems: function (delInfo, suc, err) {
      var t = this, condition = [], sqlQuery = "DELETE from RegisterSaleItems WHERE sale_id = ? ";
      condition.push(delInfo.sale_id);
      if (delInfo.sequence != null) {
        sqlQuery += "and sequence = ?";
        condition.push(delInfo.sequence);
      }
      //console.debug(sqlQuery);
      //console.debug(condition);
      try {
        t._doDSTransaction(function (tr) {
          t._executeDSSql(tr, sqlQuery, condition, suc, err);
        });
      } catch (ex) {
        t._logDBError(ex.message);
      }
    },


    // -------------------
    //  [SAVE] INSERT OR REPLACE
    // ------------------- 
    saveRegisterSaleItems: function (e, saveArray) {
      var i = [];
      var n = this;
      var inputValues = [];

      for (var k = 0; k < saveArray.length; k++) {
        i = saveArray[k];
        inputValues.push([i.id, i.sale_id, i.product_id, i.name, i.quantity, i.product_uom, i.supply_price, i.price, i.sale_price, i.tax, i.tax_rate, i.discount, i.loyalty_value, i.sequence, i.status]);
      }

      try {
        n._doDSTransaction(function (e) {
          for (var j = 0; j < inputValues.length; j++) {
            var inputValue = inputValues[j];
            //console.debug("@@@ save sale items : %o", inputValue);
            n._executeDSSql(e, "INSERT or replace INTO RegisterSaleItems (id, sale_id, product_id, name, quantity, product_uom, supply_price, price, sale_price, tax, tax_rate, discount, loyalty_value, sequence, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", inputValue);
          }
        });
      } catch (ex) {
        n._logDBError(ex.message);
      }
    },

    // -------------------
    //  [GET] SELECT
    // ------------------- 
    getRegisterSaleItems: function (data, suc, err) {

      var t = this, searchValue, success,
          queryString = "SELECT * FROM RegisterSaleItems";

      if (data != null) {
        if (data.sale_id != null && data.status != null) {
          searchValue = [data.sale_id, data.status];
          queryString = "SELECT * FROM RegisterSaleItems WHERE sale_id = ? and status = ?";
        }
        else if (data.status != null) {
          searchValue = [data.status];
          queryString = "SELECT * FROM RegisterSaleItems WHERE status = ?";
        }
        else if (data.sale_id != null) {
          searchValue = [data.sale_id];
          queryString = "SELECT * FROM RegisterSaleItems WHERE sale_id = ?";
        }
      }

      success = function (tr, rt) {
        var rs = rt.rows, i = 0;
        var resultSet = [];
        for (i = 0; i < rs.length; i++) {
          resultSet.push(rs.item(i));
        }
        typeof(suc) == 'function' && suc(resultSet);
      }, t._doDSTransaction(function (tr) {
        t._executeDSSql(tr, queryString, searchValue, success, err)
      })
    },

    // -------------------
    //  [UPDATE] SELECT & UPDATE
    // ------------------- 
    updateRegisterSaleItems: function (data, suc, err) {
      var t = this;
      var queryString = "SELECT * FROM RegisterSaleItems WHERE sale_id = ? and product_id = ? and sequence = ?";
      var condition = [data.sale_id, data.product_id, data.sequence];
      var success = function (tr, rs) {
        if (rs.rows.length > 0) {
          var selectedID = rs.rows.item(0).id;
          queryString = "UPDATE RegisterSaleItems SET " +
              "quantity = ?, supply_price = ?, price = ?, sale_price = ?, tax = ?, tax_rate = ?, discount = ?, loyalty_value = ?, status = ? " +
              " WHERE id = ?";
          condition = [data.quantity, data.supply_price, data.price, data.sale_price, data.tax, data.tax_rate, data.discount, data.loyalty_value, data.status, selectedID];
          t._executeDSSql(tr, queryString, condition, suc, err);
        } else {
          'function' == typeof(err) && err
        }
      }
      try {
        t._doDSTransaction(function (tr) {
          t._executeDSSql(tr, queryString, condition, success, err);
        });
      } catch (ex) {
        t._logDBError(ex.message);
      }
    },
    // ------------------------------------------------------------------------------------------------------------ //
    // [RegisterSalePayments] -------------------------------------------------------------- [RegisterSalePayments] //
    // ------------------------------------------------------------------------------------------------------------ //
    // CREATE TABLE IF NOT EXISTS RegisterSalePayments (
    // id TEXT PRIMARY KEY ON CONFLICT REPLACE, 
    // sale_id TEXT, 
    // register_id TEXT,      
    // payment_type_id INTEGER, 
    // merchant_payment_type_id TEXT, 
    // amount REAL, 
    // payment_date TEXT)
    
    
    // -------------------
    //  [INIT] DROP & CREATE
    // ------------------- 
    initRegisterSalePayments: function (tr) {
      var t = this;
      t._doDSTransaction(function (tr) {
        t._executeDSSql(tr, "DROP TABLE IF EXISTS RegisterSalePayments", []);
        t._executeDSSql(tr, "CREATE TABLE IF NOT EXISTS RegisterSalePayments (" +
            "id TEXT PRIMARY KEY ON CONFLICT REPLACE, sale_id TEXT, register_id TEXT, " +
            "payment_type_id INTEGER, merchant_payment_type_id TEXT, amount REAL, payment_date TEXT)")
      })
    },

    // -------------------
    //  [SAVE] INSERT OR REPLACE
    // ------------------- 
    saveRegisterSalePayments: function (data, suc, err) {
      var t = this, input = [data.id, data.sale_id, data.register_id, data.payment_type_id, data.merchant_payment_type_id, data.amount, data.payment_date];
      t._doDSTransaction(function (tr) {
        t._executeDSSql(tr, "INSERT or replace INTO RegisterSalePayments " +
            "(id, sale_id, register_id, payment_type_id, merchant_payment_type_id, amount, payment_date) " +
            "VALUES (?, ?, ?, ?, ?, ?, ?)", input, suc, err);
      });
    },

    // -------------------
    //  [DEL] DELETE
    // ------------------- 
    deleteRegisterSalePayments: function (data, suc, err) {
      var t = this, condition = [data.sale_id];
      //console.log(condition),
      t._doDSTransaction(function (tr) {
        t._executeDSSql(tr, "DELETE FROM RegisterSalePayments WHERE sale_id = ?", condition, suc, err);
      });
    },

    // -------------------
    //  [GET] SELECT
    // ------------------- 
    getRegisterSalePayments: function (data, suc, err) {
      var t = this, input = [], success,
          sqlString = "SELECT * FROM RegisterSalePayments";

      if (data != null && data.sale_id != null) {
        input = [data.sale_id];
        sqlString += " WHERE sale_id = ?";
      }
      success = function (tr, rt) {
        var rs = rt.rows, i = 0, resultSet = [];
        for (i = 0; i < rs.length; i++) {
          resultSet.push(rs.item(i));
        }
        suc(resultSet);
      };
      t._doDSTransaction(function (tr) {
        //console.debug("@@@ get payment sql : %s, input : %o", sqlString, input);
        t._executeDSSql(tr, sqlString, input, success, err);
      });
    },


    // ------------------------------------------------------------------------------------------------------------ //
    // [ETC] ------------------------------------------------------------------------------------------------ [ETC] //
    // ------------------------------------------------------------------------------------------------------------ //

    saveRegisterAll: function (callBack, salesArray, salesItems) {
      var self = this;
      var inputSale = [salesArray.id, salesArray.register_id, salesArray.user_id, salesArray.customer_id, salesArray.xero_invoice_id, salesArray.receipt_number, salesArray.status, salesArray.total_cost, salesArray.total_price, salesArray.total_price_incl_tax, salesArray.total_discount, salesArray.total_tax, salesArray.note, salesArray.sale_date];
      var i = [];
      var inputItems = [];

      for (var k = 0; k < salesItems.length; k++) {
        i = salesItems[k];
        inputItems.push([i.id, i.sale_id, i.product_id, i.name, i.quantity, i.supply_price, i.price, i.sale_price, i.tax, i.tax_rate, i.discount, i.loyalty_value, i.sequence, i.status]);
      }

      try {
        self._doDSTransaction(function (e) {
          self._executeDSSql(e, "INSERT or replace INTO RegisterSales (id, register_id, user_id, customer_id, xero_invoice_id, receipt_number, status, total_cost, total_price, total_price_incl_tax, total_discount, total_tax, note, sale_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", inputSale,
              function (e) {
                console.log("CallBack");
              });
          //for(var j=0; j < inputItems.length; j++){
          //  var inputValue = inputItems[j];
          //  self._executeDSSql(e, "INSERT or replace INTO RegisterSaleItems (id, sale_id, product_id, name, quantity, supply_price, price, sale_price, tax, tax_rate, discount, loyalty_value, sequence, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", inputValue);
          //}
        }, function (e) {
          console.log("Transaction Error: ");
        }, function (rs) {
          console.log("Transaction Success: ");
        });
      } catch (ex) {
        self._logDBError(ex.message);
      }
    }
  }
}();


var _connectionQuery = function(queryString, addString, condition, addCondition) {
  if (condition.length == 0) {
    queryString += " WHERE ";
  } else {
    queryString += " AND ";
  }
  if (addString != null) {
    queryString += addString;
  }
  if (addCondition != null) {
    condition.push(addCondition);
  }
  return queryString;
}

var debug = function (s) {
  console.log(s);
}

Date.prototype.format = function(formatString) {
  if (!this.valueOf()) {
    return "";
  }

  // ISO 8601 //TODO: apply localizing
  var monthName     = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
  var monthFullName = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
  var weekName      = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
  var weekFullName  = ["Sunday", "Monday", "Tuesday", "Wednsday", "Thursday", "Friday", "Saturday"];
  var ampmName      = ["AM", "PM"];
  var date = this;

  var yyyy  = date.getFullYear().toString();
  var yy    = yyyy.substr(2,2);
  var M     = (date.getMonth() + 1).toString();
  var MM    = (M.length > 1 ? M : '0'+M);
  var MMM   = monthName[date.getMonth()];
  var MMMM  = monthFullName[date.getMonth()];
  var d     = date.getDate().toString();
  var dd    = (d.length > 1 ? d : '0'+d);
  var ddd   = weekName[date.getDay()];
  var dddd  = weekFullName[date.getDay()];
  var hours = date.getHours() + 1;                         // 1, 11, 21
  var H     = hours.toString();                            // 1, 11, 21
  var HH    = (H.length > 1 ? H : '0'+H);                  //01, 11, 21
  var h     = (hours <= 12 ? H : (hours - 12).toString()); // 1, 11,  9
  var hh    = (h.length > 1 ? h : '0'+h);                  //01, 11, 09
  var m     = date.getMinutes().toString();
  var mm    = (m.length > 1 ? m : '0'+m);
  var s     = date.getSeconds().toString();
  var ss    = (s.length > 1 ? s : '0'+s);
  var ampm  = (hours <= 12 ? ampmName[0] : ampmName[1]);

  return formatString.replace(/(yyyy|yy|MMMM|MMM|MM|M|dddd|ddd|dd|d|hh|h|HH|H|mm|m|ss|s|ampm)/gi, function($arr) {
    switch ($arr) {
      case "yyyy":  return yyyy;
      case "yy":    return yy;
      case "MMMM":  return MMMM;
      case "MMM":   return MMM;
      case "MM":    return MM;
      case "M":     return M;
      case "dddd":  return dddd;
      case "ddd":   return ddd;
      case "dd":    return dd;
      case "d":     return d;
      case "hh":    return hh;
      case "h":     return h;
      case "HH":    return HH;
      case "H":     return H;
      case "mm":    return mm;
      case "m":     return m;
      case "ss":    return ss;
      case "s":     return s;
      case "ampm":  return ampm;
      default:      return $arr;
    }
  });
};
