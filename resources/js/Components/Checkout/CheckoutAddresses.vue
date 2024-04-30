<template>

    <div>
        <h1 class="font-semibold text-2xl mb-8">
            <i class="fa-solid fa-location-dot text-xl mr-1 text-purple-500"></i>
            Address
        </h1>
        <div class="flex flex-col gap-y-3">
            <checkout-address v-for="address in addresses" :address="address" :chosen-address-id="chosenAddressId" :key="address.id" @edit-address="editAddress" @delete-address="deleteAddress" @update-chosen-address="updateChosenAddress"/>
        </div>
        <div v-if="!showForm && addresses.length != 0" class="flex justify-end mt-3">
            <button @click="toggleShowForm('create')" class="ml-auto button-primary font-semibold">Add new</button>
        </div>
        <checkout-address-form v-if="showForm || addresses.length == 0" :fixed-show="addresses.length == 0" class="mt-8" @hide-form="toggleShowForm" :address="selectedAddress"/>
    </div>

</template>


<script setup>

    import CheckoutAddressForm from '@/Components/Checkout/CheckoutAddressForm.vue'
    import CheckoutAddress from '@/Components/Checkout/CheckoutAddress.vue'
    import { ref } from 'vue'
    import { router } from '@inertiajs/vue3'

    const props = defineProps({
        addresses: Array,
        chosenAddressId: Number
    })

    const emit = defineEmits(['address-chosen'])

    const showForm = ref(false);
    const selectedAddress = ref(null)

    const toggleShowForm = (type) => {
        if(type=='create'){
            selectedAddress.value = null;
        }
        showForm.value = !showForm.value;
    }

    const updateChosenAddress = (newChoosenAddressId) => { 
        emit('address-chosen', props.addresses.filter(address => address.id == newChoosenAddressId)[0].id)
    }

    const editAddress = (address) => {
        selectedAddress.value = address;
        toggleShowForm('edit');
    }

    const deleteAddress = (addressId) => {
        if(selectedAddress.value ? selectedAddress.value.id == addressId : false){
            selectedAddress.value = null
        }
        router.delete(route('address.destroy', {address: addressId}))
    }


</script>