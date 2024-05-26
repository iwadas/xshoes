<template>



    <div>
        <h2 class="text-2xl font-semibold my-4">
            <i class="fa-solid fa-circle-plus text-purple-500 text-xl mr-2"></i>
            Create new
        </h2>
        <form @submit.prevent="sendForm" class="px-10 py-4 rounded-lg flex flex-col gap-y-5" style="box-shadow: 0 0 10px lightgray">
            <div class="relative flex flex-col gap-y-2">
                <div class="absolute left-1/2 -translate-x-1/2 text-purple-500 font-bold" v-if="form.errors ? form.errors.header : null">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    {{ form.errors.header }}
                </div>
                <label class="font-semibold" for="header">Header</label>
                <input type="text" v-model="form.header" id="header" class="outline-none border px-2 py-1 rounded-lg">
            </div>
            <div class="flex flex-col gap-y-2 relative">
                <div class="absolute left-1/2 -translate-x-1/2 text-purple-500 font-bold" v-if="form.errors ? form.errors.color : null">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    {{ form.errors.color }}
                </div>
                <div class="absolute top-1 right-1 text-xs">(you can use <a href="https://htmlcolorcodes.com" class="text-indigo-500 hover:underline">color generator</a> to set color)</div>
                <label class="font-semibold" for="header">Color</label>
                <input type="text" v-model="form.color" id="header" class="outline-none border px-2 py-1 rounded-lg">
            </div>
            <div class="relative flex flex-col gap-y-2">
                <div class="absolute left-1/2 -translate-x-1/2 text-purple-500 font-bold" v-if="form.errors ? form.errors.image : null">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    {{ form.errors.image }}
                </div>
                <label class="font-semibold" for="header">Image</label>
                <input type="file" @input="updateImage" id="header" class="file:bg-purple-500 file:text-white bg-gray-100 file:border-none file:rounded-l-lg file:px-3 file:py-1 file:font-semibold border rounded-lg file:hover:bg-purple-400">
            </div>
            <button class="button-primary font-semibold w-1/3 min-w-40 mx-auto flex justify-center">Upload</button>
        </form>
        <h2 class="text-2xl font-semibold my-4">
            <i class="fa-solid fa-magnifying-glass text-purple-500 text-xl mr-2"></i>
            Preview
        </h2>
        <div class="relative rounded-lg duration-200 overflow-hidden w-full" style="box-shadow: 0 0 10px lightgray; height: 40vw">
            <div class="absolute top-1/2 -translate-x-1/2 left-1/2 -translate-y-1/2 mt-0.5 ml-0.5 font-teko text-white text-5xl font-bold whitespace-nowrap">
                {{form.header}}
            </div>
            <div class="absolute top-1/2 -translate-x-1/2 left-1/2 -translate-y-1/2 font-teko text-5xl font-bold whitespace-nowrap" :style="'color: ' + form.color">
                {{form.header}}
            </div>
            <img :src="src ? src : '/images/logo/logo_white.png'" class="w-full h-full object-cover">
        </div>
    </div>

</template>


<script setup>
 
    import { useForm } from '@inertiajs/vue3'
    import { computed } from 'vue'

    const form = useForm({
        header: "Header",
        image: null,
        color: '33FFDA',
    })

    const src = computed(()=> form.image ? URL.createObjectURL(form.image) : null)

    const updateImage = (e) => {
        form.image = e.target.files[0];
    }

    const clearForm = () => {
        form.header = null,
        form.image = null,
        form.color = null
    }

    const sendForm = () => {
        form.post(route('control_panel.news.store'), {preserveScroll: true, onSuccess: clearForm});
    }

</script>