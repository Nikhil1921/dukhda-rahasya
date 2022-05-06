var url = $("#base_url").val();
const ADMIN = $("input[name='admin']").val();
const dataTableUrl = $("input[name='dataTableUrl']").val();

const table = $('.datatable').DataTable({
    "pagingType": "full_numbers",
    "lengthMenu": [
      [10, 25, 50, -1],
      [10, 25, 50, "All"]
    ],
    dom: 'Bfrtip',
    buttons: [
        'pageLength',
        {
            extend: 'print',
            footer: true,
            exportOptions: {
                columns: ':visible'
            },
        },
        {
            extend: 'csv',
            footer: true,
            exportOptions: {
                columns: ':visible'
            },
        },
        'colvis'
    ],
    columnDefs: [ {
        targets: -1,
        visible: false
    } ],
    "processing": true,
    "serverSide": true,
    'language': {
        'loadingRecords': '&nbsp;',
        'processing': 'Processing',
        'paginate': {
            'first': 'First',
            'next': '<i class="fa fa-arrow-circle-right"></i>',
            'previous': '<i class="fa fa-arrow-circle-left"></i>',
            'last': 'Last'
        }
    },
    "order": [],
    "ajax": {
        url: dataTableUrl,
        type: "GET",
        data: function(data) {
            data.status = $("select[name='status']").val() ? $("select[name='status']").val() : $("input[name='status']").val();
            data.approval = $("input[name='approval']").val();
        },
        complete: function(response) {
            
        },
    },
    "columnDefs": [{
        "targets": "target",
        "orderable": false,
    }, ],
    "footerCallback": function ( row, data, start, end, display ) {
        var api = this.api(), data;
        var intVal = function ( i ) {
            return typeof i === 'string' ?
                i.replace(/[\$,]/g, '')*1 :
                typeof i === 'number' ?
                    i : 0;
        };

        if (dataTableUrl.indexOf('adminPanel') !== -1 && dataTableUrl.indexOf('orders') !== -1) {
            // Total over this page
            totalPrice = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            totalMargin = api
                .column( 6, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
    
            // Update footer
            $( api.column( 5 ).footer() ).html(
                '₹ '+totalPrice
            );
            
            $( api.column( 6 ).footer() ).html(
                '₹ '+totalMargin
            );
        } else if (dataTableUrl.indexOf('lab-partner') !== -1 && dataTableUrl.indexOf('orders') !== -1) {
            // Total over this page
            totalPrice = api
                .column( 6, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
    
            // Update footer
            $( api.column( 6 ).footer() ).html(
                '₹ '+totalPrice
            );
        }
    }
});

$("select[name=status]").change(() => {
  table.ajax.reload();
});

const getOrderDetails = (id) => {
    $.get(`${url}getOrderDetails`,{id: id}, function (result) {
        $(".order-modal").find(".modal-body").html(result);
        $(".order-modal").modal("toggle");
      }
    );
}

const changeEmps = (role) => {
    $("input[name='status']").val(role);
    table.ajax.reload();
};

const changeApproval = (app) => {
    $("input[name='approval']").val(app);
    table.ajax.reload();
};