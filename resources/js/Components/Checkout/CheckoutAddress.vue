<template>

    <div class="relative">
        <button @click="updateChosenAddress" class="py-2 px-4 rounded-lg flex flex-col relative border-[3px] w-full duration-100" style="box-shadow: 0 0 10px lightgray" :class="isChosen ? 'border-purple-500 bg-white' : 'border-transparent'">
            <div>
                {{ address.name }} {{ address.surname }}
            </div>
            <div>
                {{ address.address }}
            </div>
            <div>
                {{ address.city }} {{ address.post_code }}
            </div>
            <div>
                {{ address.phone_number }}
            </div>
        </button>
        <div class="absolute top-3 right-4 font-semibold flex gap-x-5">
            <button class="hover:underline" @click="editAddress">
                <i class="fa-solid fa-pen text-sm"></i>
                Edit
            </button>
            <button @click="deleteAddress" class="hover:underline">
                <i class="fa-solid fa-trash text-sm"></i>
                Delete
            </button>
        </div>
    </div>


</template>

<script setup>

    import { computed } from 'vue'

    const emit = defineEmits(['edit-address', 'delete-address', 'update-chosen-address'])

    const props = defineProps({
        address: Object,
        chosenAddressId: Number
    })

    const editAddress = () => {
        emit('edit-address', props.address);
    }

    const deleteAddress = () => {
        emit('delete-address', props.address.id);
    }

    const updateChosenAddress = () => { 
        emit('update-chosen-address', props.address.id);
    }

    const isChosen = computed(
        ()=>props.chosenAddressId == props.address.id
    )

</script>