<template>
    <div>
        <div class="absolute duration-200 bg-white shadow-lg rounded-lg flex flex-col min-w-64" style="border: solid 3px #a855f7" :class="showChildCategories ? 'top-28' : '-top-96' ">
            <child-category v-for="childCategory in category.children" :category="childCategory" :key="childCategory.id" @toggle-show-category="toggleChildCategories"/>
        </div>
        <button
            @click="toggleChildCategories"
        >
            <div class="button-special-back">
                {{ name }}
                <div class="button-special-front">
                    <div class="button-special-text-2">
                        <i class="fa-solid text-sm text-purple-500" :class="category.icon"></i>
                        {{ name }}
                    </div>
                </div>
            </div>
        </button>
    </div>
</template>

<script setup>

    import { Link } from '@inertiajs/vue3'
    import { computed, ref } from 'vue'
    import ChildCategory from '@/Components/MainLayout/ChildCategory.vue';

    const props = defineProps({
        category: Object,
        showCategoryId: Number
    })

    const emit = defineEmits(['toggleShowCategory']);

    const showChildCategories = computed(
        ()=>props.showCategoryId == props.category.id
    );

    const toggleChildCategories = () => {
        console.log(props.category.id)
        emit('toggleShowCategory', props.category.id)
    }


    const name = computed(
        ()=>props.category.name.charAt(0).toUpperCase() + props.category.name.slice(1)
    )

</script>

