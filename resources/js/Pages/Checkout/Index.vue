<template>

    <div class="mt-20 px-10 grid grid-cols-3 container mx-auto gap-8">
        <div class="col-span-2 flex flex-col gap-y-8">
            <checkout-addresses :addresses="addresses" :chosen-address-id="chosenAddressId" @address-chosen="chooseAddress"/>
            <checkout-shippings :shippings="shippings" :selected-shipping-id="selectedShipping ? selectedShipping.id : null" @shipping-selected="selectShipping"/>
            <checkout-payments :shippings="shippings" :selected-shipping-id="selectedShipping ? selectedShipping.id : null" @shipping-selected="selectShipping"/>
        </div>
        <checkout-summary :cart-items="cartItems" :promo-code="promoCode" :shipping="selectedShipping"/>
      
    </div>
</template>

<script setup>

    import CheckoutAddresses from '@/Components/Checkout/CheckoutAddresses.vue'
    import CheckoutShippings from '@/Components/Checkout/CheckoutShippings.vue'
    import CheckoutPayments from '@/Components/Checkout/CheckoutPayments.vue'
    import CheckoutSummary from '@/Components/Checkout/CheckoutSummary.vue'
    import { computed, ref } from 'vue'
    import { usePage } from '@inertiajs/vue3'

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
    const chosenAddressId = ref(props.addresses.filter(address => address.is_main)[0].id ?? null);

    const selectShipping = (val) => {
        selectedShipping.value = val;
    }

    const chooseAddress = (val) => {
        chosenAddressId.value = val;
    }

</script>