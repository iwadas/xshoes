<template>

    <div class="mt-20">
        <h1 class="mb-10 text-5xl font-bold flex items-center justify-center">
            <i class="button-special-text mr-2 fa-solid fa-chart-simple text-4xl"></i>
            Sales
            <br/>
        </h1>

        <div class="grid grid-cols-10 mx-10 gap-10">
            {{ income }}
            {{ products }}
        </div>
        
    </div>
</template>

<script setup>

    const props = defineProps({
        // orders: Object
        income: Number,
        products: Object
    })

</script>