<template>
    <div class="col-span-3 px-10 border-r">
        <h2 class="font-semibold text-2xl">
            <i class="fa-solid fa-list text-purple-500 mr-2 text-xl"></i>
            Product list
        </h2>
        <div class="mx-auto w-fit">
            <div v-for="category in categories" class="text-xl p-5">
                <h3>
                    <i class="fa-solid text-lg text-purple-500" :class="category.icon"></i>
                    {{ category.name }}
                </h3>
                <div v-for="childCategory in category.children" :key="childCategory.id" class="ml-8 my-3">
                    <h3>
                        <i class="fa-solid text-lg text-purple-500" :class="childCategory.icon"></i>
                        {{ childCategory.name }}
                    </h3>
                    <div v-for="secondChildCategory in childCategory.children" :key="secondChildCategory.id" class="ml-8 my-3 mb-6">
                        <h3>
                            <i class="fa-solid text-lg text-purple-500" :class="secondChildCategory.icon"></i>
                            {{ secondChildCategory.name }}
                        </h3>
                        <div class="flex flex-col whitespace-nowrap">
                            <button v-for="item in secondChildCategory.items" :key="item.id" @click="updateSelectedItem(item)" class="ml-10 w-fit text-base flex items-center gap-x-2 border px-2 py-1 rounded-lg" :class="selectedItemId == item.id ? 'border-purple-500' : 'border-white'">
                                <div class="w-8 h-8">
                                    <img :src="item.images[0].src" class="w-full h-full object-cover" alt="">
                                </div>
                                <p class="font-semibold">
                                    {{ item.name }}
                                </p>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script setup>

    const props = defineProps({
        categories: Array,
        selectedItemId: Number
    })

    const emit = defineEmits(['update-selected-item'])

    const updateSelectedItem = (item) => {
        emit('update-selected-item', item)
    }

</script>