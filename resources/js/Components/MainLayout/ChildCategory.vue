<template>

    <div class="py-1.5 px-4 flex justify-between">
        <Link :href="route('home')" class="hover:underline">
            <i class="fa-solid mr-1 text-sm" :class="category.icon"></i>
            {{ category.name }}
        </Link>
        <button v-if="category.children" @click="toggleChildCategories">
            <i class="fa-solid fa-chevron-down duration-100" :class="showChildCategories ? 'rotate-180' : null"></i>
        </button>
    </div>
    <div v-if="showChildCategories && category.children" class="pl-11">
        <child-category v-for="childCategory in category.children" :category="childCategory" :key="childCategory.id"/>
    </div>

</template>

<script setup>

    import ChildCategory from '@/Components/MainLayout/ChildCategory.vue'
    import { ref } from 'vue'
    import { Link } from '@inertiajs/vue3'

    const props = defineProps({
        category: Object
    })

    const showChildCategories = ref(false);

    const toggleChildCategories = () => {
        showChildCategories.value = !showChildCategories.value
    }

</script>