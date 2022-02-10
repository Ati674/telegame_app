import {TelegameCommon} from "./AjaxRequest";
import CheckoutPaymentClick from "../vue/components/CheckoutPaymentClick";
import Vue from "vue";

$(document).ready(function () {
    jQuery.extend(jQuery.validator.messages, {
        required: "Requis !",
        min: jQuery.validator.format("Ticket supérieur ou égal à {0}.")
    });
    $('.button-rendering-form-paypal').click(function (e) {
        let $url = $(this).data('path');
        e.preventDefault();
        TelegameCommon.Ajax('GET', $url, null, 'json', successPaypal);
        function successPaypal(response)
        {
            showHideMethod(
                response,
                $('.div-icon-chevron-cb'),
                $('.div-icon-chevron-paypal'),
                $('.div-icon-chevron-binance'),
                $('#form_rendering_cb'),
                $('#form_rendering_paypal'),
                $('#form_rendering_binance'),
                'paypal'
            )
            $('#div-form').removeClass('card-binance card-cb');
            $('#div-form').addClass('card-paypal');
            let app = new Vue({
                render: h => h(CheckoutPaymentClick,
                    {
                        props: {
                            typePayment: 'paypal',
                            ticketNumber: $('#participant_ticketNumber').val()
                        }
                    }),
            }).$mount('#next-button-div')
        }
    });

    $('.button-rendering-form-cb').click(function (e) {
        let $url = $(this).data('path');
        e.preventDefault();
        TelegameCommon.Ajax('GET', $url, null, 'json', successCb);
        function successCb(response)
        {
            showHideMethod(
                response,
                $('.div-icon-chevron-cb'),
                $('.div-icon-chevron-paypal'),
                $('.div-icon-chevron-binance'),
                $('#form_rendering_cb'),
                $('#form_rendering_paypal'),
                $('#form_rendering_binance'),
                'cb'
            )
            $('#div-form').removeClass('card-paypal card-binance')
            $('#div-form').addClass('card-cb');
            let app = new Vue({
                render: h => h(CheckoutPaymentClick,
                    {
                        props: {
                            typePayment: 'cb',
                            ticketNumber: $('#participant_ticketNumber').val()
                        }
                    }),
            }).$mount('#next-button-div')
        }
    });


    $('.button-rendering-form-binance').click(function (e) {
        let $url = $(this).data('path');
        e.preventDefault();
        TelegameCommon.Ajax('GET', $url, null, 'json', successBinance)
        function successBinance(response) {
            showHideMethod(
                response,
                $('.div-icon-chevron-cb'),
                $('.div-icon-chevron-paypal'),
                $('.div-icon-chevron-binance'),
                $('#form_rendering_cb'),
                $('#form_rendering_paypal'),
                $('#form_rendering_binance'),
                'binance'
            )
            $('#div-form').removeClass('card-paypal card-cb')
            $('#div-form').addClass('card-binance');
            let $binanceNextButton = $('#binance-div—content');
            $binanceNextButton.show()

            $("#form-participate").validate({
                errorClass: 'is-invalid',
                validClass:'is-valid',
                rules: {
                    "participant[email]":{
                        "required": true
                    },
                    "participant[nom]": {
                        "email": true,
                    },
                    "participant[telegram]": {
                        "required": true
                    },
                    "participant[ticketNumber]": {
                        "required": true,
                        "min": 10
                    },
                },
                submitHandler: function(form) {
                    $('#next-button-binance').hide();
                    let $save = $('#button-save-binance')
                    $save.show();
                    form.submit()
                    $('#form_first_step').hide();
                    $('#file_import_binance').show();
                }
            })
            $binanceNextButton.click(function (e) {
                if (!$('#form-participate').valid(e)) {
                    console.log(e)
                    return;
                } else {
                    $('#next-button-binance').hide();
                    let $save = $('#button-save-binance')
                    $save.show();
                    $('#form_first_step').hide();
                    $('#file_import_binance').show();
                }

            });
       }
    });

    function showHideMethod(
        response,
        iconCb,
        iconPaypal,
        iconBinance,
        formCb,
        formPaypal,
        formBinance,
        type
    ) {
        switch (type) {
            case 'binance':
                // CB Component
                iconCb.hide();
                formCb.hide().html('');

                // Paypal Component
                iconPaypal.hide();
                formPaypal.hide().html('');

                // Binance
                iconBinance.toggle();
                formBinance.toggle().html(response.content);
                $('#mini-ticket-span').show()
                formBinance.scroll();
                $('html, body').animate({
                    scrollTop: formBinance.offset().top
                }, 100);
                break;
            case 'paypal':
                // CB Component
                iconCb.hide();
                formCb.hide().html('');

                // Binance Component
                iconBinance.hide();
                formBinance.hide().html('');

                // Paypal
                iconPaypal.toggle();
                formPaypal.toggle().html(response.content);
                $('html, body').animate({
                    scrollTop: formPaypal.offset().top
                }, 100);
                break;
            case 'cb':
                // Paypal Component
                iconPaypal.hide();
                formPaypal.hide().html('');

                // Binance Component
                iconBinance.hide();
                formBinance.hide().html('');

                // CB
                iconCb.toggle();
                formCb.toggle().html(response.content);
                $('html, body').animate({
                    scrollTop: formCb.offset().top
                }, 100);
                break;
        }
    }
});
