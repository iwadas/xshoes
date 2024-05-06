<template>

    <div class="sticky h-fit top-40">
        <h1 class="mb-5 text-3xl font-bold flex items-center justify-center">
            <i class="button-special-text mr-2 fa-solid fa-clipboard-list text-2xl"></i>
            Summary
            <br/>
        </h1>
        <div class="flex flex-col gap-y-2">
            <div>
                <p>Subtotal: <span class="font-semibold">{{ subtotal }}$</span></p>
            </div>
            <div>
                <p>Ship: <span class="font-semibold">{{ shippingCost }}$</span></p>
            </div>
            <div v-if="promoCode">
                <p>Discount : <span class="font-semibold text-purple-500">-{{discount}}$</span></p>
            </div>
            <div class="py-4 text-xl border-t border-b">
                <p>Total: <span class="font-bold">{{ total }}$</span></p>
            </div>
            <button @click="checkout" class="button-special-back text-xl">
                Pay
                <div class="button-special-front">
                    <p class="button-special-text text-lg">
                        Complete order
                    </p>
                </div>
            </button>
            <div v-if="error" class="mt-2 text-red-500 font-bold text-2xl">
                <i class="fa-solid fa-triangle-exclamation"></i>
                {{error}}
            </div>
        </div>
    </div>

</template>

<script setup>

    import { computed } from 'vue'

    const props = defineProps({ 
        cartItems: Array,
        promoCode: Object,
        shipping: Object,
        error: String
    })

    const emit = defineEmits(['checkout'])

    const subtotal = computed(()=>{
        let sum = 0;
        props.cartItems.forEach(cartItem => {
            sum += cartItem.amount * cartItem.item.price;
        })
        return sum;
    })

    const shippingCost = computed(
        ()=>props.shipping ? props.shipping.price : 0
    )

    const discount = computed(
        ()=>{
            if(props.promoCode){
                switch(props.promoCode.type){
                    case 'percentage' : {
                        return props.promoCode.discount *  subtotal.value / 100
                    }
                    case 'fixed' : {
                        return props.promoCode.discount
                    }
                }
            } else return 0
        }
    )
    
    const total = computed(
        ()=>subtotal.value - discount.value + shippingCost.value
    )

    const checkout = () => {
        emit('checkout');
    }


</script>