<template>

    <div class="flex items-center">
        <div class="flex items-center">
            <div class="relative flex items-center gap-x-2 p-2 rounded-full cursor-pointer" htmlFor="checkbox">
                <input type="checkbox"
                    ref="checkboxRef"
                    class="before:content[''] peer relative h-5 w-5 cursor-pointer appearance-none rounded-md border border-blue-gray-200 transition-all before:absolute before:top-2/4 before:left-2/4 before:block before:h-10 before:w-10 before:-translate-y-2/4 before:-translate-x-2/4 before:rounded-full before:bg-blue-gray-500 before:opacity-0 before:transition-opacity bg hover:before:opacity-10"
                    id="checkbox"
                    :class="isChecked ? 'border-purple-500 bg-purple-500 before:bg-purple-500' : isDisabled ? 'border-gray-300 bg-gray-300 before:bg-gray-300' : null"
                    @input="toggleIsChecked"
                    :disabled="isDisabled"
                />
                <span
                    class="absolute transition-opacity pointer-events-none top-2/4 left-2/4 -translate-y-2/4 -translate-x-2/4"
                    :class="isDisabled ? 'text-gray-300' : 'text-white'"
                >
                    <i class="fa-solid fa-check text-xs relative z-20"></i>
                </span>
            </div>
            <div class="mx-2 h-6 w-6 rounded-full" style="box-shadow: 0 0 10px lightgray" v-if="filterCategory == 'colors'" :class="bgColors[label]"></div>
            <label for="" :class="isDisabled ? 'opacity-60' : null">{{ label }}</label> 
        </div>
        <div class="ml-2" v-if="!isDisabled">
            ({{ count }})
        </div>
    </div>


</template>

<script setup>

    import { ref, computed } from 'vue'
    import { useStore } from 'vuex'

    const props = defineProps({
        label: String,
        filterCategory: String,
        id: Number,
        count: Number,
    })

    const bgColors = {
        "black": "bg-black",
        "white": "bg-white",
        "gray": "bg-gray-500",
        "blue": "bg-sky-500",
        "red": "bg-red-600",
        "green": "bg-green-500",
        "purple": "bg-purple-500",
        "pink": "bg-pink-500",
        "dark blue": "bg-blue-900",
        "orange": "bg-orange-500",
        "yellow": "bg-yellow-400"
    }

    const store = useStore()

    const isChecked = ref(store.state.filters[props.filterCategory] ? store.state.filters[props.filterCategory].includes(String(props.id)) : false)
    const checkboxRef = ref(null);
    

    const isDisabled = computed(
        ()=>!isChecked.value &&  props.count == 0
    )

    const toggleIsChecked = () => {
        isChecked.value = !isChecked.value;
        store.commit('updateFilters', {type: props.filterCategory, id: String(props.id)});
    }


</script>