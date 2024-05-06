<template>

    <div class="container mx-auto py-8 px-12 relative bg-white rounded-md top-20" 
        :class="fit ? 'w-fit' : null" 
        style="box-shadow: 0 0 10px lightgray"
    >
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
        fit: Boolean
    })

</script>