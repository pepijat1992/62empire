(function ($) {
    "use strict";
    var tableSources = {
        initialize: function () {
            this.baseStyle();
            this.noStyling();
            this.compact();
            this.hover();
        },
        baseStyle: function () {
            $('.base-style').DataTable({
                language: {
                    oPaginate: {
                        sNext: '<i class="ti-angle-right"></i>',
                        sPrevious: '<i class="ti-angle-left"></i>'
                    }
                }
            });
        },
        noStyling: function () {
            $('.no-styling').DataTable({
                language: {
                    oPaginate: {
                        sNext: '<i class="ti-angle-right"></i>',
                        sPrevious: '<i class="ti-angle-left"></i>'
                    }
                }
            });
        },
        compact: function () {
            $('.compact').DataTable({
                language: {
                    oPaginate: {
                        sNext: '<i class="ti-angle-right"></i>',
                        sPrevious: '<i class="ti-angle-left"></i>'
                    }
                }
            });
        },
        hover: function () {
            $('.hover').DataTable({
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
        tableSources.initialize();
    });
}(jQuery));


