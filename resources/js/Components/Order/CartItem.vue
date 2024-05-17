<template>

    <div class="px-8 gap-x-2 flex justify-between relative">
        <div class="flex gap-x-12 items-center py-4">
            <div class="h-32 w-32">
                <img :src="cartItem.item.images[0].src" alt="" class="w-full h-full object-cover">
            </div>
            <div class="font-semibold flex flex-col gap-x-2 text">
                <Link class="hover:underline text-xl" :href="route('store.show', {item: cartItem.item.id})">{{ cartItem.item.name }}</Link>
                <p>
                    <span class="font-normal">size: </span> {{ cartItem.size.name }}
                </p>
            </div>
        </div>
        <div class="font-semibold text-2xl py-10">
            <p class="text-end">
                {{ price }}$
            </p>
            <p v-if="cartItem.amount > 1" class="font-normal text-sm text-end">
                unit price: {{ cartItem.item.price }}$
            </p>
        </div>
        <div class="absolute bottom-2 right-2 text-purple-500 hover:underline">
            cancel order
        </div>
    </div>


</template>

<script setup>

    import { computed } from 'vue'
    import { Link } from '@inertiajs/vue3'

    const props = defineProps({
        cartItem: Object,
    })

    const price = computed(
        ()=>props.cartItem.item.price * props.cartItem.amount
    )


</script>