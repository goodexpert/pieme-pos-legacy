<div class="clearfix"></div>
<div class="container">
    <!-- BEGIN SIDEBAR -->
    <div class="page-sidebar-wrapper"> 
        <!-- BEGIN HORIZONTAL RESPONSIVE MENU --> 
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing --> 
        <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <div class="page-sidebar navbar-collapse collapse">
            <ul class="page-sidebar-menu" data-slide-speed="200" data-auto-scroll="true">
                <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element --> 
                <!-- DOC: This is mobile version of the horizontal menu. The desktop version is defined(duplicated) in the header above -->
                <li class="sidebar-search-wrapper"> 
                    <!-- BEGIN RESPONSIVE QUICK SEARCH FORM --> 
                    <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box --> 
                    <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
                    <form class="sidebar-search sidebar-search-bordered" action="extra_search.html" method="POST">
                    <a href="javascript:;" class="remove"> <i class="icon-close"></i> </a>
                    <div class="input-group">
                        <input type="text" placeholder="Search...">
                        <span class="input-group-btn">
                        <button class="btn submit"><i class="icon-magnifier"></i></button>
                        </span> </div>
                    </form>
                    <!-- END RESPONSIVE QUICK SEARCH FORM -->
                </li>
                <li> <a href="index"> Sell </a> </li>
                <li> <a href="history"> History </a> </li>
                <li class="active"> <a href="history"> Product <span class="selected"> </span> </a> </li>
            </ul>
        </div>
        <!-- END HORIZONTAL RESPONSIVE MENU --> 
    </div>
    <!-- END SIDEBAR --> 
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <div id="notify" class="hidden col-lg-12 col-md-12 col-sm-12">
                <div class="notify-content"><p>Setup has been changed. Please login again to your account.</p></div>
            </div>
            <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega margin-bottom-20">
                <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">Xero</h2>
                <div class="pull-right col-md-5 col-xs-5 col-sm-5 col-alpha col-omega margin-top-20">
                    <a href="/xero/reloadAccounts"><button class="btn btn-white pull-right">
                        <div class="glyphicon glyphicon-refresh"></div>&nbsp;
                    Reload accounts</button></a> 
                </div>
            </div>
            <div class="portlet-body form"> 
                <!-- BEGIN FORM-->
                <div class="form-horizontal col-md-12 col-xs-12 col-sm-12">
                    <div class="col-md-12 col-xs-12 col-sm-12 form-title margin-top-20">Accounts</div>
                    <div class="form-body line line-box line-box-content col-md-12 col-xs-12 col-sm-12"> 
                        <div class="col-md-6">
                            <dl>
                                <dt><label for="default_sales_account">Default sales account</label></dt>
                                <dd>
                                    <select name="default_sales_account" id="default_sales_account">
                                        <option value="" selected="selected"></option>
                                        <optgroup label="Revenue">
                                            <option value="200">200-Sales</option>
                                            <option value="260">260-Other Revenue</option>
                                            <option value="270">270-Interest Income</option>
                                        </optgroup>
                                        <optgroup label="Current">
                                            <option value="610">610-Accounts Receivable</option>
                                            <option value="620">620-Prepayments</option>
                                        </optgroup>
                                    </select>
                                </dd>
                                <dt><label for="default_rounding_account">Rounding errors</label></dt>
                                <dd>
                                    <select name="default_rounding_account" id="default_rounding_account">
                                        <option value="" selected="selected"></option>
                                        <optgroup label="Current">
                                            <option value="610">610-Accounts Receivable</option>
                                            <option value="620">620-Prepayments</option>
                                        </optgroup>
                                        <optgroup label="Direct Costs">
                                            <option value="300">300-Purchases</option>
                                            <option value="310">310-Cost of Goods Sold</option>
                                        </optgroup>
                                        <optgroup label="Current Liability">
                                            <option value="800">800-Accounts Payable</option>
                                            <option value="801">801-Unpaid Expense Claims</option>
                                            <option value="820">820-Sales Tax</option>
                                            <option value="825">825-Employee Tax Payable</option>
                                            <option value="826">826-Superannuation Payable</option>
                                            <option value="830">830-Income Tax Payable</option>
                                            <option value="835">835-Revenue Received in Advance</option>
                                            <option value="840">840-Historical Adjustment</option>
                                            <option value="850">850-Suspense</option>
                                            <option value="855">855-Clearing Account</option>
                                            <option value="860">860-Rounding</option>
                                            <option value="877">877-Tracking Transfers</option>
                                            <option value="880">880-Owner A Drawings</option>
                                            <option value="881">881-Owner A Funds Introduced</option>
                                        </optgroup>
                                        <optgroup label="Expense">
                                            <option value="400">400-Advertising</option>
                                            <option value="404">404-Bank Fees</option>
                                            <option value="408">408-Cleaning</option>
                                            <option value="412">412-Consulting &amp; Accounting</option>
                                            <option value="416">416-Depreciation</option>
                                            <option value="420">420-Entertainment</option>
                                            <option value="425">425-Freight &amp; Courier</option>
                                            <option value="429">429-General Expenses</option>
                                            <option value="433">433-Insurance</option>
                                            <option value="437">437-Interest Expense</option>
                                            <option value="441">441-Legal expenses</option>
                                            <option value="445">445-Light, Power, Heating</option>
                                            <option value="449">449-Motor Vehicle Expenses</option>
                                            <option value="453">453-Office Expenses</option>
                                            <option value="461">461-Printing &amp; Stationery</option>
                                            <option value="469">469-Rent</option>
                                            <option value="473">473-Repairs and Maintenance</option>
                                            <option value="477">477-Wages and Salaries</option>
                                            <option value="478">478-Superannuation</option>
                                            <option value="485">485-Subscriptions</option>
                                            <option value="489">489-Telephone &amp; Internet</option>
                                            <option value="493">493-Travel - National</option>
                                            <option value="494">494-Travel - International</option>
                                            <option value="497">497-Bank Revaluations</option>
                                            <option value="498">498-Unrealised Currency Gains</option>
                                            <option value="499">499-Realised Currency Gains</option>
                                            <option value="505">505-Income Tax Expense</option>
                                        </optgroup>
                                    </select>
                                    <div class="help">Rounding errors in sales tax calculations may<br>occur for small transactions.</div>
                                </dd>
                                <dt><label for="default_refund_account">Refund account</label></dt>
                                <dd>
                                    <select name="default_refund_account" id="default_refund_account">
                                        <option value="" selected="selected"></option>
                                        <optgroup label="Current">
                                            <option value="610">610-Accounts Receivable</option>
                                            <option value="620">620-Prepayments</option>
                                        </optgroup>
                                    </select>
                                    <div class="help">For more information in assigning this refund<br>account 
                                        <a target="_blank" href="http://support.vendhq.com/hc/en-us/articles/201382480-What-is-the-Xero-integration-and-how-does-it-work-#surefund">view our knowledge base</a>.</div>
                                </dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl>
                                <dt><label for="default_cost_of_goods_account">Default purchases account</label></dt>
                                <dd>
                                    <select name="default_cost_of_goods_account" id="default_cost_of_goods_account">
                                        <option value="" selected="selected"></option>
                                        <option value="" selected="selected"></option>
                                        <optgroup label="Current">
                                            <option value="610">610-Accounts Receivable</option>
                                            <option value="620">620-Prepayments</option>
                                        </optgroup>
                                        <optgroup label="Direct Costs">
                                            <option value="300">300-Purchases</option>
                                            <option value="310">310-Cost of Goods Sold</option>
                                        </optgroup>
                                        <optgroup label="Expense">
                                            <option value="400">400-Advertising</option>
                                            <option value="404">404-Bank Fees</option>
                                            <option value="408">408-Cleaning</option>
                                            <option value="412">412-Consulting &amp; Accounting</option>
                                            <option value="416">416-Depreciation</option>
                                            <option value="420">420-Entertainment</option>
                                            <option value="425">425-Freight &amp; Courier</option>
                                            <option value="429">429-General Expenses</option>
                                            <option value="433">433-Insurance</option>
                                            <option value="437">437-Interest Expense</option>
                                            <option value="441">441-Legal expenses</option>
                                            <option value="445">445-Light, Power, Heating</option>
                                            <option value="449">449-Motor Vehicle Expenses</option>
                                            <option value="453">453-Office Expenses</option>
                                            <option value="461">461-Printing &amp; Stationery</option>
                                            <option value="469">469-Rent</option>
                                            <option value="473">473-Repairs and Maintenance</option>
                                            <option value="477">477-Wages and Salaries</option>
                                            <option value="478">478-Superannuation</option>
                                            <option value="485">485-Subscriptions</option>
                                            <option value="489">489-Telephone &amp; Internet</option>
                                            <option value="493">493-Travel - National</option>
                                            <option value="494">494-Travel - International</option>
                                            <option value="497">497-Bank Revaluations</option>
                                            <option value="498">498-Unrealised Currency Gains</option>
                                            <option value="499">499-Realised Currency Gains</option>
                                            <option value="505">505-Income Tax Expense</option>
                                        </optgroup>
                                    </select>
                                </dd>
                                <dt><label for="default_baddebt_account">Till payment discrepancies</label></dt>
                                <dd>
                                    <select name="default_baddebt_account" id="default_baddebt_account">
                                        <option value="" selected="selected"></option>
                                        <optgroup label="Current">
                                            <option value="610">610-Accounts Receivable</option>
                                            <option value="620">620-Prepayments</option>
                                        </optgroup>
                                        <optgroup label="Direct Costs">
                                            <option value="300">300-Purchases</option>
                                            <option value="310">310-Cost of Goods Sold</option>
                                        </optgroup>
                                        <optgroup label="Current Liability">
                                            <option value="800">800-Accounts Payable</option>
                                            <option value="801">801-Unpaid Expense Claims</option>
                                            <option value="820">820-Sales Tax</option>
                                            <option value="825">825-Employee Tax Payable</option>
                                            <option value="826">826-Superannuation Payable</option>
                                            <option value="830">830-Income Tax Payable</option>
                                            <option value="835">835-Revenue Received in Advance</option>
                                            <option value="840">840-Historical Adjustment</option>
                                            <option value="850">850-Suspense</option>
                                            <option value="855">855-Clearing Account</option>
                                            <option value="860">860-Rounding</option>
                                            <option value="877">877-Tracking Transfers</option>
                                            <option value="880">880-Owner A Drawings</option>
                                            <option value="881">881-Owner A Funds Introduced</option>
                                        </optgroup>
                                        <optgroup label="Expense">
                                            <option value="400">400-Advertising</option>
                                            <option value="404">404-Bank Fees</option>
                                            <option value="408">408-Cleaning</option>
                                            <option value="412">412-Consulting &amp; Accounting</option>
                                            <option value="416">416-Depreciation</option>
                                            <option value="420">420-Entertainment</option>
                                            <option value="425">425-Freight &amp; Courier</option>
                                            <option value="429">429-General Expenses</option>
                                            <option value="433">433-Insurance</option>
                                            <option value="437">437-Interest Expense</option>
                                            <option value="441">441-Legal expenses</option>
                                            <option value="445">445-Light, Power, Heating</option>
                                            <option value="449">449-Motor Vehicle Expenses</option>
                                            <option value="453">453-Office Expenses</option>
                                            <option value="461">461-Printing &amp; Stationery</option>
                                            <option value="469">469-Rent</option>
                                            <option value="473">473-Repairs and Maintenance</option>
                                            <option value="477">477-Wages and Salaries</option>
                                            <option value="478">478-Superannuation</option>
                                            <option value="485">485-Subscriptions</option>
                                            <option value="489">489-Telephone &amp; Internet</option>
                                            <option value="493">493-Travel - National</option>
                                            <option value="494">494-Travel - International</option>
                                            <option value="497">497-Bank Revaluations</option>
                                            <option value="498">498-Unrealised Currency Gains</option>
                                            <option value="499">499-Realised Currency Gains</option>
                                            <option value="505">505-Income Tax Expense</option>
                                        </optgroup>
                                    </select>
                                    <div class="help">If there are any discrepancies in the till close<br>payment counts, they will be posted here.</div>
                                </dd>
                                <dt><label for="default_discount_account">Default discount account</label></dt>
                                <dd>
                                    <select name="default_discount_account" id="default_discount_account">
                                        <option value="" selected="selected"></option>
                                        <optgroup label="Revenue">
                                            <option value="200">200-Sales</option>
                                            <option value="260">260-Other Revenue</option>
                                            <option value="270">270-Interest Income</option>
                                        </optgroup>
                                        <optgroup label="Expense">
                                            <option value="400">400-Advertising</option>
                                            <option value="404">404-Bank Fees</option>
                                            <option value="408">408-Cleaning</option>
                                            <option value="412">412-Consulting &amp; Accounting</option>
                                            <option value="416">416-Depreciation</option>
                                            <option value="420">420-Entertainment</option>
                                            <option value="425">425-Freight &amp; Courier</option>
                                            <option value="429">429-General Expenses</option>
                                            <option value="433">433-Insurance</option>
                                            <option value="437">437-Interest Expense</option>
                                            <option value="441">441-Legal expenses</option>
                                            <option value="445">445-Light, Power, Heating</option>
                                            <option value="449">449-Motor Vehicle Expenses</option>
                                            <option value="453">453-Office Expenses</option>
                                            <option value="461">461-Printing &amp; Stationery</option>
                                            <option value="469">469-Rent</option>
                                            <option value="473">473-Repairs and Maintenance</option>
                                            <option value="477">477-Wages and Salaries</option>
                                            <option value="478">478-Superannuation</option>
                                            <option value="485">485-Subscriptions</option>
                                            <option value="489">489-Telephone &amp; Internet</option>
                                            <option value="493">493-Travel - National</option>
                                            <option value="494">494-Travel - International</option>
                                            <option value="497">497-Bank Revaluations</option>
                                            <option value="498">498-Unrealised Currency Gains</option>
                                            <option value="499">499-Realised Currency Gains</option>
                                            <option value="505">505-Income Tax Expense</option>
                                        </optgroup>
                                    </select>
                                    <div class="help">When the system wide discount product is <br>applied, the value will be posted here.</div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="form-horizontal col-md-12 col-xs-12 col-sm-12">
                    <div class="col-md-12 col-xs-12 col-sm-12 form-title margin-top-20">Accounts for Payment Types</div>
                    <div class="form-body line line-box line-box-content col-md-12 col-xs-12 col-sm-12"> 
                        <div class="col-md-6">
                            <dl>
                                <dt><label for="">Cash payments</label></dt>
                                <dd>
                                    <select name="" id="">
                                        <option value="" selected="selected"></option>
                                        <optgroup label="Bank">
                                            <option value="090">090-Business Bank Account</option>
                                            <option value="091">091-Business Savings Account</option>
                                        </optgroup>
                                        <optgroup label="Current">
                                            <option value="610">610-Accounts Receivable</option>
                                            <option value="620">620-Prepayments</option>
                                        </optgroup>
                                    </select>
                                </dd>
                                <dt><label for="">Cash (Concealed totals) payments</label></dt>
                                <dd>
                                    <select name="" id="">
                                        <option value="" selected="selected"></option>
                                        <optgroup label="Bank">
                                            <option value="090">090-Business Bank Account</option>
                                            <option value="091">091-Business Savings Account</option>
                                        </optgroup>
                                        <optgroup label="Current">
                                            <option value="610">610-Accounts Receivable</option>
                                            <option value="620">620-Prepayments</option>
                                        </optgroup>
                                    </select>
                                </dd>
                                <dt><label for="">Cash2 payments (deleted)</label></dt>
                                <dd>
                                    <select name="" id="">
                                        <option value="" selected="selected"></option>
                                        <optgroup label="Bank">
                                            <option value="090">090-Business Bank Account</option>
                                            <option value="091">091-Business Savings Account</option>
                                        </optgroup>
                                        <optgroup label="Current">
                                            <option value="610">610-Accounts Receivable</option>
                                            <option value="620">620-Prepayments</option>
                                        </optgroup>
                                    </select>
                                </dd>
                                <dt><label for="">Cash2 payments (deleted)</label></dt>
                                <dd>
                                    <select name="" id="">
                                        <option value="" selected="selected"></option>
                                        <optgroup label="Bank">
                                            <option value="090">090-Business Bank Account</option>
                                            <option value="091">091-Business Savings Account</option>
                                        </optgroup>
                                        <optgroup label="Current">
                                            <option value="610">610-Accounts Receivable</option>
                                            <option value="620">620-Prepayments</option>
                                        </optgroup>
                                    </select>
                                </dd>
                                <dt><label for="">Cash2 payments (deleted)</label></dt>
                                <dd>
                                    <select name="" id="">
                                        <option value="" selected="selected"></option>
                                        <optgroup label="Bank">
                                            <option value="090">090-Business Bank Account</option>
                                            <option value="091">091-Business Savings Account</option>
                                        </optgroup>
                                        <optgroup label="Current">
                                            <option value="610">610-Accounts Receivable</option>
                                            <option value="620">620-Prepayments</option>
                                        </optgroup>
                                    </select>
                                </dd>
                                <dt><label for="">Cash2 payments (deleted)</label></dt>
                                <dd>
                                    <select name="" id="">
                                        <option value="" selected="selected"></option>
                                        <optgroup label="Bank">
                                            <option value="090">090-Business Bank Account</option>
                                            <option value="091">091-Business Savings Account</option>
                                        </optgroup>
                                        <optgroup label="Current">
                                            <option value="610">610-Accounts Receivable</option>
                                            <option value="620">620-Prepayments</option>
                                        </optgroup>
                                    </select>
                                </dd>
                                <dt><label for="">Credit Card payments</label></dt>
                                <dd>
                                    <select name="" id="">
                                        <option value="" selected="selected"></option>
                                        <optgroup label="Bank">
                                            <option value="090">090-Business Bank Account</option>
                                            <option value="091">091-Business Savings Account</option>
                                        </optgroup>
                                        <optgroup label="Current">
                                            <option value="610">610-Accounts Receivable</option>
                                            <option value="620">620-Prepayments</option>
                                        </optgroup>
                                    </select>
                                </dd>
                                <dt><label for="">Credit Note payments</label></dt>
                                <dd>
                                    <select name="" id="">
                                        <option value="" selected="selected"></option>
                                        <optgroup label="Bank">
                                            <option value="090">090-Business Bank Account</option>
                                            <option value="091">091-Business Savings Account</option>
                                        </optgroup>
                                        <optgroup label="Current">
                                            <option value="610">610-Accounts Receivable</option>
                                            <option value="620">620-Prepayments</option>
                                        </optgroup>
                                    </select>
                                </dd>
                                <dt><label for="">EFTPOS payments</label></dt>
                                <dd>
                                    <select name="" id="">
                                        <option value="" selected="selected"></option>
                                        <optgroup label="Bank">
                                            <option value="090">090-Business Bank Account</option>
                                            <option value="091">091-Business Savings Account</option>
                                        </optgroup>
                                        <optgroup label="Current">
                                            <option value="610">610-Accounts Receivable</option>
                                            <option value="620">620-Prepayments</option>
                                        </optgroup>
                                    </select>
                                </dd>
                                <dt><label for="">Integrated EFTPOS (DPS) payments</label></dt>
                                <dd>
                                    <select name="" id="">
                                        <option value="" selected="selected"></option>
                                        <optgroup label="Bank">
                                            <option value="090">090-Business Bank Account</option>
                                            <option value="091">091-Business Savings Account</option>
                                        </optgroup>
                                        <optgroup label="Current">
                                            <option value="610">610-Accounts Receivable</option>
                                            <option value="620">620-Prepayments</option>
                                        </optgroup>
                                    </select>
                                </dd>
