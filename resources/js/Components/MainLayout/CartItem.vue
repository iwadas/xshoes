<template>

    <div class="py-2 px-4 gap-x-2 flex justify-between items-center">
        <div class="h-24 w-24">
            <img :src="cartItem.item.images[0].src" alt="" class="w-full h-full object-cover">
        </div>
        <div class="font-semibold flex flex-col gap-x-2">
            <p>
                {{ cartItem.amount }} x <button class="hover:underline" @click="showItem">{{ cartItem.item.name }}</button>
            </p>    
            <p>
                <span class="font-normal">size: </span> {{ cartItem.size.name }}
            </p>    
        </div>
        <div class="font-semibold text-2xl ml-4">
            <p class="text-end">
                {{ price }}$
            </p>
            <p v-if="cartItem.amount > 1" class="font-normal text-base text-end">
                unit price: {{ cartItem.item.price }}$
            </p>
        </div>
    </div>


</template>

<script setup>

    import { computed } from 'vue'
    import { router } from '@inertiajs/vue3'

    const emit = defineEmits(['hide-cart'])

    const props = defineProps({
        cartItem: Object,
    })

    const price = computed(
        ()=>props.cartItem.item.price * props.cartItem.amount
    )

    const showItem = () => {
        emit('hide-cart');
        router.get(route('store.show', {item: props.cartItem.item.id}))
    }

</script>