<template>
    
    <div v-if="bestsellers.length">
        <h1 class="mb-10 text-5xl font-bold flex items-center justify-center">
            <i class="button-special-text mr-2 fa-solid fa-star text-4xl"></i>
                Bestsellers
            <br/>
        </h1>
        <div class="flex justify-between">
            <button class="px-10 text-2xl" @click="previous">
                <i class="fa-solid fa-chevron-left" :class="{'opacity-0' : currentIndex == 0}">
                </i>
            </button>
            <div class="flex duration-100 overflow-x-scroll relative no-scrollbar">
                <div class="absolute h-full left-0 top-0 w-8 bg-gradient-to-r from-white to-transparent z-20"></div>
                <div class="flex gap-x-4 overflow-y-hidden py-3 px-4 scroll-smooth no-scrollbar" ref="bestsellerContainer">
                    <item v-for="item in bestsellers" :item="item" :key="item.id" class="min-w-[350px] w-[350px]"/>
                </div>
                <div class="absolute h-full right-0 top-0 w-8 bg-gradient-to-l from-white to-transparent z-20"></div>
            </div>
            <button class="px-10 text-2xl" @click="next">
                <i class="fa-solid fa-chevron-right">
                </i>
            </button>
        </div>
    </div>

</template>

<style scoped>
    .no-scrollbar::-webkit-scrollbar {
        display: none; /* Hide scrollbar for Chrome, Safari, and Opera */
    }

    .no-scrollbar {
        -ms-overflow-style: none;  /* Hide scrollbar for IE and Edge */
        scrollbar-width: none;  /* Hide scrollbar for Firefox */
    }
</style>

<script setup>


    import Item from '@/Components/StoreIndex/Item.vue'
    import { ref, computed } from 'vue'

    const props = defineProps({
        bestsellers: Array,
    })

    const bestsellersLength = props.bestsellers.length
    const bestsellerContainer = ref(null);
    const currentIndex = ref(0);

    const next = () => {
        currentIndex.value++;
        bestsellerContainer.value.scrollLeft = currentIndex.value * 365
    }

    const previous = () => {
        currentIndex.value = Math.max(0, currentIndex.value - 1);
        bestsellerContainer.value.scrollLeft = currentIndex.value * 365
    }

</script>