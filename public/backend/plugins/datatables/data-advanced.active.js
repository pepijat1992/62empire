(function ($) {
    "use strict";
    var tableAdvanced = {
        initialize: function () {
            this.domjQueryEvents();
            this.dataTablesEvents();
            this.columnRendering();
            this.pageLengthOptions();
            this.multipleTableControlElements();
            this.complexHeadersWithColumnVisibility();
            this.languageFile();
            this.settingDefaults();
            this.rowCreatedCallback();
            this.rowGrouping();
            this.customToolbarElements();
            this.orderDirectionSequenceControl();
        },
        domjQueryEvents: function () {
            var table = $('.dom-jQuery-events').DataTable();
            $('.dom-jQuery-events tbody').on('click', 'tr', function () {
                var data = table.row(this).data();
                alert('You clicked on ' + data[0] + '\'s row');
            });
        },
        dataTablesEvents: function () {
            var eventFired = function (type) {
                var n = $('#demo_info')[0];
                n.innerHTML += '<div>' + type + ' event - ' + new Date().getTime() + '</div>';
                n.scrollTop = n.scrollHeight;
            };
            $('.data-tables-events')
                    .on('order.dt', function () {
                        eventFired('Order');
                    })
                    .on('search.dt', function () {
                        eventFired('Search');
                    })
                    .on('page.dt', function () {
                        eventFired('Page');
                    })
                    .DataTable();
        },
        columnRendering: function () {
            $('.column-rendering').DataTable({
                "columnDefs": [
                    {
                        // The `data` parameter refers to the data for the cell (defined by the
                        // `data` option, which defaults to the column being worked with, in
                        // this case `data: 0`.
                        "render": function (data, type, row) {
                            return data + ' (' + row[3] + ')';
                        },
                        "targets": 0
                    },
                    {"visible": false, "targets": [3]}
                ]
            });
        },
        pageLengthOptions: function () {
            $('.page-length-options').DataTable({
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
            });
        },
        multipleTableControlElements: function () {
            $(document).ready(function () {
                $('.multiple-table-control-elements').DataTable({
                    "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
                });
            });
        },
        complexHeadersWithColumnVisibility: function () {
            $('.complex-headers-with-column-visibility').DataTable({
                "columnDefs": [{
                        "visible": false,
                        "targets": -1
                    }]
            });
        },
        languageFile: function () {
            $('.language-file').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/German.json"
                }
            });
        },
        settingDefaults: function () {
            $.extend(true, $.fn.dataTable.defaults, {
                "searching": false,
                "ordering": false
            });
            $(document).ready(function () {
                $('.setting-defaults').DataTable();
            });
        },
        rowCreatedCallback: function () {
            $('.row-created-callback').DataTable({
                "createdRow": function (row, data, index) {
                    if (data[5].replace(/[\$,]/g, '') * 1 > 150000) {
                        $('td', row).eq(5).addClass('highlight');
                    }
                }
            });
        },
        rowGrouping: function () {
            var groupColumn = 2;
            var table = $('.row-grouping').DataTable({
                "columnDefs": [
                    {"visible": false, "targets": groupColumn}
                ],
                "order": [[groupColumn, 'asc']],
                "displayLength": 25,
                "drawCallback": function (settings) {
                    var api = this.api();
                    var rows = api.rows({page: 'current'}).nodes();
                    var last = null;

                    api.column(groupColumn, {page: 'current'}).data().each(function (group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before(
                                    '<tr class="group"><td colspan="5">' + group + '</td></tr>'
                                    );

                            last = group;
                        }
                    });
                }
            });
            // Order by the grouping
            $('.row-grouping tbody').on('click', 'tr.group', function () {
                var currentOrder = table.order()[0];
                if (currentOrder[0] === groupColumn && currentOrder[1] === 'asc') {
                    table.order([groupColumn, 'desc']).draw();
                } else {
                    table.order([groupColumn, 'asc']).draw();
                }
            });
        },
        customToolbarElements: function () {
            $('.custom-toolbar-elements').DataTable({
                "dom": '<"toolbar">frtip'
            });
            $("div.toolbar").html('<b>Custom tool bar! Text/images etc.</b>');
        },
        orderDirectionSequenceControl: function () {
            $('.order-direction-sequence-control').DataTable({
                "aoColumns": [
                    null,
                    null,
                    {"orderSequence": ["asc"]},
                    {"orderSequence": ["desc", "asc", "asc"]},
                    {"orderSequence": ["desc"]},
                    null
                ]
            });
        },
    };
    // Initialize
    $(document).ready(function () {
        "use strict"; // Start of use strict
        tableAdvanced.initialize();
    });

}(jQuery));