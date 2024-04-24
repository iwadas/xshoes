<template>
    <div class="w-full relative bg-gradient-to-tr from-purple-600 to-black -mt-20" style="height: 100vh">
        <logo-container :white="true"/>
        <iframe ref="mainIframe" src="https://my.spline.design/untitled-afd5083db9091b1b14ff40bae9920310/" class="absolute top-0 left-0 w-full h-full duration-1000" style="opacity: 0" frameborder="0"></iframe>
        <div class="h-64 bg-gradient-to-b from-transparent to-white absolute -bottom-0 w-full z-30"></div>
    </div>
    <div class="flex flex-col gap-y-32">
        <categories :categories="categories"/>
        <news :news-array="news"/>
        <most-popular/>
    </div>

    <!-- <popular-items/> -->
    <div class="flex pb-96"></div>

</template>

<script setup>

    import { Link } from '@inertiajs/vue3'
    import { ref, onMounted, onUnmounted } from 'vue'
    import LogoContainer from '@/Components/UI/LogoContainer.vue';
    import Categories from '@/Components/Home/Categories.vue';
    import MostPopular from '@/Components/Home/MostPopular.vue';
    import News from '@/Components/Home/News.vue';

    const props = defineProps({
        categories: Array,
        news: Array
    })

    const mainIframe = ref(null);

    const handleIframeLoaded = () =>{
        setTimeout(
            ()=>mainIframe.value.style.opacity = 1
            ,1500
        )
    }

    onMounted(
        ()=>{
            // mainIframe.value.addEventListener('load', handleIframeLoaded);
        }
    )

    onUnmounted(
        ()=>{
            // mainIframe.value.removeEventListener('load', handleIframeLoaded);  
        }
    )


</script>