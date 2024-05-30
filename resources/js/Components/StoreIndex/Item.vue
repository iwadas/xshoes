<template>
    <div class="flex flex-col rounded-lg shadow-lg pt-2 pb-4 px-4 relative" style="box-shadow: 0 0 10px lightgray">
        <item-brands :brands="item.brands" class="absolute top-3 left-3 z-10"/>
        <div v-if="item.is_bestseller" class="absolute top-3 right-3 z-10">
            <div class="font-semibold py-1 px-2 rounded-lg bg-purple-500 text-white">
                <i class="fa-solid fa-star text-sm"></i>
                Bestseller
            </div>
        </div>
        <div class="h-80 w-full relative">
            <div class="w-full h-full absolute grid place-items-center bg-transparent-white opacity-0 hover:opacity-100 duration-100">
                <item-sizes 
                    class="text-black w-3/4"
                    :sizes="item.available_sizes"
                    :item-id="item.id"
                />
            </div>
            <item-image :src="item.images[0].src"/>
        </div>
        <div class="flex flex-col -mt-4 relative">
            <div class="flex justify-between items-center">
                <Link :href="route('store.show', {item: item.id})">
                    <h2 class="font-semibold text-xl">
                        {{ item.name }}
                    </h2>
                </Link>
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

    import ItemImage from '@/Components/StoreIndex/ItemImage.vue';
    import Categories from '@/Components/UX/Categories.vue';
    import ItemBrands from '@/Components/Store/ItemBrands.vue';
    import ItemSizes from '@/Components/StoreIndex/ItemSizes.vue';
    import Colors from '@/Components/Store/Colors.vue'
    import { Link } from '@inertiajs/vue3'

    const props = defineProps({
        item: Object
    })

</script>