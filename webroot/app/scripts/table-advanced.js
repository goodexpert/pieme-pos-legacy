

var TableAdvanced = function () {

    var initSaleItemsTable = function () {

        var table = $('#table_sales_items');
        if (table == undefined) return;

        /* Fixed header extension: http://datatables.net/extensions/scroller/ */

        var oTable = table.dataTable({
            "dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // datatable layout without  horizobtal scroll
            "scrollY": "234px",
            "deferRender": true,
            "paging": false,
            "searching": false,
            "ordering": false,
            "info": false,
            "language" : {
              "emptyTable": "&nbsp;",
              "zeroRecords": "&nbsp;"
            }
            /*
            "order": [
                [0, 'asc']
            ],
            "lengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "All"] // change per page values here
            ],
            "pageLength": 10 // set the initial value            
            */
        });

        var tableWrapper = $('#table_sale_items_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
    }

    var initRecallSaleTable = function () {

        var table = $('#table_recall_sale');
        if (table == undefined) return;

        /* Fixed header extension: http://datatables.net/extensions/scroller/ */

        var oTable = table.dataTable({
            "dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // datatable layout without  horizobtal scroll
            "scrollY": "480px",
            "deferRender": true,
            "paging": false,
            "searching": false,
            "ordering": false,
            "info": false,
            "language" : {
                "emptyTable": "&nbsp;",
                "zeroRecords": "&nbsp;"
            }
            /*
             "order": [
             [0, 'asc']
             ],
             "lengthMenu": [
             [5, 15, 20, -1],
             [5, 15, 20, "All"] // change per page values here
             ],
             "pageLength": 10 // set the initial value
             */
        });

        var tableWrapper = $('#table_recall_sale_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
    }

    return {

        //main function to initiate the module
        init: function () {

            if (!jQuery().dataTable) {
                return;
            }

            initSaleItemsTable();
            initRecallSaleTable();
        }

    };

}();
