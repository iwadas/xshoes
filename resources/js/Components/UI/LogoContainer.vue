<template>
    <div class="absolute top-1/2 left-1/2 w-1/2 -translate-x-1/2 -translate-y-1/2 x-container overflow-hidden" style="height: 750px; width: 750px" ref="xContainer">
        <img 
            src="\storage\app\public\default\logo.png" 
            class="h-full w-full object-cover"
        >
        <img 
            v-if="white"
            v-for="n in 10"
            :key="n"
            :id="`x${n}`"
            src='/storage/app/public/default/logo_white.png'
            class="absolute duration-500"
        >
        <img 
            v-if="!white"
            v-for="n in 10"
            :key="n"
            :id="`x${n}`"
            src='/storage/app/public/default/logo_black.png'
            class="absolute duration-500"
        >
    </div>
</template>

<style scope>
    .x-container :nth-child(2n) {
        left: 250vw;
    }
    .x-container :nth-child(2n+1) {
        left: -250vw
    }

    @keyframes opacity {
        0%{
            opacity: 0;
        }
        100%{
            opacity: 1
        }
    }

</style>


<script setup>

    import { Link } from '@inertiajs/vue3'
    import { ref, onMounted, onBeforeUnmount } from 'vue'

    const xContainer = ref(null);

    defineProps({
        white: Boolean
    })

    let lastlyUpdated = [];
    let available = ["x1","x2","x3","x4","x5","x6","x7","x8","x9","x10"];
    const elementsId = ["x1","x2","x3","x4","x5","x6","x7","x8","x9","x10"];
    let xPositions = {"x1": {height: 0, left: 1000, top: 1000},
                      "x2": {height: 0, left: 1000, top: 1000},
                      "x3": {height: 0, left: 1000, top: 1000},
                      "x4": {height: 0, left: 1000, top: 1000},
                      "x5": {height: 0, left: 1000, top: 1000},
                      "x6": {height: 0, left: 1000, top: 1000},
                      "x7": {height: 0, left: 1000, top: 1000},
                      "x8": {height: 0, left: 1000, top: 1000},
                      "x9": {height: 0, left: 1000, top: 1000},
                      "x10": {height: 0, left: 1000, top: 1000}}

    const updateXParameters = () => {
        let index = Math.floor(Math.random()*available.length);
        let elementId = available[index]
        available.splice(index, 1);
        lastlyUpdated.push(elementId);
        if(lastlyUpdated[4]){
            available.unshift(lastlyUpdated[4])
            lastlyUpdated.pop();
        }
        lastlyUpdated.unshift(elementId);
        let element = document.getElementById(elementId)
        if(element){
            element.classList.remove('popping-animation')
            element.classList.add('popping-animation')
            let params = getRandomXParamteres();
            xPositions[elementId] = params;

            element.style.height = params.height + "px";
            element.style.left = params.left + "px"
            element.style.top = params.top + "px"
        }
            
    }

    const getRandomXParamteres = () => {

        let height = (Math.floor(Math.random() * 150) + 20);
        let top = 0;
        let left = 0;
        let i = 0;
        do{
            left = Math.max(0, Math.floor(Math.random() * 750 - height))
            top = Math.max(0,Math.floor(Math.random() * 750 - height ))
            i++;
        }
        while((elementsId.filter(elementId => 
                (Math.abs(xPositions[elementId].left - left) <= Math.max(xPositions[elementId].height, height)) && (Math.abs(xPositions[elementId].top - top) <= Math.max(xPositions[elementId].height, height))
            ).length != 0) && i<10)
        
        i == 20 ? height = 5 : null;
        return {
            top: top,
            left: left,
            height: height,
        }
    }

    let inerval;

    onMounted(
        ()=>{
            inerval = setInterval(updateXParameters, 900);
        }
    )

    onBeforeUnmount(
        ()=>{
            clearInterval(inerval)
        }
    )


</script>