<template>

    <div>
        <h3 class="font-semibold mb-1 text-lg duration-100" :class="noSizeSelectedError ? 'text-red-500' : 'text-black'">
            <i v-if="noSizeSelectedError" class="fa-solid fa-triangle-exclamation"></i>
            Select size
        </h3>
        <div class="grid grid-cols-4 gap-2">
            <button
                v-for="size in sizes" 
                @click="changeSelectedSize(size.id)" 
                :key="size.id"
                :disabled="!size.pivot.amount"
                :class="size.pivot.amount ? 'hover:scale-105' : 'opacity-25 cursor-not-allowed'"
                class="font-bold py-3 min-w-10 b shadow-lg order-black text-white text-center rounded-lg duration-100 bg-black relative overflow-hidden"
            >
                <div 
                    class="absolute top-1/2 -translate-y-1/2 h-40 w-40 bg-purple-500 duration-500 rounded-full"
                    :class="selectedSize == size.id ? '-left-10' : 'left-40'" 
                ></div>
                <div 
                    class="absolute top-1/2 -translate-y-1/2 h-40 w-40 bg-purple-500 duration-500 rounded-full"
                    :class="selectedSize == size.id ? '-right-10' : 'right-40'" 
                ></div>
                <p class="relative">
                    {{ size.name }}
                </p>
            </button>
        </div>
    </div>


</template>

<script setup>

    const emit = defineEmits(['selectedSize'])

    const props = defineProps({
        sizes: Array,
        selectedSize: Number,
        noSizeSelectedError: Boolean
    })

    const changeSelectedSize = (sizeId) => {
        emit('selectedSize', sizeId)
    }

</script>