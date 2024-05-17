<template>
    <div class="w-full relative bg-gradient-to-tr from-purple-600 to-black -mt-20" style="height: 100vh">
        <logo-container :white="true"/>
        <div class="relative w-full h-full">
            <canvas id="splineCanva" frameborder="0"></canvas>
        </div>
        <div class="h-64 bg-gradient-to-b from-transparent to-white absolute -bottom-0 w-full z-30"></div>
    </div>
    <div class="flex flex-col gap-y-32">
        <categories :categories="categories"/>
        <news :news-array="news"/>
        <most-popular/>
    </div>

    <div class="flex pb-96"></div>

</template>

<script setup>

    import { ref, onMounted } from 'vue'
    import { Application } from '@splinetool/runtime';
    import LogoContainer from '@/Components/UI/LogoContainer.vue';
    import Categories from '@/Components/Home/Categories.vue';
    import MostPopular from '@/Components/Home/MostPopular.vue';
    import News from '@/Components/Home/News.vue';

    const props = defineProps({
        categories: Array,
        news: Array
    })

    let spline;

    onMounted(()=>{
        const canvas = document.getElementById('splineCanva');
        spline = new Application(canvas);
        spline.load('https://prod.spline.design/cauj2IUcenYDhEEl/scene.splinecode')
            .then(() => {
                console.log('Spline scene loaded successfully!');
            })
            .catch((error) => {
                console.error('Error loading Spline scene:', error);
            });
        }
    )


</script>