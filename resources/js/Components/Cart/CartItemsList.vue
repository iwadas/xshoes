<template>

    <div class="pr-8 border-r " style="min-height: 60vh">
        <h1 class="mb-5 text-3xl font-bold flex items-center justify-center">
            <i class="button-special-text mr-2 fa-solid fa-cart-shopping text-2xl"></i>
            Cart
            <br/>
        </h1>
        <div class="flex flex-col gap-y-2" v-if="cartItems ? cartItems.length : false">
            <cart-item v-for="cartItem in cartItems" :cart-item="cartItem" :key="cartItem.id"/>
        </div>
        <div v-else class="text-center my-20 text-2xl font-semibold">
            Your cart is empty. Find products <Link :href="route('store.index')" class="text-purple-500 hover:underline opacity-100">here</Link>!
        </div>
    </div>


</template>

<script setup>

    import CartItem from '@/Components/Cart/CartItem.vue'
    import { Link } from '@inertiajs/vue3'

    const props = defineProps({
        cartItems: Array
    })



</script>