<template>

    <div class="border-r px-10">
        <h2 class="font-bold text-2xl py-8">
            <i class="fa-solid fa-arrow-up-right-dots text-purple-500 text-xl mr-2"></i>
            Best Selling
        </h2>
        <ul v-for="itemObject, index in items" :class="index == (items.length - 1) ? null : 'border-b'">
            <sales-item :item-object="itemObject"/>
        </ul>
    </div>

</template>

<script setup>

    import SalesItem from '@/Components/ControlPanelSales/SalesItem.vue'

    const props = defineProps({
        items: Object
    })

</script>   