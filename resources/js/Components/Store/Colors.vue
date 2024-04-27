<template>

    <ul class="flex items-center gap-2">
        <div v-for="color in colors" :key="color" class="rounded-full h-6 w-6 -ml-4" style="box-shadow: 0 0 10px lightgray" :class="bgColors[color.name]">
        </div>
    </ul>

</template>

<script setup>

    const bgColors = {
        "black": "bg-black",
        "white": "bg-white",
        "gray": "bg-gray-500",
        "blue": "bg-sky-500",
        "red": "bg-red-600",
        "green": "bg-green-500",
        "purple": "bg-purple-500",
        "pink": "bg-pink-500",
        "dark blue": "bg-blue-900",
        "orange": "bg-orange-500",
        "yellow": "bg-yellow-400"
    }

    defineProps({
        colors: Array
    })

</script>