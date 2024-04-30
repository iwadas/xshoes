<template>

    <div class="flex justify-center gap-2 flex-wrap">
        <Link 
            v-for="size in sizes" 
            :href="route('store.show', {item: itemId, selectedSize: size.id})" 
            class="bg-black text-white rounded-lg px-3 py-1 font-semibold"
        >
            {{ size.name }}
        </Link>
    </div>

</template>

<script setup>

    import { Link } from '@inertiajs/vue3'

    defineProps({
        sizes: Array,
        itemId: Number
    })

</script>