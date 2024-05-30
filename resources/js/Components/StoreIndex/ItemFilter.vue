<template>

    <div>
        <div class="flex justify-between w-3/4 mx-auto px-10">
            <h2 class="font-semibold text-3xl flex justify-center items-center gap-x-2">
                <i class="fa-solid fa-filter text-2xl button-special-text"></i>
                Filters
            </h2>
            <button @click="clearFilters" class="font-semibold text-xl button-primary">
                <i class="fa-solid fa-trash text-sm mt-0.5"></i>
                Clear
            </button>
        </div>
        <div class="flex flex-col gap-y-2 mx-auto my-8 w-2/3">
            <item-categories v-if="subCategories" :sub-categories="subCategories"/>
            <item-filter-category v-if="filtered.brands.length" :filter-category-count="filtered.brands" filter-category="brands" icon="fa-diamond" header="Brands"/>
            <item-filter-category v-if="filtered.colors.length" :filter-category-count="filtered.colors" filter-category="colors" icon="fa-palette" header="Colors"/>
            <item-filter-category v-if="filtered.sizes.filter(el => el.for == 'clothes').length" :filter-category-count="filtered.sizes.filter(el => el.for == 'clothes')" filter-category="sizes" icon="fa-shirt" header="Clothes sizes"/>
            <item-filter-category v-if="filtered.sizes.filter(el => el.for == 'shoes').length" :filter-category-count="filtered.sizes.filter(el => el.for == 'shoes')" filter-category="sizes" icon="fa-socks" header="Shoe sizes"/>
        </div>
    </div>

</template>

<style scoped>

    .checkbox-actual:checked > .checkbox-container {
        background-color: #8b5cf6;
    }

</style>

<script setup>

    import ItemCategories from '@/Components/StoreIndex/ItemCategories.vue'
    import ItemFilterCategory from '@/Components/StoreIndex/ItemFilterCategory.vue'
    import { computed } from 'vue'
    import { useStore } from 'vuex'

    const props = defineProps({
        subCategories: Array,
        brands: Object,
        colors: Object,
        sizes: Object,
        filters: Object,
    })

    const store = useStore();
    const clearFilters = () => {
        store.commit('clearFilters');
    }

    const filtered = computed(
        ()=>{
            let result = {brands: [], colors: [], sizes: []}
            let resultKeys = Object.keys(result);
            resultKeys.forEach(key => {
                if(!props.filters[key]){
                    result[key] = props[key];
                } else {
                    let applied = [];
                    let notApplied = [];
                    props[key].forEach(keyElement => props.filters[key].includes(String(keyElement.id)) ? applied.push(keyElement) : notApplied.push(keyElement))
                    result[key] = [...applied, ...notApplied];
                }
            })
            return result
        }
    )

    // const brandsFiltered = computed(
    //     ()=>{
    //         let applied = [];
    //         let notApplied = [];
    //         props.brands.forEach(brand => props.filters.brands.includes(String(brand.id)) ? applied.push(brand) : notApplied.push(brand))
    //         return [...applied, ...notApplied];
    //     }
    // )

</script>