$(document).ready(function () {
    'use strict';
    $(".basic-single").select2();
    $(".basic-multiple").select2();
    $(".placeholder-single").select2({
        placeholder: "Select a state",
        allowClear: true
    });
    $(".placeholder-multiple").select2({
        placeholder: "Select a state"
    });
    $(".theme-single").select2();
    $(".language").select2({
        language: "es"
    });
    $(".js-programmatic-enable").on("click", function () {
        $(".js-example-disabled").prop("disabled", false);
        $(".js-example-disabled-multi").prop("disabled", false);
    });
    $(".js-programmatic-disable").on("click", function () {
        $(".js-example-disabled").prop("disabled", true);
        $(".js-example-disabled-multi").prop("disabled", true);
    });
});