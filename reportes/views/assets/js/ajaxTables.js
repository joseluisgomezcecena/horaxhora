$(document).ready(function() {
    if(document.getElementById("table_tress"))
    {
        $('#table_tress').DataTable({
            'scrollX': true,
            //'bSort': false,
            //'scrollCollapse': true,
    
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'ajax': {
                'url': 'functions/functions.php?function=selectReportTress'
            },
            'columns': [
                { data: 'count' },
                { data: 'employee_number' },
                { data: 'employee_name' },
                { data: 'hours' },
                { data: 'supervisor' },
                { data: 'posted' }
            ]
        });
    }
    
    if(document.getElementById("table_xa"))
    {
        $('#table_xa').DataTable({
            'scrollX': true,
            //'bSort': false,
            //'scrollCollapse': true,
    
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'ajax': {
                'url': 'functions/functions.php?function=selectReportXa'
            },
            'columns': [
                { data: 'count' },
                { data: 'item' },
                { data: 'description' },
                { data: 'planner' },
                { data: 'whs' },
                { data: 'posted' },
                { data: 'txn' },
                { data: 'order_number' },
                { data: 'quantity' },
                { data: 'class' },
                { data: 'rates' },
                { data: 'yield' },
                { data: 'setup' },
                { data: 'std_hours' },
            ]
        });
    }

});


$(function() {
    $('[data-toggle="tooltip"]').tooltip();


    $('.datepicker').datepicker({
        format: 'mm/dd/yyyy',
        startDate: '-3d'
    });

    $('.datepicker-complete').datepicker({
        format: 'yyyy-mm-dd',
    });
})



var submit_csv = document.getElementById("submit_csv");

if(submit_csv)
{
    submit_csv.addEventListener("submit", () => {
        $("#load_modal").modal("show");
    })
}