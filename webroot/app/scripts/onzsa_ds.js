


Datastore_sqlite = function() {
  var e, t = function() {};
  var db = openDatabase('onzsadb', '1.0', 'onzsa database', 2 * 1024 * 1024);

  return {
    _logDBError: function(e) {
      var errorInfo = JSON.stringify(arguments);
      console.log("WebSQL Error: " + errorInfo + " " + arguments.error);
    },
    _doDSTransaction: function(e, t, a) {
      //console.log("In _doDSTransaction: START" );

      var n, i, r = this;

      try {
        db.transaction(e)
      } catch (ex) {
        r._logDBError(ex + "hoho")
      }
    },
    _executeDSSql: function(e, t, a, n, i) {
      //console.log("In _executeDSSql: START" );

      var r, o = this;
      try {
        r = function(e) {
          var r, s;
          r = function(e, t) {
            "function" == typeof n && n(e, t)
          }, s = function() {
            var e = {
              sql: t,
              params: a,
              error: arguments
            };
            console.log(e), o._logDBError(e), "function" == typeof i && i !== o._logDBError && i(e)
          }, e.executeSql(t, a, r, s)
        }, e ? r(e) : this.db.transaction(r)
      } catch (s) {
        console.log("TRANSACTION ERROR " + s.message)
      }
    },

    initLocalDataStore: function(e, t) {
      var a, n = this;
      a = function() {
        n._doDSTransaction(function(t) {
          console.log("INIT: initLocalDataStore"), n.initPriceBook(), n.initSaleProducts()
        })
      }, a()
    },
    initPriceBook: function(){
      var e = this;
      e._doDSTransaction(function(t) {
        e._executeDSSql(t, "DROP TABLE IF EXISTS PriceBookEntry", []);
        e._executeDSSql(t, "CREATE TABLE IF NOT EXISTS PriceBookEntry ( id TEXT PRIMARY KEY ON CONFLICT REPLACE, product_id TEXT, customer_group_id TEXT, outlet_id TEXT, markup REAL, discount REAL, price REAL, tax REAL, price_include_tax REAL, loyalty_value REAL, min_units REAL, max_units REAL, is_default INT, valid_from TEXT, valid_to TEXT)");
      })
    },
    initSaleProducts: function(){
      var e = this;
      e._doDSTransaction(function(t) {
        e._executeDSSql(t, "DROP TABLE IF EXISTS SaleProducts", []);
        e._executeDSSql(t, "CREATE TABLE IF NOT EXISTS SaleProducts ( " +
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
        // Save Sample Data
        //e._executeDSSql(t,
        //  "INSERT INTO SaleProducts (" +
        //  "id, name, handle, description, brand_name, supplier_name, sku" +
        //  ", supplier_price, price, tax, tax_name, tax_rate, retail_price" +
        //  ", thumbnail, image" +
        //  ") values (" +
        //  "  ?, ?, ?, ?, ?, ?, ?" +
        //  ", ?, ?, ?, ?, ?, ?" +
        //  ", ?, ?" +
        //  ")", [
        //    "55b99424-0a70-404c-8788-25e04cf3b98e", "Yoghurt Fruity Tart", "yoghurt", "yoghurt description", "yoghurt story", "2nd supplier", "skuskusku",
        //    '2.0', '2.6', '0.39', "GST", '15', '2.99',
        //    "\/img\/ONZSA_eye.png", "\/img\/sample_1.png"
        //  ]
        //);
        //e._executeDSSql(t,
        //  "INSERT INTO SaleProducts (" +
        //  "id, name, handle, description, brand_name, supplier_name, sku" +
        //  ", supplier_price, price, tax, tax_name, tax_rate, retail_price" +
        //  ", thumbnail, image" +
        //  ") values (" +
        //  "  ?, ?, ?, ?, ?, ?, ?" +
        //  ", ?, ?, ?, ?, ?, ?" +
        //  ", ?, ?" +
        //  ")", [
        //    "55b99424-0a70-404c-8788-25e14cf3b37e", "yoghurt-creamy-delight", "yoghurt", "yoghurt description 2222", "yoghurt story", "2nd supplier", "skuskusku222",
        //    '4.0', '5.2', '0.78', "GST", '15', '5.98',
        //    "\/img\/user.png", "\/img\/sample_5.png"
        //  ]
        //);
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

    saveRegisterSales: function(e, saveArray){
      var i = saveArray;
      var n = this;
      var inputValues = [i.id, i.register_id, i.user_id, i.customer_id, i.xero_invoice_id, i.receipt_number, i.status, i.total_cost, i.total_price, i.total_price_incl_tax, i.total_discount, i.total_tax, i.note, i.sale_date];
      try{
        n._doDSTransaction(function(e) {
          console.log(saveArray);
          n._executeDSSql(e, "INSERT or replace INTO RegisterSales (id, register_id, user_id, customer_id, xero_invoice_id, receipt_number, status, total_cost, total_price, total_price_incl_tax, total_discount, total_tax, note, sale_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", inputValues);
        });
      }catch(ex){
        n._logDBError(ex.message);
      }
    },

    saveRegisterSalesItems: function(e, saveArray){
      var i = saveArray;
      var n = this;
      console.log(saveArray);
      var inputValues = [i.id, i.sale_id, i.product_id, i.name, i.quantity, i.supply_price, i.price, i.price_include_tax, i.tax, i.tax_rate, i.discount, i.loyalty_value, i.sequence, i.status];
      try{
        n._doDSTransaction(function(e) {
          console.log(saveArray);
          n._executeDSSql(e, "INSERT or replace INTO RegisterSaleItems (id, sale_id, product_id, name, quantity, supply_price, price, price_include_tax, tax, tax_rate, discount, loyalty_value, sequence, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", inputValues);
        });
      }catch(ex){
        n._logDBError(ex.message);
      }
    },

    getRegisterSales: function(e, statusCode) {

      var t, a, n = this, searchValue = [], queryString = '';

      if(statusCode == null){
        console.log('3');
        queryString = "SELECT * FROM RegisterSales";
      }else{
        queryString = "SELECT * FROM RegisterSales where status = ? ";
        searchValue.push(statusCode);
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

    getRegisterSaleItems: function(e, saleId) {

      var t, a, n = this, searchValue = [], queryString = '';

      if(saleId == null){
        console.log('1');
        queryString = "SELECT * FROM RegisterSaleItems where status = 'sale_item_status_open'";
      }else{
        queryString = "SELECT * FROM RegisterSaleItems where sale_id = ? ";
        searchValue.push(saleId);
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

    getSaleProduct: function(successCallback, searchData) {
      var excuteCallback, t = this;
      var sqlQuery = "SELECT * FROM SaleProducts WHERE id = ?";
      var pid = searchData.id;
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
                t._executeDSSql(e, sqlQuery, [pid], excuteCallback, t._logDBError)
              }
          )
    },


    setSaleProducts: function(successCallback, setData) {
      var t = this;
      var sqlQuery = "INSERT  INTO SaleProducts (" +
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


    /**
     getPriceBookEntryForRegisterSale: function(e) {
          var t, a, n, i = this,
              r = Renegade.util.number,
              o = r.multiply,
              s = (r.divide, r.subtract),
              l = r.add,
              c = e.register_sale_product,
              u = e.customer,
              d = e.default_customer_group_id,
              g = e.outlet_id,
              p = e.callback,
              f = c.display_retail_price_tax_inclusive,
              _ = 0,
              h = 0;
          h = parseFloat(c.quantity) < 0 ? -1 * parseFloat(c.quantity) : parseFloat(c.quantity), debug("INFO: Look for price for " + h + " of " + c.id + " customer=" + u.customer_group_id + " default_customer_group_id=" + d + " outlet_id=" + g), t = function(e, t) {
              var a, n = VendPOS.Store.getAll("Tax", "id"),
                  i = c.tax_id,
                  r = n[i].rate,
                  u = e.price,
                  d = t.price;
              return f ? (a = o(u, r), pricebookTax = o(d, r), _ = s(l(u, a), l(d, pricebookTax))) : _ = u - d, _
          }, a = function(e) {
              var t, a = e[0],
                  n = e.length;
              for (debug("There were " + n + " GENERAL pricebook entries found, will search for lowest", e), t = 1; n > t; t += 1) e[t] < a && (a = e[t]);
              return a
          }, n = function(e) {
              var n;
              e.discount = 0, n = function(n) {
                  var r;
                  n ? (debug("Multiple pricebook entries found (base and general custom group)"), n = n.length > 1 ? a(n) : n[0], debug("Base and Chosen General (custom group) pricebooks are:", e, n), n.discount = t(e, n), p(n)) : (r = function(n) {
                      n ? (debug("Multiple default group pricebook entries found (base and general)"), n = n.length > 1 ? a(n) : n[0], debug("Base & Chosen General (default group) pricebooks are:", e, n), n.discount = t(e, n), p(n)) : (debug("BASE pricebook entry", e), p(e))
                  }, i.getPriceBookEntriesByCustomerGroup(c.product_id, d.toString(), h.toString(), g, "GENERAL", r))
              }, i.getPriceBookEntriesByCustomerGroup(c.product_id, u.customer_group_id.toString(), h.toString(), g, "GENERAL", n)
          }, i.getPriceBookEntriesByCustomerGroup(c.product_id, d.toString(), h.toString(), g, "BASE", n)
      },


     /**,
     dropAccount: function() {
          var e = this;
          e._doDSTransaction(function(t) {
              e._executeDSSql(t, "DROP TABLE IF EXISTS Account", [])
          })
      },
     initStorePriceBookEntry: function(e, t) {
          var a, n = this;
          a = ["CREATE TABLE IF NOT EXISTS PriceBookEntry (", "id TEXT PRIMARY KEY ON CONFLICT REPLACE, ", "product_id TEXT, ", "customer_group_id TEXT, ", "type TEXT, ", "price REAL, ", "loyalty_value REAL, ", "tax REAL, ", "tax_rate REAL, ", "tax_id TEXT, ", "tax_name TEXT, ", "min_units REAL, ", "max_units REAL, ", "valid_from REAL, ", "valid_to REAL, ", "display_retail_price_tax_inclusive REAL, ", "outlet_id TEXT", ")"].join(""), n._executeDSSql(e, a, [], t), n._executeDSSql(e, "CREATE INDEX IF NOT EXISTS idx_price_book_entry_product_id ON PriceBookEntry(product_id)")
      },
     deleteAllOfflineData: function(e, a) {
          var n = this,
              i = function(a) {
                  e.delete_customers && n._executeDSSql(a, "DELETE FROM Customer", [], t, n._logDBError), e.delete_registers && n._executeDSSql(a, "DELETE FROM Register", [], t, n._logDBError), e.delete_products && (n._executeDSSql(a, "DELETE FROM Product", [], t, n._logDBError), n._executeDSSql(a, "DELETE FROM PriceBookEntry", [], t, n._logDBError))
              };
          n._doDSTransaction(i), "function" == typeof a && a()
      },
     deleteRegisters: function(e) {
          var t = this;
          t._doDSTransaction(function(a) {
              t._executeDSSql(a, "DELETE FROM Register", [], e, t._logDBError)
          })
      },
     savePriceBookEntries: function(e) {
          var t, a, n, i = this,
              r = e.priceBookEntries,
              o = e.productId,
              s = e.transaction,
              l = e.completeHandler,
              c = "DELETE from PriceBookEntry WHERE product_id = ?";
          n = function() {
              r && r.length ? (t = clone(r), a()) : l(s)
          }, a = function() {
              var e, n = t.pop();
              e = function() {
                  t.length ? a() : l(s)
              }, i.savePriceBookEntry({
                  priceBookEntry: n,
                  transaction: s,
                  completeHandler: e
              })
          }, i._executeDSSql(s, c, [o], n, i._logDBError)
      }
     ,
     savePriceBookEntry: function(e) {
          var t, a, n = this,
              i = e.priceBookEntry,
              r = e.transaction,
              o = e.completeHandler;
          t = ["INSERT or replace INTO PriceBookEntry (", "id, ", "product_id, ", "customer_group_id, ", "type, ", "price, ", "loyalty_value, ", "tax, ", "tax_id, ", "display_retail_price_tax_inclusive, ", "tax_name, ", "tax_rate, ", "min_units, ", "max_units, ", "valid_from, ", "valid_to, ", "outlet_id", ") VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"].join(""), a = [i.id, i.product_id, i.customer_group_id, i.type, i.price, i.loyalty_value, i.tax, i.tax_id, i.display_retail_price_tax_inclusive, i.tax_name, i.tax_rate, i.min_units, i.max_units, i.valid_from, i.valid_to, i.outlet_id], n._executeDSSql(r, t, a, o, n._logDBError)
      },
     deleteOutletProductTax: function(e) {
          var t = this,
              a = e.outletProductTax,
              n = a ? a.product_id : e.product_id,
              i = a ? a.outlet_id : e.outlet_id,
              r = e.transaction,
              o = e.completeHandler;
          _deleteOutletProductTaxCompleteHandler = function() {
              "function" == typeof o && o()
          }, _deleteOutletProductTax = function(e) {
              var a, r = "";
              n && (r = 'WHERE product_id = "' + n + '"'), i && (r += r ? " AND " : "WHERE ", r += 'outlet_id = "' + i + '"'), a = ["DELETE FROM OutletProductTax ", r].join(""), t._executeDSSql(e, a, [], _deleteOutletProductTaxCompleteHandler, t._logDBError)
          }, r ? _deleteOutletProductTax(r) : t._doDSTransaction(_deleteOutletProductTax)
      },
     deleteAllOutletProductTaxes: function(e) {
          var t, a, n = this,
              i = e.completeHandler,
              r = e.ignoreId,
              o = e.transaction || null;
          t = function() {
              "function" == typeof i && i()
          }, a = ["DELETE FROM OutletProductTax ", r ? 'WHERE outlet_id != "' + r + '"' : ""].join(""), n._executeDSSql(o, a, [], t, n._logDBError)
      },
     saveCustomer: function(e, t, a) {
          var n = this,
              i = function(t) {
                  n._executeDSSql(t, "INSERT or replace INTO Customer (id, name, company_name, customer_code, balance, loyalty_balance, year_to_date, phone, email, website, postal_address1, postal_address2, postal_suburb, postal_city, postal_postcode, postal_state, postal_country_id, physical_address1, physical_address2, physical_suburb, physical_city, physical_postcode, physical_state, physical_country_id, customer_group_id, customer_group_name, retailer_id) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", [e.id, e.name, e.company_name, e.customer_code, e.balance, e.loyalty_balance, e.year_to_date, e.phone, e.email, e.website, e.postal_address1, e.postal_address2, e.postal_suburb, e.postal_city, e.postal_postcode, e.postal_state, e.postal_country_id, e.physical_address1, e.physical_address2, e.physical_suburb, e.physical_city, e.physical_postcode, e.physical_state, e.physical_country_id, e.customer_group_id, e.customer_group_name, e.retailer_id], a, a)
              };
          "undefined" == typeof t ? n._doDSTransaction(i) : i(t)
      } **/
  }
}();