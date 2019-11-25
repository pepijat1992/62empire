$(document).ready(function () {
    $('.chat-list__in').each(function () {
        const ps = new PerfectScrollbar($(this)[0]);
    });
    $('.message-content-scroll').each(function () {
        const ps = new PerfectScrollbar($(this)[0]);
    });
    $('.chat-list__sidebar--right').each(function () {
        const ps = new PerfectScrollbar($(this)[0]);
    });
    //emojionearea
    $(".emojionearea").emojioneArea({
        pickerPosition: "top",
        filtersPosition: "bottom",
        tones: false,
        autocomplete: false,
        inline: true,
        hidePickerOnBlur: false
    });
    $('[data-toggle="popover"]').popover({
        html: true
//                    trigger: 'focus'
    });
    $('.change-bg-color label').on('click', function () {
        var color = $(this).data('color');

        $('.message-content').each(function () {
            $(this).removeClass(function (index, css) {
                return (css.match(/(^|\s)bg-\S+/g) || []).join(' ');
            });

            $(this).addClass('bg-text-' + color);
        });
    });
    var e = document.getElementById("autobot"),
            d = document.getElementById("manual"),
            t = document.getElementById("switcher");
    e.addEventListener("click", function () {
        t.checked = false;
        e.classList.add("toggler--is-active");
        d.classList.remove("toggler--is-active");
    });
    d.addEventListener("click", function () {
        t.checked = true;
        d.classList.add("toggler--is-active");
        e.classList.remove("toggler--is-active");
    });
    t.addEventListener("click", function () {
        d.classList.toggle("toggler--is-active");
        e.classList.toggle("toggler--is-active");
    });
    //Toggle Search
    $(".chat-header").each(function () {
        $(".search-btn", this).on("click", function (e) {
            e.preventDefault();
            $(".conversation-search").slideToggle();
        });
    });
    $(".close-search").on("click", function () {
        $(".conversation-search").slideUp();
    });
    $('.chat-overlay, .chat-list .item-list').on('click', function () {
        $('.chat-list__sidebar, .chat-list__sidebar--right').removeClass('active');
        $('.chat-overlay').removeClass('active');
    });
    $('.chat-sidebar-collapse').on('click', function () {
        $('.chat-list__sidebar').addClass('active');
        $('.chat-overlay').addClass('active');
        $('.collapse.in').toggleClass('in');
    });
    $('.chat-settings-collapse').on('click', function () {
        $('.chat-list__sidebar--right').addClass('active');
        $('.chat-overlay').addClass('active');
        $('.collapse.in').toggleClass('in');
    });
});

