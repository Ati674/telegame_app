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
            e.preventDefault()
            let inputTicketNumber = $('#participant_ticketNumber').val()
            this.ticketNumber = Number(inputTicketNumber);
            if (inputTicketNumber === '' || inputTicketNumber < 1) {
                alert('Veuillez choisir un nombre de ticket')
            } else {
                this.buttonClicked = !this.buttonClicked;
            }
        }
    }
}
</script>

<style scoped>

</style>
