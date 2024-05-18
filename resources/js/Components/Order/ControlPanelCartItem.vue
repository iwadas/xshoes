<template>

    <div class="px-8 gap-x-2 flex justify-between relative py-4">
        <div>
            {{ cartItem.amount }} x
            <Link class="hover:underline" :href="route('store.show', {item: cartItem.item.id})">{{ cartItem.item.name }}</Link>
        </div>
        <span class="font-normal">size: {{ cartItem.size.name }}</span> 
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