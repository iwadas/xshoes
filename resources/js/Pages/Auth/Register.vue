<template>


    <logo-container/>
    <container :fit="true">
        <template v-slot:icon>
            <i class="fa-solid fa-right-to-bracket text-3xl"></i>
        </template>
        <template v-slot:header>
            Register
        </template>
        <div>
            <form @submit.prevent="sendForm" class="flex flex-col items-center gap-y-4 mt-10">
                <div v-if="Object.keys(form.errors).length != 0" class="border-2 border-purple-500 rounded-md py-2 px-4 font-semibold flex flex-col gap-y-2">
                    <div v-for="(key,value) in form.errors" class="flex items-center" :key="value">
                        <i class="fa-solid fa-triangle-exclamation text-purple-500"></i>
                        <p class="text-sm inline ml-2">
                            {{ key }}
                        </p>
                    </div>
                </div>
                <div class="flex flex-col gap-y-2 items-center w-96">
                    <label class="font-semibold" for="email">
                        <i v-if="form.errors.name" class="fa-solid fa-triangle-exclamation text-purple-500"></i>
                        Name
                    </label>
                    <div class="w-full relative">
                        <input type="text" id="name" v-model="form.name" class="border py-1 pl-4 pr-7 rounded-md w-full outline-none">
                        <button @click="clear('name')" type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-sm">
                            <i class="fa-solid fa-x"></i>
                        </button>
                    </div>
                </div>
                <div class="flex flex-col gap-y-2 items-center w-96">
                    <label class="font-semibold" for="email">
                        <i v-if="form.errors.email" class="fa-solid fa-triangle-exclamation text-purple-500"></i>
                        Email
                    </label>
                    <div class="w-full relative">
                        <input type="text" id="email" v-model="form.email" class="border py-1 pl-4 pr-7 rounded-md w-full outline-none">
                        <button @click="clear('email')" type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-sm">
                            <i class="fa-solid fa-x"></i>
                        </button>
                    </div>
                </div>
                <div class="flex flex-col gap-y-2 items-center w-96">
                    <label class="font-semibold" for="password">
                        <i v-if="form.errors.password" class="fa-solid fa-triangle-exclamation text-purple-500"></i>
                        Password
                    </label>
                    <div class="w-full relative">
                        <input :type="showPassword ? 'text' : 'password'" id="password" v-model="form.password" class="border py-1 pl-4 pr-7 rounded-md w-full outline-none">
                        <button @click="toggleShowPassword" type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-sm">
                            <i class="fa-solid" :class="showPassword ? 'fa-eye' : 'fa-eye-slash'"></i>
                        </button>
                    </div>
                </div>
                <div class="flex flex-col gap-y-2 items-center w-96">
                    <label class="font-semibold" for="password_confirmation">
                        <i v-if="form.errors.password_confirmation" class="fa-solid fa-triangle-exclamation text-purple-500"></i>
                        Repeat password
                    </label>
                    <div class="w-full relative">
                        <input :type="showPassword ? 'text' : 'password'" id="password_confirmation" v-model="form.password_confirmation" class="border py-1 pl-4 pr-7 rounded-md w-full outline-none">
                        <button @click="toggleShowPassword" type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-sm">
                            <i class="fa-solid" :class="showPassword ? 'fa-eye' : 'fa-eye-slash'"></i>
                        </button>
                    </div>
                </div>
                <button type="submit" class="button-special-back mt-6">
                    Register
                    <div class="button-special-front">
                        <div class="button-special-text">
                            Register
                        </div>
                    </div>
                </button>
                <div class="text-sm">
                    You already have account? Click <Link :href="route('login')" class="text-purple-500 hover:underline font-semibold">here!</Link>
                </div>
            </form>
        </div>
    </container>

</template>

<script setup>

    import Container from '@/Components/UI/Container.vue';
    import LogoContainer from '@/Components/UI/LogoContainer.vue';
    import { useForm, Link } from '@inertiajs/vue3'
    import { ref } from 'vue'


    const form = useForm({
        name: null,
        email: null,
        password: null,
        password_confirmation: null
    })

    const showPassword = ref(false);

    const clear = (value) => {
        form[value] = null;
    }

    const toggleShowPassword = () => {
        showPassword.value = !showPassword.value;
    }

    const sendForm = () => {
        form.post(route('register_authenticate', form));
    }



</script>