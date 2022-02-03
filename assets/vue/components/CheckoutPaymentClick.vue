<template>
    <div>
        <button class="ab-button-next-form" id="next-button" @click="toggleComponent">Suivant</button>
        <div
            v-if="buttonClicked">
            <CheckoutPayment :type-payment="this.typePayment" :ticket-number="this.ticketNumber"/>
        </div>
    </div>
</template>

<script>
import CheckoutPayment from "./CheckoutPayment";
export default {
    name: "CheckoutPaymentClick",
    components: {
        CheckoutPayment
    },
    props: {
        typePayment: {
            type: String
        },

    },
    data: () => {
        return {
            buttonClicked: false,
            ticketNumber: null
        }
    },
    methods: {
        toggleComponent(e) {
            jQuery.extend(jQuery.validator.messages, {
                required: "Ce champs est requis !",
                remote: "votre message",
                email: "Entrez un e-mail valide !",
                url: "votre message",
                date: "votre message",
                dateISO: "votre message",
                number: "votre message",
                digits: "votre message",
                creditcard: "votre message",
                equalTo: "votre message",
                accept: "votre message",
                maxlength: jQuery.validator.format("votre message {0} caractéres."),
                minlength: jQuery.validator.format("votre message {0} caractéres."),
                rangelength: jQuery.validator.format("votre message  entre {0} et {1} caractéres."),
                range: jQuery.validator.format("votre message  entre {0} et {1}."),
                max: jQuery.validator.format("votre message  inférieur ou égal à {0}."),
                min: jQuery.validator.format("Ticket supérieur ou égal à {0}.")
            });
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
                        "min": 1
                    },
                },
                submitHandler: function(form) {
                    console.log(form);
                }
            })
            e.preventDefault();
            let inputTicketNumber = $('#participant_ticketNumber').val();
            if (!$('#form-participate').valid()) {
               return;
            }
            e.preventDefault();
            this.ticketNumber = Number(inputTicketNumber);
            this.buttonClicked = !this.buttonClicked;
        }
    }
}
</script>

<style scoped>

</style>
