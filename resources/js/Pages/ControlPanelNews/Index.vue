<template>

    <div class="mt-20">
        <h1 class="mb-10 text-5xl font-bold flex items-center justify-center">
            <i class="button-special-text mr-2 fa-solid fa-newspaper text-4xl"></i>
                News
            <br/>
        </h1>
        <div class="flex mx-10 gap-x-4">
            <current-news :news-array="newsArray"/>
            <news-form class="w-1/2"/>
        </div>
    </div>
</template>

<script setup>

    import CurrentNews from '@/Components/ControlPanelNews/CurrentNews.vue';
    import NewsForm from '@/Components/ControlPanelNews/NewsForm.vue';

    const props = defineProps({
        newsArray: Array
    })

</script>