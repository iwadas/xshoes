<template>
    
    <div class="mt-20">
        <h1 class="mb-10 text-5xl font-bold flex items-center justify-center">
            <i class="button-special-text mr-2 fa-solid fa-shopping-bag text-4xl"></i>
            Orders
            <br/>
        </h1>
        <div class="flex flex-col w-1/2 gap-3 mx-auto my-4" v-if="uncompleted_orders ? uncompleted_orders.length : false">
            <h2 class="text-2xl font-semibold">
                <i class="button-special-text mr-2 fa-solid fa-circle-question text-xl"></i>
                Uncompleted
            </h2>
            <div class="flex flex-col gap-y-3">
                <order v-for="order in uncompleted_orders" :order="order" :uncompleted="true"></order>
            </div>
        </div>
        <div class="flex flex-col w-1/2 gap-3 mx-auto my-4">
            <h2 class="text-2xl font-semibold">
                <i class="button-special-text mr-2 fa-solid fa-circle-check text-xl"></i>
                Completed
            </h2>
            <div class="flex flex-col gap-y-3">
                <order v-for="order in orders" :order="order"></order>
            </div>
        </div>
    </div>

</template>

<script setup>

    import Order from "@/Components/Order/Order.vue"

    const props = defineProps({
        orders: Array,
        uncompleted_orders: Array
    })

</script>