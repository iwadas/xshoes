<template>

    <div>
        {{ orders }}
    </div>

</template>

<script setup>

    const props = defineProps({
        orders: Array
    })

</script>