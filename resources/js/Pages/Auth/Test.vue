<template>
    <!--    <div class="row justify-content-center col-4">-->
    <!--        <div ref="card"></div>-->
    <!--        <button @click="createToken">Submit</button>-->
    <!--        <p class="text-danger" id="card-error">-->

    <!--        </p>-->
    <!--    </div>-->
    <div>
        <label>Card Number</label>
        <div id="card-number"></div>
        <label>Card Expiry</label>
        <div id="card-expiry"></div>
        <label>Card CVC</label>
        <div id="card-cvc"></div>
        <div id="card-error"></div>
        <button id="custom-button" @click="createToken">Generate Token</button>
    </div>
</template>
<script>

let stripe = Stripe(`pk_test_51LifM0Lf3BQtS60274MGbMwTIpVFGbQOtdLbTBVfKgPHvZXJvYDICQ3Ud3pA3BApMp4yABaT4TeAODtXuJwzy9BK00cpsDp3hX`),
    elements = stripe.elements(),
    card = undefined;
export default {
    data() {
        return {
            token: null,
            cardNumber: null,
            cardExpiry: null,
            cardCvc: null,
        };
    },
    computed: {
        stripeElements() {
            return stripe.elements();
        },
    },
    mounted() {
        // Style Object documentation here: https://stripe.com/docs/js/appendix/style
        const style = {
            base: {
                color: 'black',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '14px',
                '::placeholder': {
                    color: '#aab7c4',
                },
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a',
            },
        };
        this.cardNumber = this.stripeElements.create('cardNumber', {style});
        this.cardNumber.mount('#card-number');
        this.cardExpiry = this.stripeElements.create('cardExpiry', {style});
        this.cardExpiry.mount('#card-expiry');
        this.cardCvc = this.stripeElements.create('cardCvc', {style});
        this.cardCvc.mount('#card-cvc');
    },
    beforeDestroy() {
        this.cardNumber.destroy();
        this.cardExpiry.destroy();
        this.cardCvc.destroy();
    },
    methods: {
        async createToken() {
            const {token, error} = await stripe.createToken(this.cardNumber);
            if (error) {
                // handle error here
                document.getElementById('card-error').innerHTML = error.message;
                return;
            }
            document.getElementById('card-error').innerHTML = 'Success';
            console.log(token);
            // handle the token
            // send it to your server
        },
    }
};
</script>

<style scoped>
#custom-button {
    height: 30px;
    outline: 1px solid grey;
    background-color: green;
    padding: 5px;
    color: white;
}

#card-error {
    color: red;
}
</style>
<!--<script>-->
<!--let stripe = Stripe(`pk_test_51LifM0Lf3BQtS60274MGbMwTIpVFGbQOtdLbTBVfKgPHvZXJvYDICQ3Ud3pA3BApMp4yABaT4TeAODtXuJwzy9BK00cpsDp3hX`),-->
<!--    elements = stripe.elements(),-->
<!--    card = undefined;-->

<!--export default {-->
<!--    mounted: function () {-->
<!--        card = elements.create('card');-->
<!--        card.mount(this.$refs.card);-->
<!--    },-->
<!--    methods: {-->
<!--        async createToken() {-->
<!--            const {token, error} = await stripe.createToken(card);-->
<!--            if (error) {-->
<!--                // handle error here-->
<!--                document.getElementById('card-error').innerHTML = error.message;-->
<!--                return;-->
<!--            }-->
<!--            document.getElementById('card-error').innerHTML = 'Success';-->
<!--            console.log(token);-->
<!--            // handle the token-->
<!--            // send it to your server with form-->
<!--        },-->
<!--    },-->
<!--};-->

<!--</script>-->
