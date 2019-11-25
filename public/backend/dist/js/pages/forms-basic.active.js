(function ($) {
    "use strict";
    var tableBasic = {
        initialize: function () {
            this.fileBrowser();
            this.tooltips();
        },
        fileBrowser: function () {
            //Custom input file


            // Variables

            var $customInputFile = $('.custom-input-file');


            // Methods

            function change($input, $this, $e) {
                var fileName,
                        $label = $input.next('label'),
                        labelVal = $label.html();

                if ($this && $this.files.length > 1) {
                    fileName = ($this.getAttribute('data-multiple-caption') || '').replace('{count}', $this.files.length);
                } else if ($e.target.value) {
                    fileName = $e.target.value.split('\\').pop();
                }

                if (fileName) {
                    $label.find('span').html(fileName);
                } else {
                    $label.html(labelVal);
                }
            }

            function focus($input) {
                $input.addClass('has-focus');
            }

            function blur($input) {
                $input.removeClass('has-focus');
            }


            // Events

            if ($customInputFile.length) {
                $customInputFile.each(function () {
                    var $input = $(this);

                    $input.on('change', function (e) {
                        var $this = this,
                                $e = e;

                        change($input, $this, $e);
                    });

                    // Firefox bug fix
                    $input.on('focus', function () {
                        focus($input);
                    })
                            .on('blur', function () {
                                blur($input);
                            });
                });
            }

        },
        tooltips: function () {
            // Example starter JavaScript for disabling form submissions if there are invalid fields
            window.addEventListener('load', function () {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function (form) {
                    form.addEventListener('submit', function (event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        }
    };
    // Initialize
    $(document).ready(function () {
        "use strict"; // Start of use strict
        tableBasic.initialize();
        $('#customCheck2').prop('indeterminate', true);
    });
    $(window).on("load", function () {
        tableBasic.tooltips();
    });

}(jQuery));