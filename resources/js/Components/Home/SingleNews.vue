<template>

    <div class="duration-1000 rounded-lg absolute h-fit" style="width: 28vw" :style="customStyle">
        <div class="grid place-items-center rounded-lg overflow-hidden w-full relative" style="height: 28vw;">
            <div class="absolute top-1/2 -translate-x-1/2 left-1/2 -translate-y-1/2 mt-0.5 ml-0.5 font-teko text-white text-5xl font-bold whitespace-nowrap">
                {{ news.header }}
            </div>
            <div class="absolute top-1/2 -translate-x-1/2 left-1/2 -translate-y-1/2 font-teko text-5xl font-bold whitespace-nowrap" :style="'color: ' + news.color">
                {{ news.header }}
            </div>
            <img :src="news.src" class="w-full h-full object-cover">
        </div>
    </div>

</template>

<script setup> 

    import { computed } from 'vue'    

    const props = defineProps({
        index: Number,
        news: Object,
    })

    const customStyle = computed(
        ()=>{
            switch(props.index){
                case 0:
                    return 'left: 0';
                case 1:
                    return 'left: calc(50% - 14vw);';
                case 2: 
                    return 'left: calc(100% - 28vw)';
                case 3:
                    return 'left: calc(100% - 28vw); transform:translateX(500px); opacity: 0';
                default:
                    return 'left: 0; transform:translateX(-800px); opacity: 0';
            }
        }
    )


</script>