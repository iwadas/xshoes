<template>
    
    <form @submit.prevent="sendForm" class="flex flex-col gap-y-3">
        <div v-if="Object.keys(form.errors).length != 0" class="my-2 text-red-600 border-red-600 border-[3px] rounded-lg py-1 px-3 flex gap-x-8 w-fit mx-auto">
            <i class="fa-solid fa-triangle-exclamation text-4xl"></i>
            <div>
                <div v-for="error in form.errors" class="font-semibold">
                    {{ error }}
                </div>
            </div>
        </div>
        <div class="flex justify-between gap-x-3">
            <div class="relative w-full">
                <label class="absolute left-3 top-0 -translate-y-1/2 bg-white px-2 text-sm font-semibold">Name</label>
                <input v-model="form.name" type="text" class="w-full border rounded-lg pb-1 pt-2 px-2 outline-none">
            </div>
            <div class="relative w-full">
                <label class="absolute left-3 top-0 -translate-y-1/2 bg-white px-2 text-sm font-semibold">Surname</label>
                <input v-model="form.surname" type="text" class="w-full border rounded-lg pb-1 pt-2 px-2 outline-none">
            </div>
        </div>
        <div class="relative w-full">
            <label class="absolute left-3 top-0 -translate-y-1/2 bg-white px-2 text-sm font-semibold">Address</label>
            <input v-model="form.address" type="text" class="w-full border rounded-lg pb-1 pt-2 px-2 outline-none">
        </div>
        <div class="flex justify-between gap-x-3">
            <div class="relative w-full">
                <label class="absolute left-3 -top- -translate-y-1/2 bg-white px-2 text-sm font-semibold">Post Code</label>
                <input type="text" v-model="form.post_code" class="w-full border rounded-lg pb-1 pt-2 px-2 outline-none">
            </div>
            <div class="relative w-full">
                <label class="absolute left-3 top-0 -translate-y-1/2 bg-white px-2 text-sm font-semibold">City</label>
                <input v-model="form.city" type="text" class="w-full border rounded-lg pb-1 pt-2 px-2 outline-none">
            </div>
            <div class="relative w-full">
                <label class="absolute left-3 top-0 -translate-y-1/2 bg-white px-2 text-sm font-semibold">Phone Number</label>
                <input type="text" v-model="form.phone_number" class="w-full border rounded-lg pb-1 pt-2 px-2 outline-none">
            </div>
        </div>
        <div class="flex gap-x-4 ml-auto">
            <button type="button" @click="clear" class="button-primary w-fit font-semibold">Clear</button>
            <button type="submit" class="button-primary w-fit font-semibold">Save</button>
            <button type="button" @click="cancel" class="button-primary w-fit font-semibold" v-if="!fixedShow">Cancel</button>
        </div>

    </form>

</template>

<script setup>

    import { useForm } from '@inertiajs/vue3'

    const emit = defineEmits(['hide-form']);

    const props = defineProps({
        address: Object,
        fixedShow: Boolean
    })

    const form = useForm({
        name: props.address ? props.address.name : null,
        surname: props.address ? props.address.surname : null,
        address: props.address ? props.address.address : null,
        post_code: props.address ? props.address.post_code : null,
        city: props.address ? props.address.city : null,
        phone_number: props.address ? props.address.phone_number : null,
    })

    const cancel = () => {
        emit('hide-form');
    }

    const clear = () => {
        form.name = null;
        form.surname = null;
        form.address = null;
        form.post_code = null;
        form.city = null;
        form.phone_number = null;
    }

    const sendForm = () => { 
        if(props.address){
            form.put(route("address.update", {address: props.address.id}), {preserveScroll: true, onSuccess: cancel});
        } else {
            form.post(route("address.store"), {preserveScroll: true, onSuccess: cancel});
        }
    }


</script>