<template>
    <div class="mt-20">
        <h1 class="mb-10 text-5xl font-bold flex items-center justify-center">
            <i class="button-special-text mr-2 fa-solid fa-shopping-bag text-4xl"></i>
            Order #{{ order.id }}
            <br/>
        </h1>
        <div class="grid grid-cols-3 mx-20 gap-10">
            <div class="flex flex-col rounded-lg pb-1 col-span-2 h-fit gap-y-4">
                <div class="flex justify-between py-3 px-8 rounded-lg" style="box-shadow: 0 0 10px lightgray">
                    <div class="flex flex-col gap-y-1 text-lg">
                        <p>status: <span class="font-semibold text-purple-500">Delivered</span></p>
                        <p>purchased: <span class="font-semibold">{{ created_at }}</span></p>
                        <p>total: <span class="font-semibold">{{ order.payment.price }}$</span></p>
                    </div>
                </div>
                <div class="flex flex-col gap-y-2 px-8 h-fit rounded-lg" style="box-shadow: 0 0 10px lightgray">
                    <order-item v-for="cartItem, index in order.cart.cart_items" :cart-item="cartItem" :class="index == order.cart.cart_items.length - 1 ? null : 'border-b'"/>
                </div>
            </div>

            <div class="flex flex-col rounded-lg py-2 px-10 h-fit gap-y-4"  style="box-shadow: 0 0 10px lightgray">
                <div>
                    <h2 class="font-semibold">Shipping</h2>
                    <div class="flex justify-between items-center">
                        <div class="h-20 w-32">
                            <img :src="order.shipping.src" class="w-full h-full object-cover" alt="">
                        </div>
                        <div>
                            price: <span class="font-bold">{{ order.shipping.price }}$</span>
                        </div>
                    </div>
                </div>
                <div v-if="order.cart.promo_code_id">
                    <h2 class="font-semibold">Promo Code</h2>
                    <div class="flex justify-between items-center py-2 px-4">
                        <p class="text-purple-500 font-semibold">
                            {{ order.cart.promo_code.name }}
                        </p>
                        <p>
                            -
                            <span class="font-bold">
                                {{ order.payment.discount }}$
                            </span>
                        </p>
                    </div>
                </div>
                <div>
                    <h2 class="font-semibold">Address</h2>
                    <div class="py-2 px-4 rounded-lg flex flex-col w-full">
                        <div>
                            {{ order.address.name }} {{ order.address.surname }}
                        </div>
                        <div>
                            {{ order.address.address }}
                        </div>
                        <div>
                            {{ order.address.city }} {{ order.address.post_code }}
                        </div>
                        <div>
                            {{ order.address.phone_number }}
                        </div>
                    </div>
                </div>
                <div>
                    <h2 class="font-semibold">Payment</h2>
                    <div class="h-20 w-32 rounded-lg overflow-hidden">
                        <img :src="paymentImage[order.payment.by]" alt="PayPal" class="w-full h-full object-contain bg white">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>

    import OrderItem from "@/Components/Order/OrderItem.vue"
    import { computed } from 'vue'
    import { Link } from '@inertiajs/vue3'

    const props = defineProps({
        order: Object
    })

    const paymentImage = {
        stripe : '/storage/payment/stripe.png',
        paypal:'/storage/payment/paypal.webp',
    }

    const created_at = computed(
        ()=>new Date(props.order.created_at).toLocaleDateString()
    )

</script>