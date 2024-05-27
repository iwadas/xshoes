<template>
    
    <div class="mt-20">
        <h1 class="mb-10 text-5xl font-bold flex items-center justify-center">
            <i class="button-special-text mr-3 fa-solid fa-tag text-4xl"></i>
            Promo codes
        </h1>
        <div v-if="(errors ? Object.keys(errors).length : false) && showErrors" class=" border-red-500 border-[3px] rounded-lg shadow-lg text-red-500 font-bold w-fit fixed bg-white top-40 left-1/2 -translate-x-1/2">
            <div class="relative px-10 flex flex-col py-3">
                <div v-for="error in Object.values(errors)">
                    {{ error }}
                </div>
                <button class="absolute top-2 right-2 h-5 w-5 grid place-items-center rounded border-red-500 border-[3px]" @click="showErrors = false">
                    <i class="fa-solid fa-x text-red-500 text-xs"></i>
                </button>
            </div>
        </div>
        <Link :href="route('control_panel.promo_code.create')" class="button-primary w-fit mx-auto text-xl font-semibold mt-10">
            <i class="fa-solid fa-circle-plus"></i>
            Create new
        </Link>
        <div class="flex flex-col w-fit mx-auto">
            <h2 class="font-semibold text-xl mb-4">
                <i class="fa-solid fa-stopwatch text-purple-500 text-lg mr-1"></i>
                Active 
            </h2>
            <table v-if="promoCodes.active.length" class="text-center rounded-lg overflow-hidden w-fit" style="box-shadow: 0 0 10px lightgray">
                <tr style="box-shadow: 0 0 10px lightgray">
                    <th class="py-4 px-20 text-xl border-r">
                        Name
                    </th>
                    <th class="py-4 px-5 text-xl border-r">
                        Amount
                    </th>
                    <th class="py-4 px-5 text-xl border-r">
                        Type
                    </th>
                    <th class="py-4 px-5 text-xl border-r">
                        Valid till
                    </th>
                    <th class="py-4 px-5 text-xl border-r">
                        Price from
                    </th>
                    <th class="py-4 px-5 text-xl border-r">
                        Only for new users
                    </th>
                </tr>
                <tr v-for="promoCode in promoCodes.active" :key="promoCode.id" class="lower-tr">
                    <column-form :promoCode="promoCode" label="name"/>
                    <column-form :promoCode="promoCode" label="discount"/>
                    <column-form :promoCode="promoCode" label="type"/>
                    <column-form :promoCode="promoCode" label="available_till"/>
                    <column-form :promoCode="promoCode" label="price_from"/>
                    <column-form :promoCode="promoCode" label="for_new_users"/>
                </tr>
            </table>
            <div v-else class="text-center text-2xl opacity-50">
                List is empty 😓
            </div>
            <h2 class="font-semibold text-xl mb-4 mt-10">
                <i class="fa-solid fa-bed text-purple-500 text-lg mr-1"></i>
                Inactive
            </h2>
            <table v-if="promoCodes.inactive.length" class="text-center rounded-lg overflow-hidden w-fit" style="box-shadow: 0 0 10px lightgray">
                <tr style="box-shadow: 0 0 10px lightgray">
                    <th class="py-4 px-20 text-xl border-r">
                        Name
                    </th>
                    <th class="py-4 px-5 text-xl border-r">
                        Amount
                    </th>
                    <th class="py-4 px-5 text-xl border-r">
                        Type
                    </th>
                    <th class="py-4 px-5 text-xl border-r">
                        Valid till
                    </th>
                    <th class="py-4 px-5 text-xl border-r">
                        Price from
                    </th>
                    <th class="py-4 px-5 text-xl border-r">
                        Only for new users
                    </th>
                </tr>
                <tr v-for="promoCode in promoCodes.inactive" :key="promoCode.id" class="lower-tr">
                    <column-form :promoCode="promoCode" label="name"/>
                    <column-form :promoCode="promoCode" label="discount"/>
                    <column-form :promoCode="promoCode" label="type"/>
                    <column-form :promoCode="promoCode" label="available_till"/>
                    <column-form :promoCode="promoCode" label="price_from"/>
                    <column-form :promoCode="promoCode" label="for_new_users"/>
                </tr>
            </table>
            <div v-else class="text-center text-2xl opacity-50">
                List is empty 😓
            </div>
        </div>
    </div>
</template>

<style scoped>

    .lower-tr:nth-child(2n){
        background-color: #e9d5ff
    }
    .lower-tr:nth-child(2n + 1){
        background-color: #f9fafb
    }
    td{
        padding: 10px 0px;
    }


</style>

<script setup>

    import ColumnForm from '@/Components/ControlPanelPromoCode/ColumnForm.vue'
    import { ref, watch } from 'vue'
    import { Link } from '@inertiajs/vue3'

    const props = defineProps({
        promoCodes: Object,
        errors: Object
    })

    const showErrors = ref(true);

    watch(()=>props.errors, ()=>{
        showErrors.value = true
    })


</script>