<template>

    <div>
        <div class="rounded border-2 shadow-sm py-2 px-3">
            <div class="flex justify-between items-center">
                <div class="inline">
                    <Link :href="route('store.index', {category: subCategory.id})">
                        <i class="fa-solid pr-2" :class="subCategory.icon"></i>
                        <p class="hover:underline inline">
                            {{ subCategory.name }}
                        </p>
                    </Link>
                    <p class="inline ml-1">
                        ({{ subCategory.items_count }})
                    </p>
                </div>
                <button v-if="subCategory.children ? subCategory.children.length: false" @click="toggleShowSubCategoryChildren">
                    <i class="fa-solid fa-chevron-down duration-100" :class="showSubCategoryChildren ? 'rotate-180' : null"></i>
                </button>
            </div>
        </div>
        <item-category v-if="showSubCategoryChildren" v-for="subCategoryChild in subCategory.children" :key="subCategory.id" :sub-category="subCategoryChild" class="translate-x-2"/>
    </div>


</template>

<script setup>

    import ItemCategory from '@/Components/Store/ItemCategory.vue'
    import { ref } from 'vue'
    import { Link } from '@inertiajs/vue3'

    const props = defineProps({
        subCategory: Object
    })

    const showSubCategoryChildren = ref(false);

    const toggleShowSubCategoryChildren = () => {
        showSubCategoryChildren.value = !showSubCategoryChildren.value;
    }

</script>