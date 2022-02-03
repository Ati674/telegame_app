<template>
    <div class="modal" tabindex="-1" role="dialog" id="modal_checkout_payment">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Effectuer le paiement</h5>
                    <a type="button" data-dismiss="modal" aria-label="Close" @click="closeModal">
                        <span><i class="fas fa-times"></i></span>
                    </a>
                </div>
                <div class="modal-body">
                    <div ref="paypal"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeModal">Close</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import {TelegameCommon} from "../../js/AjaxRequest";
import { loadScript } from "@paypal/paypal-js";

export default {
    name: "CheckoutPayment",
    props: {
        typePayment: String,
        ticketNumber: Number
    },
    data: function() {
        return {
            loaded: false,
            paidFor: false,
            product: {
                price: this.ticketNumber,
                description: "Le pack crypto du moment",
                img: "./assets/lamp.jpg"
            },
        };
    },
    mounted: function() {
        const script = document.createElement("script");
        //script.src =
          //  "https://www.paypal.com/sdk/js?client-id=Ab_pFLt376S1ti82vgTI2tLsykgqerREKLRQkzLJC4I1Fp2qfUnl2aNV8VlWwbZYA1h-IszdIlZV7juL&currency=EUR";
        // script.addEventListener("load", this.setLoaded);
        loadScript({
            "client-id": 'Ab_pFLt376S1ti82vgTI2tLsykgqerREKLRQkzLJC4I1Fp2qfUnl2aNV8VlWwbZYA1h-IszdIlZV7juL',
            "currency" : "EUR",
            "vault" : true,
            "intent" : "subscription"
        }).then((paypal) => {
            this.setLoaded()
            // start to use the PayPal JS SDK script
        })
        //document.body.appendChild(script);
        $('#modal_checkout_payment').show();
    },
    methods: {
        setLoaded: function() {
            let fundingSource;
            let ticketNumber = this.ticketNumber;
            let typePayment = this.typePayment;
            switch (typePayment) {
                case "paypal":
                    fundingSource = paypal.FUNDING.PAYPAL
                    break;
                case "cb":
                    fundingSource = paypal.FUNDING.CARD
                    break;
            }
            this.loaded = true;
            window.paypal
                .Buttons({
                fundingSource: fundingSource,
                style: {
                    layout: 'vertical',
                    shape: 'pill',
                    height: 50,
                    width: 1000
                },
                createSubscription: function(data, actions) {
                    return actions.subscription.create({
                        plan_id: 'P-6R4639460B881225WMH4W3VI',
                        quantity : ticketNumber
                    });
                },
                /*createOrder: (data, actions) => {
                    console.log(actions)
                    return actions.order.create({
                    intent: "subscription",
                    purchase_units: [
                        {
                            description: this.product.description,
                            amount: {
                                currency_code: "EUR",
                                value: this.product.price
                            }
                        }
                    ]});
                },*/
                onApprove: async (data, actions) => {
                    const order = await actions.order.capture();
                    let $form = $('#form-participate');
                    let $url = $form.data('url');
                    this.paidFor = true;
                    return actions.order.capture().then(function(details) {
                        alert('Transaction completed by ' + details.payer.name.given_name);
                        TelegameCommon.Ajax('POST', $url, $form.serialize(), 'json')
                        this.closeModal();
                    })
                },
                onError: err => {
                    console.log(err);
                }}).render(this.$refs.paypal);
        },
        closeModal() {
            $('#modal_checkout_payment').hide();
        }
    }
}
</script>

<style scoped>

</style>
