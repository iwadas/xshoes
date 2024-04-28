<template>

    <div>
        <h3 class="font-semibold mb-1 text-lg">
            About
        </h3>
        <p>
            {{ description }}
        </p>
    </div>

</template>

<script setup>

    defineProps({
        description: String,
    })

</script>