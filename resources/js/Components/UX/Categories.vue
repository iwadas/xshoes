<template>

    <div>
        <div v-for="category, index in categories" :key="category.id" class="inline">
            <span v-if="index!=0"> > </span><Link :href="route('store.index', {category: category.id})" class="hover:underline">{{ category.name }} </Link>
        </div>
    </div>

</template>

<script setup>

    import { Link } from '@inertiajs/vue3'

    defineProps({
        categories: Array
    })

</script>