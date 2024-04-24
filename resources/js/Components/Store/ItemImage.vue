<template>

    <img :src="src" class="w-full h-full object-contain" alt="">

</template>

<script setup>

    defineProps({
        src: String
    })

</script>