$(document).ready(function () {
    "use strict"; // Start of use strict
    Dropzone.options.dropzoneForm = {
        paramName: "file", // The name that will be used to transfer the file
        maxFilesize: 2 // MB
    };
});