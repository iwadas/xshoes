<template>

    <ul class="flex gap-x-2 mx-auto" v-if="links.length > 3">
        <li v-for="link in links" class="hover:scale-105 duration-100 shadow-sm hover:shadow-lg">
            <Link 
                v-if="link.url" 
                v-html="link.label" 
                :href="link.url" :class="link.active ? 'bg-white text-purple-500' : 'bg-purple-500 text-white'" 
                class="border-[3px] border-purple-500 px-3 py-1 font-semibold rounded-lg text-xl duration-100"></Link>
        </li>
    </ul>

</template>

<script setup>

    import { Link } from '@inertiajs/vue3'

    const props = defineProps({
        links: Array
    })

</script>