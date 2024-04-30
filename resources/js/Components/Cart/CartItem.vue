<template>

    <div class="px-8 gap-x-2 flex justify-between rounded-lg relative" style="box-shadow: 0 0 10px lightgray">
        <Link preserve-scroll :href="route('cart.destroy', {cart_item: cartItem.id})" as="button" method="DELETE" class="absolute bottom-4 right-4 text-purple-500 hover:underline">
            remove
        </Link>
        <div class="flex gap-x-12 items-center py-4">
            <div class="h-40 w-40">
                <img :src="cartItem.item.images[0].src" alt="" class="w-full h-full object-cover">
            </div>
            <div class="font-semibold flex flex-col gap-x-2 text">
                <button class="hover:underline text-xl" @click="showItem">{{ cartItem.item.name }}</button>
                <p>
                    <span class="font-normal">size: </span> {{ cartItem.size.name }}
                </p>
                <div class="mt-8 flex gap-x-4">
                    <div class="flex rounded-lg overflow-hidden w-fit shadow-lg text-white">
                        <button @click="increase" class="h-8 w-8 bg-purple-500">+</button> 
                        <input type="number" :min="1" v-model="form.amount" class="text-center h-8 w-12 outline-none px-3 grid place-items-center text-black border-t [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                        <button @click="descrease" class="h-8 w-8 bg-purple-500">-</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="font-semibold text-2xl py-10">
            <p class="text-end">
                {{ price }}$
            </p>
            <p v-if="cartItem.amount > 1" class="font-normal text-sm text-end">
                unit price: {{ cartItem.item.price }}$
            </p>
        </div>
    </div>


</template>

<script setup>

    import { computed, watch, ref } from 'vue'
    import { router, useForm, Link } from '@inertiajs/vue3'
    import debounce from 'lodash/debounce'

    const emit = defineEmits(['hide-cart'])

    const props = defineProps({
        cartItem: Object,
    })

    const form = useForm({
        amount: props.cartItem.amount
    })

    const canSendForm = ref(true);

    const descrease = () => {
        if(form.amount != 1){
            form.amount--
        }
    }

    const increase = () => {
        form.amount++
    }

    const price = computed(
        ()=>props.cartItem.item.price * form.amount
    )

    const showItem = () => {
        emit('hide-cart');
        router.get(route('store.show', {item: props.cartItem.item.id}))
    }

    const sendForm = debounce(()=>{
        form.put(route('cart.update', {cart_item: props.cartItem.id}), {onSuccess: updateForm, preserveScroll: true});
    }, 500)

    const updateForm = () => {
        canSendForm.value = false;
        form.amount = props.cartItem.amount;
        setTimeout(
            ()=>canSendForm.value = true
            ,100
        )
    } 

    watch(()=>form.amount, ()=>{
        if(canSendForm.value){
            sendForm()
        }
    })



</script>