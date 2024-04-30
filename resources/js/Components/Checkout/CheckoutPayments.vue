<template>


    <div>
        <h1 class="font-semibold text-2xl mb-8">
            <i class="fa-solid fa-credit-card text-xl mr-1 text-purple-500"></i>
            Select payment option
        </h1>
        <div class="flex flex-col gap-y-2 pb-20">
           <div class="w-1/2 h-64">
                <img :src="paypalImg" alt="PayPal" class="w-full h-full object-contain border">
           </div>
        </div>
    </div>


</template>

<script setup>

    const paypalImg = '/storage/payment/paypal.webp'

</script>