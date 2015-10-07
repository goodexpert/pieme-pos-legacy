'use strict';

/**
 * @ngdoc function
 * @name OnzsaApp.module:LocalStorage
 *
 * @description
 * Local storage module of the OnzsaApp
 */
angular.module('OnzsaApp.storage', [])

.factory('LocalStorage', ['$rootScope', 'localStorageService',  function($rootScope, localStorageService) {
  // The default config for register
  var defaultConfig = {
    version: null,
    user_hash: null,
    merchant_id: null,
    merchant_name: null,
    domain_prefix: null,
    business_type_id: null,
    default_customer_group_id: null,
    default_customer_id: null,
    default_no_tax_group_id: null,
    default_tax_id: null,
    discount_product_id: null,
    default_quick_key_id: null,
    default_currency: null,
    time_zone: null,
    display_price_tax_inclusive: null,
    allow_cashier_discount: null,
    allow_use_scale: null,
    retailer_id: null,
    outlet_id: null,
    outlet_name: null,
    enable_loyalty: null,
    loyalty_ratio: null,
    user_id: null,
    user_name: null,
    user_display_name: null,
    user_type: null,
  };

  // The config specified to the module globally.
  var globalConfig = {};

  var getConfigAll = function() {
    return localStorageService.get('config');
  };

  var getConfig = function(notUseDefault) {
    var config = getConfigAll();
    if (config == null || "object" != typeof config) {
      debug("GET CONFIG: local store config empty, setting up config defaults");
      if (notUseDefault == null || notUseDefault == false) {
        config = defaultConfig;
      }
    }
    return config;
  };

  var saveConfig = function(config) {
    angular.extend(globalConfig, config);
    localStorageService.set('config', globalConfig);
  };

  var saveRegister = function(register) {
    debug("saving register", + register);
    localStorageService.set('register', register);
    localStorageService.set('register_id', register.id);

    var config = { register_id: register.id };
    saveConfig(config);
  };

  var getRegister = function() {
    debug("get register");
    return localStorageService.get('register');
  };

  var getInvoiceSeq = function() {
    debug("get invoice sequence");
    return localStorageService.get('register').invoice_sequence;
  };

  var setInvoiceSeq = function(seq) {
    debug("set invoice sequence");
    var register = localStorageService.get('register');
    register.invoice_sequence = seq;
    localStorageService.set('register', register);
  };

  var getRegisterID = function() {
    debug("get register id");
    return localStorageService.get('register_id');
  };

  var saveSaleID = function(saleID) {
    debug("saving register sale id", + saleID);
    localStorageService.set('register_sale_id', saleID);
  };

  var getSaleID = function() {
    debug("get register sale id");
    return localStorageService.get('register_sale_id');
  };

  var clearSaleID = function() {
    debug("remove register sale id");
    localStorageService.remove('register_sale_id');
  };

  var saveDataSyncTime = function(table, time) {
    debug("saving data sync table: " + table + " / time: " + time);
    switch (table) {
      case 'payment_types':
        localStorageService.set('synced_payment_types', time);
        break;
      case 'products':
        localStorageService.set('synced_products', time);
        break;
      case 'taxes':
        localStorageService.set('synced_taxes', time);
        break;
      case 'register_sales':
        localStorageService.set('synced_register_sales', time);
        break;
    }
  };

  var getDataSyncTime = function(table) {
    debug("get data sync table: " + table);
    switch (table) {
      case 'payment_types':
        return localStorageService.get('synced_payment_types');
      case 'products':
        return localStorageService.get('synced_products');
      case 'taxes':
        return localStorageService.get('synced_taxes');
      case 'register_sales':
        return localStorageService.get('synced_register_sales');
    }
  };

  return {
    getConfig: getConfig,
    saveConfig: saveConfig,
    getRegister: getRegister,
    setInvoiceSeq: setInvoiceSeq,
    getInvoiceSeq: getInvoiceSeq,
    getRegisterID: getRegisterID,
    saveRegister: saveRegister,
    saveSaleID: saveSaleID,
    getSaleID: getSaleID,
    clearSaleID: clearSaleID,
    saveDataSyncTime: saveDataSyncTime,
    getDataSyncTime: getDataSyncTime,
  };
}]);

