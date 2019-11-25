(function ($) {
    "use strict";
    var tableBasic = {
        initialize: function () {
            this.basic();
            this.enableDisable();
            this.ordering();
            this.multiColumnOrdering();
            this.multipleTables();
            this.hiddenColumns();
            this.complexHeaders();
            this.domPositioning();
            this.alternativePagination();
            this.scrollVertical();
            this.dynamicHeight();
            this.scrollHorizontal();
            this.scrollHorizontalVertical();
            this.languageCommaDecimalPlace();
            this.languageOptions();
        },
        basic: function () {
            $('.basic').DataTable({
                iDisplayLength: 8,
                language: {
                    oPaginate: {
                        sNext: '<i class="ti-angle-right"></i>',
                        sPrevious: '<i class="ti-angle-left"></i>'
                    }
                }
            });
        },
        enableDisable: function () {
            $('.enable-disable').DataTable({
                "paging": false,
                "ordering": false,
                "info": false
            });
        },
        ordering: function () {
            $('.ordering').DataTable({
                "order": [[3, "desc"]]
            });
        },
        multiColumnOrdering: function () {
            $('.multi-column-ordering').DataTable({
                columnDefs: [{
                        targets: [0],
                        orderData: [0, 1]
                    }, {
                        targets: [1],
                        orderData: [1, 0]
                    }, {
                        targets: [4],
                        orderData: [4, 0]
                    }]
            });
        },
        multipleTables: function () {
            $('.multi-tables').DataTable();
        },
        hiddenColumns: function () {
            $('.hidden-columns').DataTable({
                "columnDefs": [
                    {
                        "targets": [2],
                        "visible": false,
                        "searchable": false
                    },
                    {
                        "targets": [3],
                        "visible": false
                    }
                ]
            });
        },
        complexHeaders: function () {
            $('.complex-headers').DataTable();
        },
        domPositioning: function () {
            $('.dom-positioning').DataTable({
                "dom": '<"top"i>rt<"bottom"flp><"clear">'
            });
        },
        alternativePagination: function () {
            $('.alternative-pagination').DataTable({
                "pagingType": "full_numbers"
            });
        },
        scrollVertical: function () {
            $('.scroll-vertical').DataTable({
                "scrollY": "200px",
                "scrollCollapse": true,
                "paging": false
            });
        },
        dynamicHeight: function () {
            $('.dynamic-height').DataTable({
                scrollY: '50vh',
                scrollCollapse: true,
                paging: false
            });
        },
        scrollHorizontal: function () {
            $(document).ready(function () {
                $('.scroll-horizontal').DataTable({
                    "scrollX": true
                });
            });
        },
        scrollHorizontalVertical: function () {
            $('.scroll-horizontal-vertical').DataTable({
                "scrollY": 200,
                "scrollX": true
            });
        },
        languageCommaDecimalPlace: function () {
            $('.language-comma-decimal-place').DataTable({
                "language": {
                    "decimal": ",",
                    "thousands": "."
                }
            });

        },
        languageOptions: function () {
            $('.language-options').DataTable({
                "language": {
                    "lengthMenu": "Display _MENU_ records per page",
                    "zeroRecords": "Nothing found - sorry",
                    "info": "Showing page _PAGE_ of _PAGES_",
                    "infoEmpty": "No records available",
                    "infoFiltered": "(filtered from _MAX_ total records)"
                }
            });
        }
    };
    // Initialize
    $(document).ready(function () {
        "use strict"; // Start of use strict
        tableBasic.initialize();
    });

}(jQuery));