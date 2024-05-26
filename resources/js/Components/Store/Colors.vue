<template>

    <ul class="flex items-center gap-2">
        <div v-for="color in colors" :key="color" class="rounded-full -ml-4" style="box-shadow: 0 0 10px lightgray" :class="big ? 'w-10 h-10' : 'h-6 w-6'" :style="'background-color:' + color.color ">
        </div>
    </ul>

</template>

<script setup>

    defineProps({
        colors: Array,
        big: Boolean
    })

</script>