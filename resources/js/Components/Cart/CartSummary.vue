<template>

    <div class="sticky top-40 h-fit">
        <h1 class="mb-5 text-3xl font-bold flex items-center justify-center">
            <i class="button-special-text mr-2 fa-solid fa-clipboard-list text-2xl"></i>
            Summary
            <br/>
        </h1>
        <div class="flex flex-col gap-y-2">
            <promo-code @code-approved="applyPromoCode" @check-code="checkCode" :promo-code="promoCodeRef" :success="successRef" :error="errorRef"/>
            <div>
                <p>Subtotal: <span class="font-semibold">{{ subtotal }}$</span></p>
            </div>
            <div v-if="promoCodeRef">
                <p>Discount : <span class="font-semibold text-purple-500">-{{discount}}$</span></p>
            </div>
            <div class="py-4 text-xl border-t border-b">
                <p>Total: <span class="font-bold">{{ total }}$</span></p>
            </div>
            <button @click="checkout" class="button-special-back text-xl">
                Checkout
                <div class="button-special-front">
                    <p class="button-special-text text-lg">
                        Checkout
                    </p>
                </div>
            </button>
        </div>
    </div>

</template>

<script setup>

    import PromoCode from '@/Components/Cart/PromoCode.vue'
    import axios from 'axios'
    import { ref, computed } from 'vue'
    import { router } from '@inertiajs/vue3'

    const props = defineProps({ 
        cartItems: Array,
        promoCode: Object,
        ship: Number,
    })

    const successRef =  ref(null);
    const errorRef =  ref(null);
    const promoCodeRef = ref(props.promoCode);

    const subtotal = computed(()=>{
        let sum = 0;
        if(!props.cartItems){
            return 0;
        }
        props.cartItems.forEach(cartItem => {
            sum += cartItem.amount * cartItem.item.price;
        })
        return sum;
    })

    const discount = computed(
        ()=>{
            if(promoCodeRef.value){
                switch(promoCodeRef.value.type){
                    case 'percentage' : {
                        return promoCodeRef.value.discount *  subtotal.value / 100
                    }
                    case 'fixed' : {
                        return promoCodeRef.value.discount
                    }
                }
            } else return 0;
        }
    )
    
    const total = computed(
        ()=>subtotal.value - discount.value
    )

    const checkout = () => {
        if(props.cartItems.length){
            router.get(route('checkout.index'));
        }
    }
        
    const applyPromoCode = (info) => {
        console.log(info);
    }

    const checkCode = (promoCodeInput) => {
        axios.post(route('promo_code.verify', {promo_code_name: promoCodeInput}))
            .then(e => {
                successRef.value = e.data;
                promoCodeRef.value = e.data.promo_code;
            })
            .catch(e => {
                errorRef.value = e.response.data
            })
    }


</script>