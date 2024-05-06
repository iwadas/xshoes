<template>

    <div class="mt-20 px-10 grid grid-cols-3 container mx-auto gap-8">
        <div class="col-span-2 flex flex-col gap-y-8 pr-8 border-r">
            <checkout-addresses :addresses="addresses" :error="errorAddress" :chosen-address-id="chosenAddressId" @address-chosen="chooseAddress"/>
            <checkout-shippings :shippings="shippings" :error="errorShipping" :selected-shipping-id="selectedShipping ? selectedShipping.id : null" @shipping-selected="selectShipping"/>
            <checkout-payments :selected-payment="selectedPayment" :error="errorPayment" @select-payment="selectPayment"/>
        </div>
        <checkout-summary :cart-items="cartItems" :shipping="selectedShipping" :promo-code="promoCode" @checkout="checkout" :error="checkoutError"/>
    </div>
</template>

<script setup>

    import CheckoutAddresses from '@/Components/Checkout/CheckoutAddresses.vue'
    import CheckoutShippings from '@/Components/Checkout/CheckoutShippings.vue'
    import CheckoutPayments from '@/Components/Checkout/CheckoutPayments.vue'
    import CheckoutSummary from '@/Components/Checkout/CheckoutSummary.vue'
    import { computed, ref } from 'vue'
    import { usePage } from '@inertiajs/vue3'
    import axios from 'axios' 

    const page = usePage()

    const cartItems = computed(
        ()=>page.props.cart_items
    )

    const props = defineProps({
        promoCode: Object,
        addresses: Array,
        shippings: Array,
    })

    const selectedShipping = ref(null);
    const chosenAddressId = ref(null);
    const selectedPayment = ref(null);
    const errorShipping = ref(false);
    const errorAddress = ref(false);
    const errorPayment = ref(false);
    const checkoutError = ref(null);

    if(props.addresses){
        let chosenAddress = props.addresses.filter(address => address.is_main)[0]
        if(chosenAddress){
            chosenAddressId.value = chosenAddress.id
        }
    }

    const selectShipping = (val) => {
        selectedShipping.value = val;
        errorShipping.value = false;
    }

    const chooseAddress = (val) => {
        chosenAddressId.value = val;
        errorAddress.value = false;
    }

    const selectPayment = (val) => {
        selectedPayment.value = val
    } 

    const checkout = () => {
        let error = false;
        if(!cartItems.value.length || cartItems.value.length == 0){
            return alert('Something went wrong! Refresh page!');
        }
        if(!chosenAddressId.value){
            errorAddress.value = true;
            error = true;
        }
        if(!(selectedShipping.value ? selectedShipping.value.id : false)){
            errorShipping.value = true;
            error = true;
        }
        if(!(selectedPayment.value)){
            errorPayment.value = true;
            error = true;
        }

        if(error){
            return
        }

        if(selectedPayment.value == 'paypal'){
            axios.post(route('payment.checkout.paypal'), {shipping_id: selectedShipping.value.id, address_id: chosenAddressId.value})
                .then(e=>{
                    let response = e.data
                    if(response.url){
                        window.open(response.url);
                    } else if(response.error_url) {
                        window.location.href = response.error_url;
                    }
                })
                .catch(e=>{
                    console.error(e);
                })
        } else if(selectedPayment.value == 'stripe'){
            axios.post(route('payment.checkout.stripe'), {shipping_id: selectedShipping.value.id, address_id: chosenAddressId.value})
                .then(e=>{
                    let url = e.data.url
                    if(url){
                        window.open(url);
                    } else {
                        let error_url = e.data.error_url;
                        if(error_url){
                            window.location.href = error_url;
                        }
                    }
                })
                .catch(e=>{
                    console.error(e);
                    // checkoutError.value = e.response.data.error
                })
        }

    }




</script>