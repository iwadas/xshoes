<template>


    <div>
        <h1 class="font-semibold text-2xl mb-8">
            <i class="fa-solid fa-truck text-xl mr-1 text-purple-500"></i>
            Chose delivery method
        </h1>
        <div class="flex flex-col gap-y-2">
            <button 
                v-for="shipping in shippings" 
                :key="shipping.id" 
                @click="shippingSelected(shipping)" 
                class="flex gap-x-2 rounded-lg overflow-hidden items-center duration-100 border-[3px]" 
                style="box-shadow: 0 0 10px lightgray"
                :class="selectedShippingId == shipping.id ? ' border-purple-500' : ' border-transparent'">

                <div class="h-32 w-40">
                    <img :src="shipping.src" class="w-full h-full object-cover" alt="">
                </div>
                <div class="flex flex-col justify gap-y-4 ml-4 font-semibold">
                    <p class="text-2xl text-start">
                        {{ shipping.name }}
                    </p>
                    <p>
                        <span class="font-normal">Time: < </span>{{ shipping.delivery_time }}<span class="font-normal"> business days</span>
                    </p>
                </div>
                <div class="ml-auto mr-8 font-semibold text-2xl">
                    {{ shipping.price }}$
                </div>
            </button>
        </div>
    </div>


</template>

<script setup>

    const props = defineProps({
        shippings: Array,
        selectedShippingId: Number
    })

    const emit = defineEmits(['shipping-selected'])

    const shippingSelected = (shippingId) => {
        emit('shipping-selected', shippingId);
    }

</script>