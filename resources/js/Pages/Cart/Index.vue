<template>

    <div class="mt-20 px-10 grid grid-cols-3 container mx-auto gap-8">
        <cart-items-list :cart-items="cartItems" class="col-span-2"/>
        <cart-summary :cart-items="cartItems" :promo-code="promoCode"/>

    </div>
</template>

<script setup>

    import CartItemsList from '@/Components/Cart/CartItemsList.vue'
    import CartSummary from '@/Components/Cart/CartSummary.vue'
    import { computed } from 'vue'
    import { usePage } from '@inertiajs/vue3'

    const page = usePage()
    const cartItems = computed(
        ()=>page.props.cart_items
    )

    const props = defineProps({
        promoCode: Object
    })

</script>