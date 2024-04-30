<template>

    <div class="">
        <div v-if="!promoCode" class="flex justify-between items-center">
            <div>Have promo code?</div>
            <button @click="togglePromoInput">
                <i class="fa-solid fa-chevron-down duration-100" :class="showPromoInput ? 'rotate-180' : null"></i>
            </button>
        </div>
        <div v-else>
            <div class="flex justify-between items-center">
                <div>Promo code: <span class="text-purple-500 font-semibold">{{ promoCode.name }}</span></div>
                <button @click="togglePromoInput">
                    <i class="fa-solid fa-pen duration-100"></i>
                </button>
            </div>
        </div>
        <div v-if="showPromoInput">
            <div class="flex mt-2">
                <input v-model="promoCodeInput" type="text" class="outline-none border rounded-l-md px-3 py-1 border-r-0  w-full">
                <button @click="checkCode" class="text-white bg-purple-500 px-4 rounded-r-md">Apply</button>
                <div v-if="error"></div>
            </div>
            <div v-if="error" class="text-red-500 font-semibold mt-2">
                <i class="fa-solid fa-triangle-exclamation mr-1">
                </i>
                {{ error.error }}
            </div>
            <div v-if="success" class="text-purple-500 font-semibold mt-2">
                <i class="fa-solid fa-circle-check mr-1"></i>
                {{ success.success }}
            </div>
        </div>
    </div>

</template>

<script setup>

    import { ref } from 'vue'


    const props = defineProps({
        promoCode: Object,
        error: Object,
        success: Object,
    })

    const emit = defineEmits(['check-code'])
    const promoCodeInput = ref(props.promoCode ? props.promoCode.name : null);
    const showPromoInput = ref(false);


    const togglePromoInput = () => {
        showPromoInput.value = !showPromoInput.value
    }

    const checkCode = () => {
        emit('check-code', promoCodeInput.value)
    }

</script>