<template>

    <div class="container mx-auto py-8 px-12 relative bg-white rounded-md shadow-lg" :class="fit ? 'w-fit' : null" :style="top ? 'margin-top: calc(50vh - 100px); transform: translateY(-50%)' : 'margin-top: 76px'">
        <div class="text-4xl flex gap-x-3 justify-center items-center font-bold">
            <div class="button-special-text">
                <slot name="icon">
                </slot>
            </div>
            <slot name="header">
            </slot>
        </div>
        <slot>
        </slot>
    </div>

</template>

<script setup>

    const props = defineProps({
        top: Boolean,
        fit: Boolean
    })

</script>