<template>

    <Link 
        :href="route('store.index', {category: category.id})" 
        class="bg-purple-500 rounded-lg relative items-center gap-y-3 text-white shadow-lg duration-100" 
        style="width: 28vw; height: 28vw"
    >
        <div class="w-full h-full flex justify-center items-center relative hover:-translate-y-2 hover:translate-x-2 duration-100">
            <img :src="category.src" class="w-full h-full object-cover rounded-lg" alt="">
            <h1 class="font-semibold translate-y-7 translate-x-3  absolute text-6xl">
                {{ category.name }}
            </h1>
            <h1 class="button-special-text absolute text-6xl">
                {{ category.name }}
            </h1>
            <h1 class="font-semibold -translate-y-7 -translate-x-3 absolute text-6xl">
                {{ category.name }}
            </h1>
        </div>
    </Link>

</template>

<script setup>

    import { Link } from '@inertiajs/vue3'

    defineProps({
        category: Object
    })


</script>