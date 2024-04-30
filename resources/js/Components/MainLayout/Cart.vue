<template>
    <div>
        <div class="absolute duration-200 right-10 bg-white shadow-lg rounded-lg flex flex-col max-h-[600px]" style="border: solid 3px #a855f7" :class="showCart ? 'top-28' : '-top-[1000px]' ">
           <div v-if="cartItems ? cartItems.length : false" class="flex justify-between mt-4 mx-4">
               <button @click="redirectCart()" class="button-primary w-fit font-semibold">
                   <i class="fa-solid fa-cart-shopping text-xs"></i>
                   Show cart
               </button>
               <button @click="redirectPay()" class="button-primary w-fit font-semibold">
                   <i class="fa-solid fa-money-check-dollar text-xs"></i>
                   Pay
               </button>
           </div>
            <div v-if="cartItems ? cartItems.length : false" class="h-fit overflow-y-auto hide-scrollbar">
                <cart-item v-for="cartItem in cartItems" :key="cartItem.id" :cart-item="cartItem" @hide-cart="hideCart"/>
            </div>
            <div v-else class="text-center py-4 opacity-50 px-10">
                Your cart is empty 😓
            </div>
        </div>
        <button
            @click="toggleShowCart"
        >
            <div class="button-special-back">
                Cart
                <div class="button-special-front">
                    <div class="button-special-text-2 relative">
                        <div v-if="cartItems ? cartItems.length : false" class="absolute -top-1 -right-3 text-[10px] h-4 w-4 grid place-items-center rounded-full bg-purple-500 text-white">{{ cartItems.length }}</div>
                        <i class="fa-solid fa-shopping-cart text-sm text-purple-500"></i>
                        Cart
                    </div>
                </div>
            </div>
        </button>
    </div>
</template>

<script setup>

    import CartItem from '@/Components/MainLayout/CartItem.vue'
    import { router } from '@inertiajs/vue3'

    const emit = defineEmits(['toggle-show-cart', 'hide-cart'])

    const props = defineProps({
        cartItems: Array,
        showCart: Boolean
    })

    const toggleShowCart = () => {
        emit('toggle-show-cart')
    }
    
    const hideCart = () => {
        emit('hide-cart')
    }

    const redirectCart = () => {
        hideCart()
        router.get(route('cart.index'));
    }
    
    const redirectPay = () => {
        hideCart()
        router.get(route('cart.index'));
    }

</script>

