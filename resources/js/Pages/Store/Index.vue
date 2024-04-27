<template>
    
    <div class="mt-20">
        <h1 class="mb-10 text-5xl font-bold flex items-center justify-center">
            <i class="button-special-text mr-2 fa-solid fa-store text-4xl"></i>
            Store
            <br/>
        </h1>
        <div class="grid grid-cols-10 gap-3 mx-6">
            <item-filter 
                :sub-categories="subCategories"
                :filters="filters" 
                :brands="brands"
                :colors="colors"
                :sizes="sizes"
                class="flex flex-col col-span-3 pr-4 border-r"
            />
            <div class="flex flex-col gap-y-5 col-span-7">
                <applied-filters 
                    :chosen-categories="chosenCategories" 
                    :filters="filters" 
                    :brands="brands"
                    :sizes="sizes"
                    :colors="colors"
                />
                <div class="grid grid-cols-3 gap-4">
                    <item v-for="item in items" :item="item" :key="item.id"/>
                </div>
            </div>
        </div>
    </div>

</template>

<script setup>

    import Item from "@/Components/Store/Item.vue";
    import ItemFilter from '@/Components/Store/ItemFilter.vue';
    import AppliedFilters from '@/Components/Store/AppliedFilters.vue'
    import { onMounted, watch, computed, reactive, onBeforeMount} from 'vue'
    import { useStore } from 'vuex'
    import debounce from 'lodash/debounce'
    import { router } from '@inertiajs/vue3'

    const props = defineProps({
        chosenCategories: Array,
        items: Array,
        filters: Object,
        brands: Object,
        colors: Object,
        sizes: Object,
        subCategories: Array,
    })

    const store = useStore();

    const storeFilters = computed(
        ()=>store.state.filters
    )

    const sendFilterRequest = debounce(
        ()=>router.get(route('store.index'), storeFilters.value, {preserveScroll: true}), 750
    )

    onBeforeMount(
        ()=>store.commit('setFilters', props.filters)
    )

    onMounted(
        ()=>{
            watch(storeFilters.value, () => sendFilterRequest())
        }
    )

</script>