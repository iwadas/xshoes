<template>

    <div class="relative">
        <div v-if="error" class="absolute top-0 left-1/2 -translate-x-1/2 text-red-500 font-bold text-2xl">
            <i class="fa-solid fa-triangle-exclamation"></i>
            You need to select payment!
        </div>
        <h1 class="font-semibold text-2xl mb-8">
            <i class="fa-solid fa-credit-card text-xl mr-1 text-purple-500"></i>
            Select payment option
        </h1>
        <div class="flex gap-x-4 pb-20">
           <button class="w-1/2 h-64 rounded-lg overflow-hidden border-[3px] duration-100" style="box-shadow: 0 0 10px lightgray" :class="selectedPayment == 'paypal' ? 'border-purple-500' : null" @click="selectPayment('paypal')">
                <img :src="paypalImg" alt="PayPal" class="w-full h-full object-contain">
           </button>
           <button class="w-1/2 h-64 rounded-lg overflow-hidden border-[3px] duration-100" style="box-shadow: 0 0 10px lightgray" :class="selectedPayment == 'stripe' ? 'border-purple-500' : null" @click="selectPayment('stripe')">
                <img :src="stripeImg" alt="PayPal" class="w-full h-full object-contain bg white">
           </button>
        </div>
    </div>

</template>

<script setup>

    const props  = defineProps({
        selectedPayment: String,
        error: Boolean
    })

    const emit = defineEmits(['select-payment'])

    const selectPayment = (payment) => {
        emit('select-payment', payment)
    }

    const paypalImg = '/storage/payment/paypal.webp'
    const stripeImg = '/storage/payment/stripe.png'

</script>