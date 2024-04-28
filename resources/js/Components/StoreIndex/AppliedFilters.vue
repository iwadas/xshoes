<template>

    <ul class="flex gap-2 font-semibold items-cneter">
        <div 
            v-for="category in chosenCategories" 
            class="button-primary-static"
        >
            {{ category.name }}
            <button @click="changeCategory(category.parent_id)" class="mt-1">
                <i class="fa-solid fa-x text-sm"></i>
            </button>
        </div>
        <div 
            v-for="chosenFilter in chosenFiltersShow" 
            class="button-primary-static"
        >
            <button @click="updateFilters(chosenFilter.type, chosenFilter.id)" class="mt-1">
                <i class="fa-solid fa-x text-sm"></i>
            </button>
            {{ chosenFilter.name }}
        </div>
    </ul>

</template>

<script setup>

    import { router } from '@inertiajs/vue3'
    import { computed } from 'vue'
    import { useStore } from 'vuex'

    const props = defineProps({
        chosenCategories: Array,
        filters: Object,
        brands: Object,
        colors: Object,
        sizes: Object,
    })

    const store = useStore();

    const filterTypes = ['brands', 'colors', 'sizes']

    const changeCategory = (parentCategoryId) => {
        if(parentCategoryId){
            router.get(route('store.index', {category: parentCategoryId}))
        } else {
            router.get(route('store.index'));
        }
    }

    const updateFilters = (type, id) => {
        store.commit('updateFilters', {type: type, id: id});
    }

    const chosenFiltersShow = computed(() => {
        let result = []
        
        filterTypes.forEach(type => {
            if(props.filters[type]) {
                result.push(...props.filters[type].map(
                    filterTypeId => ({
                        type: type,
                        id: filterTypeId,
                        name: props[type].filter(filterCategoryElement => filterTypeId == filterCategoryElement.id)[0].name
                    })
                ))
            }
        });
        return result;
    });

    const getArrayOfFiltersApplied = (type, typeCount) => {
        if(!typeCount){
            typeCount = {...props[filterTypesCount[type]]};
        }
        return props.chosenFilters[type].map(typeElementId => ({
            type: type,
            id: typeElementId,
            name: typeCount[Number(typeElementId)] ? typeCount[Number(typeElementId)].name : null
        }));
    }

    // const chosenBrands = computed(
    //     ()=>props.chosenFilters.brands ? props.chosenFilters.brands.map(
    //         brandId => {return {id:brandId, type:'brands', name:props.brandsCount[brandId].name}}
    //     ) : null
    // )


</script>