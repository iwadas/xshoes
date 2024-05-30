<template>

    <div class="py-1.5 px-4 flex justify-between">
        <button @click="redirectCategory" class="hover:underline">
            <i class="fa-solid mr-1 text-sm" :class="category.icon"></i>
            {{ category.name }}
        </button>
        <button v-if="category.children" @click="toggleChildCategories">
            <i class="fa-solid fa-chevron-down duration-100" :class="showChildCategories ? 'rotate-180' : null"></i>
        </button>
    </div>
    <div v-if="showChildCategories && category.children" class="pl-11">
        <child-category v-for="childCategory in category.children" :category="childCategory" :key="childCategory.id" @toggle-show-category="emit('toggle-show-category')"/>
    </div>

</template>

<script setup>

    import ChildCategory from '@/Components/MainLayout/ChildCategory.vue'
    import { ref } from 'vue'
    import { router } from '@inertiajs/vue3'

    const props = defineProps({
        category: Object
    })

    const emit = defineEmits(['toggle-show-category']);

    const showChildCategories = ref(false);

    const redirectCategory = () => {
        emit('toggle-show-category');
        router.get(route('store.index', {category: props.category.id}));
    }

    const toggleChildCategories = () => {
        showChildCategories.value = !showChildCategories.value
    }

</script>