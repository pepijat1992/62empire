$(document).ready(function () {
    "use strict"; // Start of use strict
    var glyphs, i, len, ref;

    ref = document.getElementsByClassName('glyphs');
    for (i = 0, len = ref.length; i < len; i++) {
        glyphs = ref[i];
        glyphs.addEventListener('click', function (event) {
            if (event.target.tagName === 'INPUT') {
                return event.target.select();
            }
        });
    }
});