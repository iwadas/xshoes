<template>

    <div>
        <h3 class="font-semibold mb-1 text-lg">
            Select size
        </h3>
        <div class="grid grid-cols-4 gap-2">
            <button 
                v-for="size in sizes" 
                @click="changeSelectedSize(size.id)" 
                :key="size.id"
                :disabled="!size.pivot.amount"
                :class="{'opacity-25' : !size.pivot.amount}"
                class="font-bold py-3 min-w-10 b shadow-lg order-black text-white text-center rounded-lg hover:scale-105 duration-100 bg-black relative overflow-hidden"
            >
                <div 
                    class="absolute top-1/2 -translate-y-1/2 h-40 w-40 bg-purple-500 duration-500 rounded-full"
                    :class="selectedButton[size.id] ? '-left-10' : 'left-40'" 
                ></div>
                <div 
                    class="absolute top-1/2 -translate-y-1/2 h-40 w-40 bg-purple-500 duration-500 rounded-full"
                    :class="selectedButton[size.id] ? '-right-10' : 'right-40'" 
                ></div>
                <p class="relative">
                    {{ size.name }}
                </p>
            </button>
        </div>
    </div>


</template>

<script setup>

    import { ref } from 'vue'

    const props = defineProps({
        sizes: Array
    })

    const selectedButton = ref(
        {

        }
    )

    const changeSelectedSize = (sizeId) => {
        selectedButton.value = {};
        selectedButton.value[sizeId] = true;
    }

</script>