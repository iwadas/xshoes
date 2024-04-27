<template>
    <div class="flex flex-col rounded-lg shadow-lg pt-2 pb-4 px-4" style="box-shadow: 0 0 10px lightgray">
        <div class="h-80 w-full">
            <item-image :src="item.images[0].src"/>
        </div>
        <div class="flex flex-col -mt-4">
            <div class="flex justify-between items-center">
                <h2 class="flex justify-between font-semibold text-xl">
                    {{ item.name }}
                </h2>
                <colors :colors="item.colors"/>
            </div>
            <categories :categories="item.categories"/>
            <div class="text-3xl font-bold mt-2">
                {{ item.price }}$
            </div>
        </div>
    </div>
</template>

<script setup>

    import ItemImage from '@/Components/Store/ItemImage.vue';
    import Categories from '@/Components/UX/Categories.vue'
    import Colors from '@/Components/Store/Colors.vue'

    const props = defineProps({
        item: Object
    })

</script>