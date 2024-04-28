<template>

    <ul class="flex gap-2">
        <div v-for="brand in brands" :key="brand.id" class="font-semibold py-1 px-2 rounded-lg bg-black text-white">
            {{ brand.name }}
        </div>
    </ul>

</template>

<script setup>


    defineProps({
        brands: Array
    })

</script>