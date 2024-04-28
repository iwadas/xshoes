<template>


    <div class="flex gap-x-4">
        <div class="relative">
            <div class="flex flex-col gap-y-5 items-center overflow-x-auto py-5 -my-5 w-36 h-[840px] max-h-[840px] hide-scrollbar relative">
                <div v-for="image in images" :key="image.id" class="rounded-md overflow-hidden w-32 h-32 min-h-32" style="box-shadow: 0 0 10px lightgray">
                    <a :id="image.id" :href="image.src" data-fancybox="gallery" class="w-32 h-32">
                        <img :src="image.src" class="w-32 h-32 object-contain"/>
                    </a>
                </div>
            </div>
            <div class="absolute -top-6 w-full left-0 h-8 bg-gradient-to-t from-transparent to-white"></div>
            <div class="absolute -bottom-6 w-full left-0 h-8 bg-gradient-to-b from-transparent to-white"></div>
        </div>
        <a :id="selectedPicture.id" :href="selectedPicture.src" data-fancybox-trigger="gallery" class="flex-1 h-[800] rounded-lg overflow-hidden" style="box-shadow: 0 0 15px lightgray">
            <img :src="selectedPicture.src" class="w-full h-full object-contain"/>
        </a>
    </div>
</template>

<script>

</script>


<script setup>

    import { Fancybox } from "@fancyapps/ui";
    import "@fancyapps/ui/dist/fancybox/fancybox.css";
    import { ref, onMounted } from 'vue'

    const props = defineProps({
        images: Array
    })

    const selectedPicture = ref(
        props.images.filter(img => img.main)[0]
    )

    onMounted(
        ()=>{
            Fancybox.bind('[data-fancybox="gallery"]', {
                Toolbar: {
                    display: {
                    left: [],
                    left: ["prev", "infobar", "next"],
                    right: ["close"],
                    },
                },
            });
        }
    )

</script>