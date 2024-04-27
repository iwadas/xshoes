<template>

    <div class="border-t flex flex-col gap-y-3 py-3 px-4">
        <h3 class="font-bold text-xl">
            <i class="fa-solid fa-diamond text-sm text-purple-500"></i>
            Brands
        </h3>
        <div class="flex flex-col gap-y-1">
            <checkbox 
                v-for="brand, brandId in brandsCount" 
                :key="Number(brandId)" 
                :label="brand.name" 
                filterType="brands" 
                :id="Number(brandId)" 
                :count="brand.count"
            />
        </div>
    </div>

</template>

<script setup>

    import Checkbox from '@/Components/Store/Checkbox.vue'

    const props = defineProps({
        brandsCount: Object,
    })

</script>