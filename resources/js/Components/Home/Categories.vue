<template>


    <ul ref="categoriesList" class="flex center gap-x-6 justify-center pt-8 duration-500" :class="reactiveClasses">
        <category v-for="category in categories" :category="category" :key="category.id"/>
    </ul>

</template>

<script setup>

    import Category from '@/Components/Home/Category.vue'
    import { onMounted, onUnmounted, ref } from 'vue'

    const props = defineProps({
        categories: Array
    })
    
    const notShow = "opacity-0 translate-y-20 pt-20"

    const categoriesList = ref(null)
    const reactiveClasses = ref(notShow)

    const handleScroll = () => {
        if(categoriesList.value){
            const boxPosition = categoriesList.value.getBoundingClientRect().top;
            const windowHeight = window.innerHeight;

            if (boxPosition < windowHeight * 3/5) {
                reactiveClasses.value = null
            } else {
                reactiveClasses.value = notShow
            }
        }
    }

    onMounted(
        ()=>{
            window.addEventListener('scroll', handleScroll);
        }
    )
    onUnmounted(
        ()=>{
            window.removeEventListener('scroll', handleScroll);
        }
    )

</script>