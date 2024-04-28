<template>
    <div class="border-t flex flex-col gap-y-3 py-3 px-4">
        <h3 class="font-bold text-xl">
            <i class="fa-solid fa-icons text-sm text-purple-500"></i>
            Category
        </h3>
        <item-category v-for="subCategory in subCategories" :key="subCategory.id" :sub-category="subCategory"/>
    </div>
</template>

<script setup>

    import ItemCategory from '@/Components/StoreIndex/ItemCategory.vue'

    const props = defineProps({
        subCategories: Array
    })

</script>