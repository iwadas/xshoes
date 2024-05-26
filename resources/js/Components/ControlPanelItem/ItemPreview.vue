<template>
    <div class="mt-20 grid grid-cols-3 container mx-auto gap-8">
        <item-images :images="images" class="col-span-2"/>
        <item-info :item="item"/>
    </div>
</template>

<script setup>

    import ItemImages from '@/Components/StoreShow/ItemImages.vue'
    import ItemInfo from '@/Components/StoreShow/ItemInfo.vue'
    import { computed } from 'vue'

    const props = defineProps({
        item: Object,
        selectedSize: Number
    })

    const images = computed(
        ()=>props.item.images.length ? props.item.images : [{main: true, src: '/images/logo/logo_black.png'}]
    )

</script>