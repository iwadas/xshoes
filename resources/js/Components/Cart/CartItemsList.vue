<template>

    <div>
        <h1 class="mb-5 text-3xl font-bold flex items-center justify-center">
            <i class="button-special-text mr-2 fa-solid fa-cart-shopping text-2xl"></i>
            Cart
            <br/>
        </h1>
        <div class="flex flex-col gap-y-2">
            <cart-item v-for="cartItem in cartItems" :cart-item="cartItem" :key="cartItem.id"/>
        </div>
    </div>


</template>

<script setup>

    import CartItem from '@/Components/Cart/CartItem.vue'

    const props = defineProps({
        cartItems: Array
    })

</script>