<!--
                                <dt><label for="">PayPal payments</label></dt>
                                <dd>
                                    <select name="" id="">
                                        <option value="" selected="selected"></option>
                                        <optgroup label="Bank">
                                            <option value="090">090-Business Bank Account</option>
                                            <option value="091">091-Business Savings Account</option>
                                        </optgroup>
                                        <optgroup label="Current">
                                            <option value="610">610-Accounts Receivable</option>
                                            <option value="620">620-Prepayments</option>
                                        </optgroup>
                                    </select>
                                </dd>
                                <dt><label for="">Square payments</label></dt>
                                <dd>
                                    <select name="" id="">
                                        <option value="" selected="selected"></option>
                                        <optgroup label="Bank">
                                            <option value="090">090-Business Bank Account</option>
                                            <option value="091">091-Business Savings Account</option>
                                        </optgroup>
                                        <optgroup label="Current">
                                            <option value="610">610-Accounts Receivable</option>
                                            <option value="620">620-Prepayments</option>
                                        </optgroup>
                                    </select>
                                </dd>
-->
                                <dt><label for="">Loyalty payments</label></dt>
                                <dd>
                                    <select name="" id="">
                                        <option value="" selected="selected"></option>
                                        <optgroup label="Current Liability">
                                            <option value="800">800-Accounts Payable</option>
                                            <option value="801">801-Unpaid Expense Claims</option>
                                            <option value="820">820-Sales Tax</option>
                                            <option value="825">825-Employee Tax Payable</option>
                                            <option value="826">826-Superannuation Payable</option>
                                            <option value="830">830-Income Tax Payable</option>
                                            <option value="835">835-Revenue Received in Advance</option>
                                            <option value="840">840-Historical Adjustment</option>
                                            <option value="850">850-Suspense</option>
                                            <option value="855">855-Clearing Account</option>
                                            <option value="860">860-Rounding</option>
                                            <option value="877">877-Tracking Transfers</option>
                                            <option value="880">880-Owner A Drawings</option>
                                            <option value="881">881-Owner A Funds Introduced</option>
                                        </optgroup>
                                    </select>
                                </dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="form-horizontal col-md-12 col-xs-12 col-sm-12">
                    <div class="col-md-12 col-xs-12 col-sm-12 form-title margin-top-20">Accounts for Sales Taxes</div>
                    <div class="form-body line line-box line-box-content col-md-12 col-xs-12 col-sm-12"> 
                        <div class="col-md-6">
                            <dl>
                                <dt><label for="">GST</label></dt>
                                <dd>
                                    <select name="" id="">
                                        <option value="" selected="selected"></option>
                                        <option value="GSTONIMPORTS">Sales Tax on Imports</option>
                                        <option value="NONE">Tax Exempt</option>
                                        <option value="OUTPUT">Tax on Consulting</option>
                                        <option value="TAX001">Tax on Goods</option>
                                        <option value="INPUT">Tax on Purchases</option>
                                    </select>
                                </dd>
                                <dt><label for="">No Tax</label></dt>
                                <dd>
                                    <select name="" id="">
                                        <option value="" selected="selected"></option>
                                        <option value="GSTONIMPORTS">Sales Tax on Imports</option>
                                        <option value="NONE">Tax Exempt</option>
                                        <option value="OUTPUT">Tax on Consulting</option>
                                        <option value="TAX001">Tax on Goods</option>
                                        <option value="INPUT">Tax on Purchases</option>
                                    </select>
                                </dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="form-horizontal col-md-12 col-xs-12 col-sm-12">
                    <div class="col-md-12 col-xs-12 col-sm-12 form-title margin-top-20">Other Options</div>
                    <div class="form-body line line-box line-box-content col-md-12 col-xs-12 col-sm-12"> 
                        <div class="col-md-6">
                            <dl>
                                <dt><label for="">Loyalty expense</label></dt>
                                <dd>
                                    <select name="" id="">
                                        <option value="" selected="selected"></option>
                                        <optgroup label="Expense">
                                            <option value="400">400-Advertising</option>
                                            <option value="404">404-Bank Fees</option>
                                            <option value="408">408-Cleaning</option>
                                            <option value="412">412-Consulting &amp; Accounting</option>
                                            <option value="416">416-Depreciation</option>
                                            <option value="420">420-Entertainment</option>
                                            <option value="425">425-Freight &amp; Courier</option>
                                            <option value="429">429-General Expenses</option>
                                            <option value="433">433-Insurance</option>
                                            <option value="437">437-Interest Expense</option>
                                            <option value="441">441-Legal expenses</option>
                                            <option value="445">445-Light, Power, Heating</option>
                                            <option value="449">449-Motor Vehicle Expenses</option>
                                            <option value="453">453-Office Expenses</option>
                                            <option value="461">461-Printing &amp; Stationery</option>
                                            <option value="469">469-Rent</option>
                                            <option value="473">473-Repairs and Maintenance</option>
                                            <option value="477">477-Wages and Salaries</option>
                                            <option value="478">478-Superannuation</option>
                                            <option value="485">485-Subscriptions</option>
                                            <option value="489">489-Telephone &amp; Internet</option>
                                            <option value="493">493-Travel - National</option>
                                            <option value="494">494-Travel - International</option>
                                            <option value="497">497-Bank Revaluations</option>
                                            <option value="498">498-Unrealised Currency Gains</option>
                                            <option value="499">499-Realised Currency Gains</option>
                                            <option value="505">505-Income Tax Expense</option>
                                        </optgroup>
                                    </select>
                                </dd>
                                <dt><label for="">Send invoices as</label></dt>
                                <dd>
                                    <select name="" id="">
                                        <option value="0" selected="selected">Approved</option>
                                        <option value="1">Awaiting approval</option>
                                        <option value="2">Draft</option>
                                    </select>
                                </dd>
                                <dt><label for="">Register closure detail</label></dt>
                                <dd>
                                    <select name="" id="">
                                        <option value="register_sale_product_id">Detail each sale</option>
                                        <option value="product_id">Send a summary by product</option>
                                        <option value="account_code" selected="selected">Send a summary by account code</option>
                                    </select>
                                </dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 pull-right margin-top-20 margin-bottom-20">
                <button class="btn btn-primary btn-wide save pull-right">Save</button>
                <button class="btn btn-default btn-wide pull-right margin-right-10">Cancel</button>
            </div>
        </div>
    </div>
    <!-- END CONTENT --> 
    <!-- ADD TAX POPUP BOX -->
    <div id="popup-add_tax" class="confirmation-modal modal fade in" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="confirm-close" data-dismiss="modal" aria-hidden="true">
                    <i class="glyphicon glyphicon-remove"></i>
                    </button>
                    <h4 class="modal-title">Add New Sales Tax</h4>
                </div>
                <div class="modal-body">
                    <dl>
                        <dt>Tax name</dt>
                        <dd><input type="text" id="tax_name"></dd>
                        <dt>Tax rate (%)</dt>
                        <dd><input type="text" id="tax_rate"></dd>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary confirm-close">Cancel</button>
                    <button class="btn btn-success submit">Add</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ADD TAX POPUP BOX END -->
