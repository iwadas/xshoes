<template>
    
    <div class="flex flex-col rounded-lg pb-1 text-sm" style="box-shadow: 0 0 10px lightgray">
        <div class="flex justify-between py-5 px-8 text-xl">
            <p>purchased: <span class="font-semibold">{{ created_at }}</span></p>
            <p>total: <span class="font-semibold">{{ order.payment.price }}$</span></p>
        </div>
        <div class="flex flex-col gap-y-2 px-8">
            <cart-item v-for="cartItem, index in order.cart.cart_items" :cart-item="cartItem" :class="index == order.cart.cart_items.length - 1 ? null : 'border-b'"/>
        </div>
    </div>

</template>

<script setup>

    import CartItem from "@/Components/Order/ControlPanelCartItem.vue"
    import { computed } from 'vue'

    const props = defineProps({
        order: Object,
    })

    const created_at = computed(
        ()=>new Date(props.order.created_at).toLocaleDateString()
    )

</script>