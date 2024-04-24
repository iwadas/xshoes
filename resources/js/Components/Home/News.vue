<template>
    <div class="bg-gradient-to-tr from-pink-950 via-20% to-purple-950 via-black overflow-hidden ">
        <div class="h-40 overflow-hidden relative">
            <div class="h-64 absolute left-0 -top-32 bg-white" style="width: 500px; border-radius: 500px"></div>
            <div class="h-20 w-20 absolute left-40 top-2 bg-purple-400 rounded-full"></div>
            <div class="h-20 w-20 absolute left-64 top-2 bg-purple-400 rounded-full"></div>
            <div class="h-20 w-20 absolute left-20 top-2 bg-purple-400 rounded-full"></div>
            <div class="h-20 w-20 absolute left-20 top-2 bg-purple-400 rounded-full"></div>
            <div class="absolute left-1/2 translate-x-4 h-20 top-10 w-20 rounded-t-full bg-white overflow-hidden">
                <div class="relative w-full h-full">
                    <div class="absolute h-12 w-12 rounded-full bg-purple-400 -left-2 top-2"></div>
                </div>
            </div>
            <div class="absolute left-1/2 translate-x-28 h-20 top-10 w-20 rounded-t-full bg-white overflow-hidden">
                <div class="relative w-full h-full">
                    <div class="absolute h-10 w-10 rounded-full bg-purple-400 -right-6 top-10"></div>
                </div>
            </div>
            <div class="absolute left-1/2 translate-x-52 h-20 top-10 w-20 rounded-t-full bg-white overflow-hidden">
                <div class="relative w-full h-full">
                    <div class="absolute h-10 w-10 rounded-full bg-purple-400 -left-8 top-10"></div>
                </div>
            </div>
            <div class="absolute left-[1500px] -top-20 bg-white h-40 w-40 rotate-45"></div>
            <div class="absolute left-[1700] top-8">
                <div class="relative h-20 w-20 bg-white rounded-full">
                    <div class="absolute bg-purple-400 h-10 w-10 left-1/2 -translate-x-1/2 top-1/2 -translate-y-1/2 rotate-45"></div>
                    <div class="absolute bg-white h-4 w-4 left-1/2 -translate-x-1/2 top-1/2 -translate-y-1/2 rounded-full"></div>
                </div>
            </div>
            <div class="absolute left-[600] top-0 h-20 w-32">
                <div class="relative w-full h-full">
                    <div class="absolute left-0 bottom-0 h-full w-4 bg-white"></div>
                    <div class="absolute right-0 bottom-0 h-full w-4 bg-white"></div>
                    <div class="absolute bottom-0 h-4 w-full bg-white"></div>
                    <div class="absolute left-8 top-0 h-[48] w-4 bg-white"></div>
                    <div class="absolute right-8 top-0 h-[48] w-4 bg-white"></div>
                    <div class="absolute bottom-8 left-8 h-4 w-[48] bg-white"></div>
                </div>
            </div>
        </div>
        <div ref="newsList" class="relative mx-auto text-white py-10 duration-500" style="width: calc(84vw + 48px); height: calc(28vw + 80px)" :class="reactiveClasses">
            <single-news v-for="news in newsArray" :news="news" :key="news.id" :index="currentNewsIndex[news.id]"/>
        </div>
        <div class="h-40 overflow-hidden relative rotate-180">
            <div class="h-64 absolute left-0 -top-32 bg-white" style="width: 500px; border-radius: 500px"></div>
            <div class="h-20 w-20 absolute left-40 top-2 bg-purple-400 rounded-full"></div>
            <div class="h-20 w-20 absolute left-64 top-2 bg-purple-400 rounded-full"></div>
            <div class="h-20 w-20 absolute left-20 top-2 bg-purple-400 rounded-full"></div>
            <div class="h-20 w-20 absolute left-20 top-2 bg-purple-400 rounded-full"></div>
            <div class="absolute left-1/2 translate-x-4 h-20 top-10 w-20 rounded-t-full bg-white overflow-hidden">
                <div class="relative w-full h-full">
                    <div class="absolute h-12 w-12 rounded-full bg-purple-400 -left-2 top-2"></div>
                </div>
            </div>
            <div class="absolute left-1/2 translate-x-28 h-20 top-10 w-20 rounded-t-full bg-white overflow-hidden">
                <div class="relative w-full h-full">
                    <div class="absolute h-10 w-10 rounded-full bg-purple-400 -right-6 top-10"></div>
                </div>
            </div>
            <div class="absolute left-1/2 translate-x-52 h-20 top-10 w-20 rounded-t-full bg-white overflow-hidden">
                <div class="relative w-full h-full">
                    <div class="absolute h-10 w-10 rounded-full bg-purple-400 -left-8 top-10"></div>
                </div>
            </div>
            <div class="absolute left-[1500px] -top-20 bg-white h-40 w-40 rotate-45"></div>
            <div class="absolute left-[1700] top-8">
                <div class="relative h-20 w-20 bg-white rounded-full">
                    <div class="absolute bg-purple-400 h-10 w-10 left-1/2 -translate-x-1/2 top-1/2 -translate-y-1/2 rotate-45"></div>
                    <div class="absolute bg-white h-4 w-4 left-1/2 -translate-x-1/2 top-1/2 -translate-y-1/2 rounded-full"></div>
                </div>
            </div>
            <div class="absolute left-[600] top-0 h-20 w-32">
                <div class="relative w-full h-full">
                    <div class="absolute left-0 bottom-0 h-full w-4 bg-white"></div>
                    <div class="absolute right-0 bottom-0 h-full w-4 bg-white"></div>
                    <div class="absolute bottom-0 h-4 w-full bg-white"></div>
                    <div class="absolute left-8 top-0 h-[48] w-4 bg-white"></div>
                    <div class="absolute right-8 top-0 h-[48] w-4 bg-white"></div>
                    <div class="absolute bottom-8 left-8 h-4 w-[48] bg-white"></div>
                </div>
            </div>
        </div>
    </div>

</template>

<script setup>
    
    import SingleNews from '@/Components/Home/SingleNews.vue'
    import { onMounted, onUnmounted, ref } from 'vue';

    const props = defineProps({
        newsArray: Array,
    })

    let newsQueue = [];
    let currentNewsIndex = ref({})
    const notShow = "opacity-0 translate-y-20 pt-20"
    const newsList = ref(null)
    const reactiveClasses = ref(notShow)
    let interval = null;

    const handleScroll = () => {
        if(newsList.value){
            const boxPosition = newsList.value.getBoundingClientRect().top;
            const windowHeight = window.innerHeight;
    
            if (boxPosition < windowHeight * 3/5) {
                reactiveClasses.value = null
                if (props.newsArray.length > 3) {
                    if(!interval){
                        interval = setInterval(swapNews, 5000);
                    }
                }
            } else {
                if(interval){
                    clearInterval(interval);
                    interval = null
                }
                reactiveClasses.value = notShow
            }
        }
    }

    const swapNews = () => {
        let lastNews = newsQueue[newsQueue.length - 1]
        newsQueue.pop();
        newsQueue.unshift(lastNews);
        showNews();
    }

    const showNews = () => {
        newsQueue.forEach((news, index) => {
            currentNewsIndex.value[news.id] = index
        })
    }

    const setNews = () => {
        showNews();
    }

    onMounted(
        ()=>{
            window.addEventListener('scroll', handleScroll);
            newsQueue = [...props.newsArray];
            setNews();
        }
    )

    onUnmounted(
        ()=>{
            window.removeEventListener('scroll', handleScroll);
        }
    )

</script>