</div>
<div class="modal-backdrop fade in" style="display: none;"></div>
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) --> 
<!-- BEGIN CORE PLUGINS --> 
<!--[if lt IE 9]>
<script src="/theme/onzsa/assets/global/plugins/respond.min.js"></script>
<script src="/theme/onzsa/assets/global/plugins/excanvas.min.js"></script> 
<![endif]--> 
<script src="/theme/onzsa/assets/global/plugins/jquery-1.11.0.min.js" type="text/javascript"></script> 
<script src="/theme/onzsa/assets/global/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script> 
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip --> 
<script src="/theme/onzsa/assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script> 
<script src="/theme/onzsa/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script> 
<script src="/theme/onzsa/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script> 
<script src="/theme/onzsa/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script> 
<script src="/theme/onzsa/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script> 
<script src="/theme/onzsa/assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script> 
<script src="/theme/onzsa/assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script> 
<script src="/theme/onzsa/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script> 
<!-- END CORE PLUGINS --> 
<!-- BEGIN PAGE LEVEL PLUGINS --> 
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script> 
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script> 
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script> 
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script> 
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script> 
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script> 
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script> 
<script src="/theme/onzsa/assets/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script> 
<script src="/theme/onzsa/assets/global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script> 
<script src="/theme/onzsa/assets/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script> 
<script src="/theme/onzsa/assets/global/plugins/jquery.pulsate.min.js" type="text/javascript"></script> 
<script src="/theme/onzsa/assets/global/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script> 
<script src="/theme/onzsa/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script> 
<!-- IMPORTANT! fullcalendar depends on jquery-ui-1.10.3.custom.min.js for drag & drop support --> 
<script src="/theme/onzsa/assets/global/plugins/fullcalendar/fullcalendar/fullcalendar.min.js" type="text/javascript"></script> 
<script src="/theme/onzsa/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script> 
<script src="/theme/onzsa/assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script> 
<script src="/theme/onzsa/assets/global/plugins/gritter/js/jquery.gritter.js" type="text/javascript"></script> 
<!-- END PAGE LEVEL PLUGINS --> 
<!-- BEGIN PAGE LEVEL SCRIPTS --> 
<script src="/theme/onzsa/assets/global/scripts/metronic.js" type="text/javascript"></script> 
<script src="/theme/onzsa/assets/admin/layout/scripts/layout.js" type="text/javascript"></script> 
<script src="/theme/onzsa/assets/admin/pages/scripts/index.js" type="text/javascript"></script> 
<script src="/theme/onzsa/assets/admin/pages/scripts/tasks.js" type="text/javascript"></script> 
<script src="/js/notify.js" type="text/javascript"></script> 
<!-- END PAGE LEVEL SCRIPTS --> 
<script>
jQuery(document).ready(function() {    
    Metronic.init(); // init metronic core componets
    Layout.init(); // init layout
    Index.init();
});
</script> 
<!-- END JAVASCRIPTS -->
