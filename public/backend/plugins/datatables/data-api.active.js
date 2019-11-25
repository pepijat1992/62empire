(function ($) {
    "use strict";
    var tableAPI = {
        initialize: function () {
            this.addRow();
            this.textInputsSearching();
            this.columnSearching();
            this.highlightingRowsColumns();
            this.childRows();
            this.rowSelection();
            this.selectionDeletion();
            this.formInputs();
            this.indexColumn();
            this.showHideColumns();
            this.apiInCallbacks();
        },
        addRow: function () {
            var t = $('.add-rows').DataTable({
                language: {
                    oPaginate: {
                        sNext: '<i class="ti-angle-right"></i>',
                        sPrevious: '<i class="ti-angle-left"></i>'
                    }
                }
            });
            var counter = 1;

            $('#addRow').on('click', function () {
                t.row.add([
                    counter + '.1',
                    counter + '.2',
                    counter + '.3',
                    counter + '.4',
                    counter + '.5'
                ]).draw(false);

                counter++;
            });

            // Automatically add a first row of data
            $('#addRow').click();
        },
        textInputsSearching: function () {
            // Setup - add a text input to each footer cell
            $('.text-inputs-searching tfoot th').each(function () {
                var title = $(this).text();
                $(this).html('<input type="text" placeholder="Search ' + title + '" />');
            });

            // DataTable
            var table = $('.text-inputs-searching').DataTable({
                language: {
                    oPaginate: {
                        sNext: '<i class="ti-angle-right"></i>',
                        sPrevious: '<i class="ti-angle-left"></i>'
                    }
                }
            });

            // Apply the search
            table.columns().every(function () {
                var that = this;

                $('input', this.footer()).on('keyup change', function () {
                    if (that.search() !== this.value) {
                        that
                                .search(this.value)
                                .draw();
                    }
                });
            });
        },
        columnSearching: function () {
            $('.column-searching').DataTable({
                language: {
                    oPaginate: {
                        sNext: '<i class="ti-angle-right"></i>',
                        sPrevious: '<i class="ti-angle-left"></i>'
                    }
                },
                initComplete: function () {
                    this.api().columns().every(function () {
                        var column = this;
                        var select = $('<select><option value=""></option></select>')
                                .appendTo($(column.footer()).empty())
                                .on('change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                            $(this).val()
                                            );

                                    column
                                            .search(val ? '^' + val + '$' : '', true, false)
                                            .draw();
                                });

                        column.data().unique().sort().each(function (d, j) {
                            select.append('<option value="' + d + '">' + d + '</option>')
                        });
                    });
                }
            });
        },
        highlightingRowsColumns: function () {
            var table = $('.highlighting-rows-columns').DataTable({
                language: {
                    oPaginate: {
                        sNext: '<i class="ti-angle-right"></i>',
                        sPrevious: '<i class="ti-angle-left"></i>'
                    }
                }
            });
            $('.highlighting-rows-columns tbody')
                    .on('mouseenter', 'td', function () {
                        var colIdx = table.cell(this).index().column;

                        $(table.cells().nodes()).removeClass('highlight');
                        $(table.column(colIdx).nodes()).addClass('highlight');
                    });
        },
        childRows: function () {
            /* Formatting function for row details - modify as you need */
            function format(d) {
                // `d` is the original data object for the row
                return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
                        '<tr>' +
                        '<td>Full name:</td>' +
                        '<td>' + d.name + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td>Extension number:</td>' +
                        '<td>' + d.extn + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td>Extra info:</td>' +
                        '<td>And any further details here (images etc)...</td>' +
                        '</tr>' +
                        '</table>';
            }

            $(document).ready(function () {
                var table = $('.child-rows').DataTable({
                    "ajax": "assets/plugins/datatables/objects.txt",
                    "columns": [
                        {
                            "className": 'details-control',
                            "orderable": false,
                            "data": null,
                            "defaultContent": ''
                        },
                        {"data": "name"},
                        {"data": "position"},
                        {"data": "office"},
                        {"data": "salary"}
                    ],
                    "order": [[1, 'asc']],
                    language: {
                        oPaginate: {
                            sNext: '<i class="ti-angle-right"></i>',
                            sPrevious: '<i class="ti-angle-left"></i>'
                        }
                    }
                });

                // Add event listener for opening and closing details
                $('.child-rows tbody').on('click', 'td.details-control', function () {
                    var tr = $(this).closest('tr');
                    var row = table.row(tr);

                    if (row.child.isShown()) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');
                    } else {
                        // Open this row
                        row.child(format(row.data())).show();
                        tr.addClass('shown');
                    }
                });
            });
        },
        rowSelection: function () {
            var table = $('.row-selection').DataTable({
                language: {
                    oPaginate: {
                        sNext: '<i class="ti-angle-right"></i>',
                        sPrevious: '<i class="ti-angle-left"></i>'
                    }
                }
            });
            $('.row-selection tbody').on('click', 'tr', function () {
                $(this).toggleClass('selected');
            });
            $('.row-selection-btn').on("click",function () {
                alert(table.rows('.selected').data().length + ' row(s) selected');
            });
        },
        selectionDeletion: function () {
            var table = $('.selection-deletion').DataTable({
                language: {
                    oPaginate: {
                        sNext: '<i class="ti-angle-right"></i>',
                        sPrevious: '<i class="ti-angle-left"></i>'
                    }
                }
            });
            $('.selection-deletion tbody').on('click', 'tr', function () {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                } else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            });

            $('.selection-deletion-btn').on("click", function () {
                table.row('.selected').remove().draw(false);
            });
        },
        formInputs: function () {
            var table = $('.form-inputs').DataTable({
                language: {
                    oPaginate: {
                        sNext: '<i class="ti-angle-right"></i>',
                        sPrevious: '<i class="ti-angle-left"></i>'
                    }
                },
                columnDefs: [{
                        orderable: false,
                        targets: [1, 2, 3]
                    }]
            });
            $('.form-inputs-btn').on("click", function () {
                var data = table.$('input, select').serialize();
                alert(
                        "The following data would have been submitted to the server: \n\n" +
                        data.substr(0, 120) + '...'
                        );
                return false;
            });

        },
        indexColumn: function () {
            var t = $('.index-column').DataTable({
                language: {
                    oPaginate: {
                        sNext: '<i class="ti-angle-right"></i>',
                        sPrevious: '<i class="ti-angle-left"></i>'
                    }
                },
                "columnDefs": [{
                        "searchable": false,
                        "orderable": false,
                        "targets": 0
                    }],
                "order": [[1, 'asc']]
            });
            t.on('order.dt search.dt', function () {
                t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();
        },
        showHideColumns: function () {
            var table = $('.show-hide-columns-dynamically').DataTable({
                "scrollY": "200px",
                "paging": false
            });
            $('a.toggle-vis').on('click', function (e) {
                e.preventDefault();
                // Get the column API object
                var column = table.column($(this).attr('data-column'));
                // Toggle the visibility
                column.visible(!column.visible());
            });
        },
        apiInCallbacks: function () {
            $('.api-in-callbacks').DataTable({
                "initComplete": function () {
                    var api = this.api();
                    api.$('td').on("click", function () {
                        api.search(this.innerHTML).draw();
                    });
                },
                language: {
                    oPaginate: {
                        sNext: '<i class="ti-angle-right"></i>',
                        sPrevious: '<i class="ti-angle-left"></i>'
                    }
                }
            });
        }
    };
    // Initialize
    $(document).ready(function () {
        "use strict"; // Start of use strict
        tableAPI.initialize();
    });

}(jQuery));