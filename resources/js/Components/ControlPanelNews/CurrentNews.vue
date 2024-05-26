<template>
    <div class="w-1/2">
        <h2 class="font-semibold text-2xl my-4">
            <i class="fa-solid fa-toggle-on text-purple-500 text-xl mr-2"></i>
            Current news
        </h2>
        <div class="flex flex-wrap gap-4">
            <single-news v-for="news in newsArray" :news="news" :key="news.id"/>
        </div>
    </div>
</template>

<script setup>

    import SingleNews from '@/Components/ControlPanelNews/SingleNews.vue';

    const props = defineProps({
        newsArray: Array
    })    

</script>