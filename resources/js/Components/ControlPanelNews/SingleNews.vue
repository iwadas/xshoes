<template>

    <div class="relative rounded-lg duration-200 overflow-hidden h-[400px] w-[400px]" style="box-shadow: 0 0 10px lightgray">
        <div class="absolute top-1/2 -translate-x-1/2 left-1/2 -translate-y-1/2 mt-0.5 ml-0.5 font-teko text-white text-4xl font-bold whitespace-nowrap">
            {{ news.header }}
        </div>
        <div class="absolute top-1/2 -translate-x-1/2 left-1/2 -translate-y-1/2 font-teko text-4xl font-bold whitespace-nowrap" :style="'color: ' + news.color">
            {{ news.header }}
        </div>
        <img :src="news.src" class="w-full h-full object-cover" loading="lazy">
        <Link :href="route('control_panel.news.destroy', {news: news.id})" method="DELETE" as="button" class="absolute top-4 right-4 h-8 w-8 grid place-items-center border-[3px] bg-white rounded-lg text-red-500 border-red-500">
            <i class="fa-solid fa-trash"></i>
        </Link>
    </div>

</template>

<script setup> 

    import { Link } from '@inertiajs/vue3'

    const props = defineProps({
        news: Object,
    })


</script>