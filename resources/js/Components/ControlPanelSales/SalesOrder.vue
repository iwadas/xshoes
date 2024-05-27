<template>
    
    <div class="flex flex-col rounded-lg pb-1 text-sm py-5 px-8" style="box-shadow: 0 0 10px lightgray">
        <div class="flex justify-between mb-5">
            <Link :href="route('order.show', {order: order.id})" class="text-xl font-semibold hover:underline">
                Order <span class="font-bold">#{{ order.id }}</span>
            </Link>
            <p>purchased: <span class="font-semibold">{{ created_at }}</span></p>
        </div>
        <div class="flex flex-col gap-y-2">
            <cart-item v-for="cartItem, index in order.cart.cart_items" :cart-item="cartItem" :class="index == order.cart.cart_items.length - 1 ? null : 'border-b'"/>
        </div>
        <div class="py-4 text-xl ml-auto font-semibold">
            Total: <span class="font-bold">{{ order.payment.price }}$</span>
        </div>
    </div>

</template>

<script setup>

    import CartItem from "@/Components/Order/ControlPanelCartItem.vue"
    import { computed } from 'vue'
    import { Link } from '@inertiajs/vue3'

    const props = defineProps({
        order: Object,
    })

    const created_at = computed(
        ()=>new Date(props.order.created_at).toLocaleDateString()
    )

</script>