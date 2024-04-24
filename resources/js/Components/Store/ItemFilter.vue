<template>

    <div>
        <div class="flex justify-between w-3/4 mx-auto px-10">
            <h2 class="font-semibold text-3xl flex justify-center items-center gap-x-2">
                <i class="fa-solid fa-filter text-2xl button-special-text"></i>
                Filters
            </h2>
            <p class="font-semibold text-xl button-primary">
                <i class="fa-solid fa-trash text-sm mt-0.5"></i>
                Clear
            </p>
        </div>
        <div class="flex flex-col gap-y-2 mx-auto my-8 w-2/3">
            <div class="border-t flex flex-col gap-y-3 py-3 px-4">
                <h3 class="font-bold text-xl">
                    <i class="fa-solid fa-icons text-sm text-purple-500"></i>
                    Category
                </h3>
                <div class="flex items-center">
                    <!-- <div class="relative flex items-center gap-x-2 p-3 rounded-full cursor-pointer" htmlFor="checkbox">
                        <input type="checkbox"
                            class="before:content[''] peer relative h-5 w-5 cursor-pointer appearance-none rounded-md border border-blue-gray-200 transition-all before:absolute before:top-2/4 before:left-2/4 before:block before:h-12 before:w-12 before:-translate-y-2/4 before:-translate-x-2/4 before:rounded-full before:bg-blue-gray-500 before:opacity-0 before:transition-opacity checked:border-purple-500 checked:bg-purple-500 checked:before:bg-purple-500 hover:before:opacity-10"
                            id="checkbox" checked />
                        <span
                            class="absolute text-white transition-opacity opacity-0 pointer-events-none top-2/4 left-2/4 -translate-y-2/4 -translate-x-2/4 peer-checked:opacity-100">
                            <i class="fa-solid fa-check"></i>
                        </span>
                    </div>
                    <label for="">Siemano</label> -->
                </div> 
            </div>
        </div>
    </div>

</template>

<style scoped>

    .checkbox-actual:checked > .checkbox-container {
        background-color: #8b5cf6;
    }

</style>

<script setup>

    const props = defineProps({
        subCategories: Array
    })

</script>