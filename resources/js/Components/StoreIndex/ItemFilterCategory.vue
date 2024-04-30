<template>

    <div class="border-t flex flex-col gap-y-3 py-3 px-4">
        <h3 class="font-semibold text-xl">
            <i class="fa-solid text-sm text-purple-500 mr-1" :class="icon"></i>
            {{ header }}
        </h3>
        <div class="flex flex-col gap-y-1">
            <checkbox
                v-for="filterElement in filterCateogryCountReactive"
                :key="Number(filterElement.id)" 
                :label="filterElement.name" 
                :filter-category="filterCategory" 
                :id="Number(filterElement.id)" 
                :count="filterCategory == 'sizes' ? filterElement.available_items_count : filterElement.items_count"
            />
            <button @click="toggleShowAll" v-if="filterCategoryCount.length > 4" class="text-purple-500 text-sm font-semibold underline:hover">
                show 
                <span v-if="showAll">less</span>
                <span v-else>more</span>
                <i class="fa-solid ml-1" :class="showAll ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
            </button>
        </div>
    </div>

</template>

<script setup>

    import Checkbox from '@/Components/StoreIndex/Checkbox.vue'
    import { ref, computed } from 'vue'

    const props = defineProps({
        icon: String,
        header: String,
        filterCategory: String,
        filterCategoryCount: Object,
    })

    const showAll = ref(false);
    const toggleShowAll = () => {
        showAll.value = !showAll.value
    }

    const filterCateogryCountReactive = computed(
        ()=>showAll.value ? props.filterCategoryCount : props.filterCategoryCount.slice(0,4)
    )


</script>