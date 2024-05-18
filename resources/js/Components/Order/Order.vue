<template>
    
    <div class="flex flex-col rounded-lg pb-1"  style="box-shadow: 0 0 10px lightgray">
        <div class="flex justify-between py-3 border-b px-8 shadow-lg rounded-t-lg" :class="{'bg-red-200' : uncompleted}">
            <div class="flex flex-col gap-y-1 text-lg">
                <p>status: <span class="font-semibold text-purple-500">{{ capitalizeFirstLetter(order.tracking.status) }}</span></p>
                <p>purchased: <span class="font-semibold">{{ created_at }}</span></p>
                <p>total: <span class="font-semibold">{{ order.payment.price }}$</span></p>
            </div>
            <div v-if="uncompleted">
                <Link 
                    :href="route('payment.complete', {order: order.id})"
                    method="POST"
                    as="button"
                    class="button-primary font-semibold h-fit w-64 mb-2 flex justify-center"
                >
                    Complete payment
                </Link>
                <Link
                    preserve-scroll
                    method="DELETE"
                    as="button" 
                    :href="route('order.destroy', {order: order.id})" 
                    class="button-primary font-semibold h-fit w-64 mb-2 flex justify-center"
                >
                    Cancel order
                </Link>
            </div>
            <div v-else>
                <Link :href="route('order.show', {order: order.id})" class="button-primary font-semibold h-fit mb-2 flex justify-center w-64">Details</Link>
                <a v-if="order.tracking.url && order.tracking.status != 'completed'" :href="order.tracking.url" target="_blank" class="button-primary font-semibold h-fit mb-2 flex justify-center w-64">Tracking</a>
            </div>
        </div>
        <div class="flex flex-col gap-y-2 px-8 ">
            <order-item v-for="cartItem, index in order.cart.cart_items" :cart-item="cartItem" :class="index == order.cart.cart_items.length - 1 ? null : 'border-b'"/>
        </div>
    </div>

</template>

<script setup>

    import OrderItem from "@/Components/Order/OrderItem.vue"
    import { computed } from 'vue'
    import { Link } from '@inertiajs/vue3'

    const props = defineProps({
        order: Object,
        uncompleted: Boolean
    })

    function capitalizeFirstLetter(string) {
        if (!string) return string;
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    const created_at = computed(
        ()=>new Date(props.order.created_at).toLocaleDateString()
    )

</script>