<template>

    <div class="flex flex-col px-5 pb-4">
        <div class="flex justify-between py-4">
            <div class="h-20 w-20">
                <img :src="itemObject.item.images[0].src" alt="" class="w-full h-full object-cover">
            </div>
            <div class="flex flex-col items-center gap-y-4">
                <div class="flex gap-x-2 text text-sm">
                    <h3>{{ itemObject.item.name }}</h3><div>{{ itemObject.item.price }}$</div>
                </div>
                <div class="text-xl">
                    <span class="font-bold">{{ itemObject.sold }}</span> sold
                </div>
            </div>
        </div>
        <div>
            <div class="flex flex-col">
                <div class="grid grid-cols-3 gap-1">
                    <p class="col-span-3 font-semibold">
                        sizes sold:
                    </p>
                    <div class="p-1 text-center" v-for="size, key in itemObject.sizes">
                        {{key}} : <span class="font-semibold">{{ size }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>


</template>

<script setup>

    import { computed } from 'vue'
    import { Link } from '@inertiajs/vue3'

    const props = defineProps({
        itemObject: Object,
    })


</script>