<template>
    
    <div class="mt-20">
        <h1 class="mb-10 text-5xl font-bold flex items-center justify-center">
            <i class="button-special-text mr-3 fa-solid fa-shopping-bag text-4xl"></i>
            {{ title[status] }}
        </h1>
        <div class="w-1/2 mx-auto mt-10 flex justify-between">
            <div class="relative w-1/2">
                <input v-model="form.search" class="border w-full rounded-lg px-2 py-1" type="text" placeholder="Search...">
                <button class="absolute top-1/2 right-3 -translate-y-1/2 opacity-70" @click="clearSearch">
                    <i class="fa-solid fa-x"></i>
                </button>
            </div>
            <button @click="changeStatus" class="button-primary font-semibold w-fit">{{ title[otherStatus[status]] }}</button>
        </div>
        <div class="flex flex-col w-1/2 gap-3 mx-auto my-4" v-if="orders.data ? orders.data.length : false">
            <div class="flex flex-col gap-y-3">
                <order v-for="order in orders.data" :order="order" :status="status"></order>
            </div>
            <pagination :link="orders.links"/>
        </div>
        <div v-else class="mx-auto py-4 px-10 text-2xl font-bold opacity-30 border-dashed rounded-lg w-fit mt-20">
            Everything is completed! 😉
        </div>
    </div>

</template>

<script setup>

    import Pagination from '@/Components/UX/Pagination.vue'
    import Order from "@/Components/Order/ControlPanelOrder.vue"
    import { useForm } from '@inertiajs/vue3'
    import { watch } from 'vue'
    import debounce from 'lodash/debounce'

    const props = defineProps({
        orders: Object,
        status: String,
        search: String
    })

    const form = useForm({
        status: props.status,
        search: props.search
    })

    const title = {
        shipped: 'Orders to complete',
        received: 'Orders to ship'
    }

    const otherStatus = {
        received: 'shipped',
        shipped: 'received',
    }

    const clearSearch = () => {
        form.search = null
    }
    
    watch(()=>form.search, ()=>{
        sendForm();
    })

    const sendForm = debounce(
        ()=>{
                form.get(route('control_panel.order.index'))
        }, 1000
    )

    const changeStatus = () => {
        form.status = otherStatus[props.status];
        form.get(route('control_panel.order.index'))
    }

</script>