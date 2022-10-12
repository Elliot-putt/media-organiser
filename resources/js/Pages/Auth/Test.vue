<template>
    <div class="card shadow row justify-content-center">
        <div class="col-2 p-4 mx-auto">
            <div id="card"></div>
            <label class="fs-3 text-muted my-1">Card Number</label>
            <div id="card-number"></div>
            <label class="fs-3 text-muted my-1">Card Expiry</label>
            <div id="card-expiry"></div>
            <label class="fs-3 text-muted my-1">Card CVC</label>
            <div id="card-cvc"></div>
            <div id="card-error"></div>
            <button id="custom-button" class="btn btn-success mt-4" @click="createToken">Generate Token</button>
        </div>
    </div>

</template>
<script setup>
import {ref, computed, onMounted, onBeforeUnmount} from "vue";
import {usePage} from "@inertiajs/inertia-vue3";

let stripe = Stripe(`pk_test_51LifM0Lf3BQtS60274MGbMwTIpVFGbQOtdLbTBVfKgPHvZXJvYDICQ3Ud3pA3BApMp4yABaT4TeAODtXuJwzy9BK00cpsDp3hX`),
    elements = stripe.elements(),
    card = undefined;
let page = usePage().props.value;
let token = ref(null);
let cardNumber = ref(null);
let cardExpiry = ref(null);
let cardCvc = ref(null);

const stripeElements = computed(() => {
    return stripe.elements();
});


onMounted(() => {
    // Style Object documentation here: https://stripe.com/docs/js/appendix/style
    const style = {
        base: {
            iconColor: '#c4f0ff',
            color: '#0000000',
            fontWeight: '500',
            fontFamily: 'Roboto, Open Sans, Segoe UI, sans-serif',
            fontSize: '20px',
            fontSmoothing: 'antialiased',
            ':-webkit-autofill': {
                color: '#fce883',
            },
            '::placeholder': {
                color: '#15195A',
            },
        },
        invalid: {
            iconColor: '#FFC7EE',
            color: '#FFC7EE',
        },
    };
    cardNumber.value = stripeElements.value.create('cardNumber', {style, showIcon: true, placeholder: 'Card Number'});
    cardNumber.value.mount('#card-number');
    cardExpiry.value = stripeElements.value.create('cardExpiry', {style});
    cardExpiry.value.mount('#card-expiry');
    cardCvc.value = stripeElements.value.create('cardCvc', {style});
    cardCvc.value.mount('#card-cvc');
})
onBeforeUnmount(() => {
    //possibly need .value
    cardNumber.value.destroy();
    cardExpiry.value.destroy();
    cardCvc.value.destroy();
})
let createToken = async () => {
    const {token, error} = await stripe.createToken(cardNumber.value);
    if (error) {
        // handle error here
        document.getElementById('card-error').innerHTML = error.message;
        return;
    }
    document.getElementById('card-error').innerHTML = 'Success';
    console.log(token);
    // handle the token
    // send it to your server
}
</script>

<!--<script>-->
<!--this script tag uses options api-->
<!--let stripe = Stripe(`pk_test_51LifM0Lf3BQtS60274MGbMwTIpVFGbQOtdLbTBVfKgPHvZXJvYDICQ3Ud3pA3BApMp4yABaT4TeAODtXuJwzy9BK00cpsDp3hX`),-->
<!--    elements = stripe.elements(),-->
<!--    card = undefined;-->

<!--export default {-->
<!--    data() {-->
<!--        return {-->
<!--            token: null,-->
<!--            cardNumber: null,-->
<!--            cardExpiry: null,-->
<!--            cardCvc: null,-->
<!--        };-->
<!--    },-->
<!--    computed: {-->
<!--        stripeElements() {-->
<!--            return stripe.elements();-->
<!--        },-->
<!--    },-->
<!--    mounted() {-->
<!--        // Style Object documentation here: https://stripe.com/docs/js/appendix/style-->
<!--        const style = {-->
<!--            base: {-->
<!--                color: 'black',-->
<!--                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',-->
<!--                fontSmoothing: 'antialiased',-->
<!--                fontSize: '14px',-->
<!--                '::placeholder': {-->
<!--                    color: '#aab7c4',-->
<!--                },-->
<!--            },-->
<!--            invalid: {-->
<!--                color: '#fa755a',-->
<!--                iconColor: '#fa755a',-->
<!--            },-->
<!--        };-->
<!--        this.cardNumber = this.stripeElements.create('cardNumber', {style});-->
<!--        this.cardNumber.mount('#card-number');-->
<!--        this.cardExpiry = this.stripeElements.create('cardExpiry', {style});-->
<!--        this.cardExpiry.mount('#card-expiry');-->
<!--        this.cardCvc = this.stripeElements.create('cardCvc', {style});-->
<!--        this.cardCvc.mount('#card-cvc');-->
<!--    },-->
<!--    beforeDestroy() {-->
<!--        this.cardNumber.destroy();-->
<!--        this.cardExpiry.destroy();-->
<!--        this.cardCvc.destroy();-->
<!--    },-->
<!--    methods: {-->
<!--        async createToken() {-->
<!--            const {token, error} = await stripe.createToken(this.cardNumber);-->
<!--            if (error) {-->
<!--                // handle error here-->
<!--                document.getElementById('card-error').innerHTML = error.message;-->
<!--                return;-->
<!--            }-->
<!--            document.getElementById('card-error').innerHTML = 'Success';-->
<!--            console.log(token);-->
<!--            // handle the token-->
<!--            // send it to your server-->
<!--        },-->
<!--    }-->
<!--};-->
<!--</script>-->

<style scoped>


#card-error {
    color: red;
}
</style>
