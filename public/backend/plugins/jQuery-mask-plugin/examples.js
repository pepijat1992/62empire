$(document).ready(function () {
    "use strict"; // Start of use strict
    $('.date').mask('00/00/0000');
    $('.time').mask('00:00:00');
    $('.date_time').mask('00/00/0000 00:00:00');
    $('.cep').mask('00000-000');
    $('.phone').mask('0000-0000');
    $('.phone_with_ddd').mask('(00) 0000-0000');
    $('.phone_us').mask('(000) 000-0000');
    $('.mixed').mask('AAA 000-S0S');
    $('.cpf').mask('000.000.000-00', {reverse: true});
    $('.cnpj').mask('00.000.000/0000-00', {reverse: true});
    $('.money').mask('000.000.000.000.000,00', {reverse: true});
    $('.money2').mask("#.##0,00", {reverse: true});
    $('.ip_address').mask('0ZZ.0ZZ.0ZZ.0ZZ', {
        translation: {
            'Z': {
                pattern: /[0-9]/, optional: true
            }
        }
    });
    $('.ip_address').mask('099.099.099.099');
    $('.percent').mask('##0,00%', {reverse: true});
    $('.clear-if-not-match').mask("00/00/0000", {clearIfNotMatch: true});
    $('.placeholder').mask("00/00/0000", {placeholder: "__/__/____"});
    $('.fallback').mask("00r00r0000", {
        translation: {
            'r': {
                pattern: /[\/]/,
                fallback: '/'
            },
            placeholder: "__/__/____"
        }
    });
    $('.selectonfocus').mask("00/00/0000", {selectOnFocus: true});


    var options = {
        onComplete: function (cep) {
            alert('CEP Completed!:' + cep);
        },
        onKeyPress: function (cep, event, currentField, options) {
            console.log('An key was pressed!:', cep, ' event: ', event,
                    'currentField: ', currentField, ' options: ', options);
        },
        onChange: function (cep) {
            console.log('cep changed! ', cep);
        },
        onInvalid: function (val, e, f, invalid, options) {
            var error = invalid[0];
            console.log("Digit: ", error.v, " is invalid for the position: ", error.p, ". We expect something like: ", error.e);
        }
    };

    $('.cep_with_callback').mask('00000-000', options);

    var options = {
        onKeyPress: function (cep, e, field, options) {
            var masks = ['00000-000', '0-00-00-00'];
            var mask = (cep.length > 7) ? masks[1] : masks[0];
            $('.crazy_cep').mask(mask, options);
        }};

    $('.crazy_cep').mask('00000-000', options);

    var SPMaskBehavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
            spOptions = {
                onKeyPress: function (val, e, field, options) {
                    field.mask(SPMaskBehavior.apply({}, arguments), options);
                }
            };

    $('.sp_celphones').mask(SPMaskBehavior, spOptions);

    $(".bt-mask-it").on("click", function () {
        $(".mask-on-div").mask("000.000.000-00");
        $(".mask-on-div").fadeOut(500).fadeIn(500);
    });

});