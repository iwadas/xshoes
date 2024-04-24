<template>
    
    <div class="mt-20">
        <h1 class="mb-10 text-5xl font-bold flex items-center justify-center">
            <i class="button-special-text mr-2 fa-solid fa-store text-4xl"></i>
            Store
        </h1>
        <div class="grid grid-cols-10 gap-3 mx-6">
            <item-filter :sub-categories="subCategories" class="flex flex-col col-span-3 pr-4 border-r"/>
            <div class="grid grid-cols-3 gap-4 col-span-7">
                <item v-for="item in items" :item="item" :key="item.id"/>
            </div>
        </div>
    </div>

</template>

<script setup>

    import Item from "@/Components/Store/Item.vue";
    import ItemFilter from '@/Components/Store/ItemFilter.vue';

    const props = defineProps({
        subCategories: Array,
        items: Array
    })

</script>