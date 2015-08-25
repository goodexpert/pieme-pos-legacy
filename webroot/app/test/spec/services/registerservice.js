'use strict';

describe('Service: registerService', function () {

  // load the service's module
  beforeEach(module('appApp'));

  // instantiate service
  var registerService;
  beforeEach(inject(function (_registerService_) {
    registerService = _registerService_;
  }));

  it('should do something', function () {
    expect(!!registerService).toBe(true);
  });

});
