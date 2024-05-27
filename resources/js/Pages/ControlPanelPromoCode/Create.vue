<template>
    
    <div class="mt-20">
        <h1 class="mb-10 text-5xl font-bold flex items-center justify-center">
            <i class="button-special-text mr-3 fa-solid fa-tag text-4xl"></i>
            Create promo code
        </h1>
    </div>

    <div v-if="(form.errors ? Object.keys(form.errors).length : false) && showErrors" class=" border-red-500 border-[3px] rounded-lg shadow-lg text-red-500 font-bold w-fit fixed bg-white top-40 left-1/2 -translate-x-1/2">
        <div class="relative px-10 flex flex-col py-3">
            <div v-for="error in Object.values(form.errors)">
                {{ error }}
            </div>
            <button class="absolute top-2 right-2 h-5 w-5 grid place-items-center rounded border-red-500 border-[3px]" @click="showErrors = false">
                <i class="fa-solid fa-x text-red-500 text-xs"></i>
            </button>
        </div>
    </div>
    <form @submit.prevent="sendForm" class="mx-auto grid grid-cols-6 gap-4 rounded-lg w-full max-w-screen-lg py-4 px-10" style="box-shadow: 0 0 10px lightgray">
        <div class="flex flex-col col-span-3">
            <label for="name" class="font-bold whitespace-nowrap">Name</label>
            <input v-model="form.name" type="text" class="border rounded px-2 py-1 outline-none text-sm w-full" id="name">
        </div>
        <div class="flex flex-col col-span-2">
            <label for="amount" class="font-bold whitespace-nowrap">Amount</label>
            <input v-model="form.discount" type="number" class="border rounded px-2 py-1 outline-none text-sm w-full" id="amount">
        </div>
        <div class="flex flex-col col-span-1">
            <label for="type" class="font-bold whitespace-nowrap">Amount type</label>
            <select v-model="form.type" name="type" id="" class="px-2 py-0.5 outline-none appearance-none border rounded">
                <option value="fixed">$</option>
                <option value="percentage">%</option>
            </select>
        </div>
        <div class="flex flex-col col-span-2">
            <label for="amount" class="font-bold whitespace-nowrap">Valid till</label>
            <input v-model="form.available_till" type="date" class="border rounded px-2 py-1 outline-none text-sm w-full" id="amount">
        </div>
        <div class="flex flex-col col-span-2">
            <label for="amount" class="font-bold whitespace-nowrap">Price from</label>
            <input v-model="form.price_from" type="number" class="border rounded px-2 py-1 outline-none text-sm w-full" id="amount">
        </div>
        <div class="flex flex-col col-span-2">
            <label for="amount" class="font-bold whitespace-nowrap">Only for new users only</label>
            <div class="flex gap-x-2 items-center mt-2">
                <input v-model="form.for_new_users" type="checkbox" class="appearance-none checked:bg-purple-500 border rounded-sm w-4 h-4 duration-100" id="amount">
                <p>{{form.for_new_users}}</p>
            </div>
        </div>
        <div class="col-span-6">
            <button @type="submit" class="mx-auto button-primary font-bold">
                <i class="fa-solid fa-check"></i>
                Create
            </button>
        </div>
    </form>

</template>


<script setup>

    import { useForm } from '@inertiajs/vue3'
    import { ref, watch } from 'vue'

    const form = useForm({
        name: null,
        discount: null,
        available_till: null,
        price_from: null,
        type: 'fixed',
        for_new_users: false,

    })

    const showErrors = ref(true);

    watch(form.errors, ()=>{
        showErrors.value = true;
    })

    const sendForm = () => {
        form.post(route('control_panel.promo_code.store'));
    }

</script>