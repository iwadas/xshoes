<template>
    
    <div class="mt-20">
        <h1 class="mb-10 text-5xl font-bold flex items-center justify-center">
            <i class="button-special-text mr-2 fa-solid fa-gear text-4xl"></i>
                Manage items
            <br/>
        </h1>
        <div class="grid grid-cols-10 gap-3 mx-6">
            <current-items :categories="categories" :selected-item-id="selectedItem ? selectedItem.id : null" class="col-span-3 px-10 border-r" @update-selected-item="updateSelectedItem"/>
            <item-form :item="selectedItem" :colors="colors" :categories="categories" :sizes="sizes" :brands="brands" @creating-new="deselectItem()"/>
        </div>
    </div>

</template>

<script setup>

    import ItemForm from '@/Components/ControlPanelItem/ItemForm.vue';
    import CurrentItems from '@/Components/ControlPanelItem/CurrentItems.vue';
    import { ref, computed } from 'vue'

    const props = defineProps({
        categories: Array,
        sizes: Array,
        colors: Array,
        brands: Array,
        updatedItem: Object,
    })

    const selectedItem = ref(props.updatedItem)

    const updateSelectedItem = (item) => {
        selectedItem.value = item
    }
    
    const deselectItem = () => {
        selectedItem.value = null
    }


</script>