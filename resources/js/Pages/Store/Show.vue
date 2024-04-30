<template>

    <div class="mt-20 grid grid-cols-3 container mx-auto gap-8">
        <item-images :images="item.images" class="col-span-2"/>
        <item-info :item="item" :selected-size="selectedSize"/>
    </div>
</template>

<script setup>

    import ItemImages from '@/Components/StoreShow/ItemImages.vue'
    import ItemInfo from '@/Components/StoreShow/ItemInfo.vue'

    const props = defineProps({
        item: Object,
        selectedSize: Number
    })

</script>