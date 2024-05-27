<template>
    <td class="relative">
        <div v-if="!showForm">
            {{ fixedLabel }}
            <button @click="toggleForm" class="absolute right-1 top-1 text-xs">
                <i class="fa-solid fa-pen-to-square"></i>
            </button>
        </div>
        <div v-else class="flex justify-between gap-x-2 items-center h-5">
            <input class="text-sm h-5 px-1 outline-none rounded-sm border-none"  :type="inputTypes[label]" v-model="input" v-if="label != 'type'">
            <select v-else v-model="input">
                <option value="percentage">%</option>
                <option value="fixed">$</option>
            </select>
            <div class="flex gap-x-1">
                <button @click="sendForm" class="bg-purple-500 rounded h-5 w-5 text-white text-sm"><i class="fa-solid fa-check text-white text-sm"></i></button>
                <button @click="toggleForm" class="bg-purple-500 rounded h-5 w-5"><i class="fa-solid fa-x text-white text-sm"></i></button>
            </div>
        </div>
    </td>
</template>

<script setup>

    import { ref, computed } from 'vue'
    import { router } from '@inertiajs/vue3'

    const props = defineProps({
        label: String,
        promoCode: Object,
    })

    const inputTypes = {
        name: 'text',
        discount: 'number',
        available_till: 'date',
        price_from: 'number',
        for_new_users: 'checkbox'
    }

    const fixedLabel = computed(()=>{
        let value = props.promoCode[props.label];
        switch(props.label){
            case 'price_from':
                return value + "$"
            case 'available_till':
                return new Date(value).toLocaleDateString()
            case 'type':
                return value == 'percentage' ? '%' : '$'
            case 'for_new_users':
                return value == 1 ? "true" : "false";
            default:
                return value;

        }
    })

    const showForm = ref(false)
    const input = ref(props.promoCode[props.label])

    const toggleForm = () => {
        showForm.value = !showForm.value
    }

    const sendForm = () => {
        let query = {label: props.label};
        query[props.label] = input.value;
        router.put(route('control_panel.promo_code.update', {promo_code: props.promoCode.id}), query, {onSuccess: toggleForm})
    }



</script>