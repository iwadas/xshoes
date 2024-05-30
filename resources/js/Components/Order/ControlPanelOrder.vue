<template>
    
    <div class="flex flex-col rounded-lg pb-1"  style="box-shadow: 0 0 10px lightgray">
        <div class="flex justify-between py-3 px-8">
            <div class="flex flex-col gap-y-1 text-lg">
                <p>user: <span class="font-semibold">{{ order.user.email }}</span></p>
                <p>purchased: <span class="font-semibold">{{ created_at }}</span></p>
                <p>total: <span class="font-semibold">{{ order.payment.price }}$</span></p>
            </div>
            <div class="flex flex-col gap-y-1 text-lg">
                <p>payment: <span class="font-semibold">{{ order.payment.status }}</span></p>
                <p>shipping: <span class="font-semibold">{{ order.shipping.name }}</span></p>
            </div>
        </div>
        <div class="border-b py-2 px-8 text-lg flex justify-between">
            <div>
                address:
            </div>
            <div class="flex justify-between w-2/3 bg-gray-200 px-4 rounded-lg py-3">
                <div class="flex flex-col gap-y-2">
                    <div>
                        name: <span class="font-semibold">{{ order.address.name }}</span>
                    </div>
                    <div>
                        address: <span class="font-semibold">{{ order.address.address }}</span>
                    </div>
                    <div>
                        post code: <span class="font-semibold">{{ order.address.post_code }}</span>
                    </div>
                </div>
                <div class="flex flex-col gap-y-2">
                    <div>
                        surname: <span class="font-semibold">{{ order.address.surname }}</span>
                    </div>
                    <div>
                        phone: <span class="font-semibold">{{ order.address.phone_number }}</span>
                    </div>
                    <div>
                        city: <span class="font-semibold">{{ order.address.city }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-col gap-y-2 px-8">
            <cart-item v-for="cartItem, index in order.cart.cart_items" :cart-item="cartItem" :class="index == order.cart.cart_items.length - 1 ? null : 'border-b'"/>
        </div>
        <form v-if="status != 'shipped'" @submit.prevent="sendForm" class="flex flex-col border-t pt-5 px-8 ">
            <div v-if="form.errors" class="text-center text-red-500 font-bold mb-4">{{ form.errors.url }}</div>
            <div class="flex justify-center gap-x-5 items-center">
                <label for="" class="whitespace-nowrap font-semibold">Tracking url</label>
                <div class="flex justify-center w-2/3">
                    <input type="text" v-model="form.url" class="border w-full rounded-l-lg outline-none px-2 py-1">
                    <button class="button-primary font-semibold" style="border-top-left-radius: 0; border-bottom-left-radius: 0">Save</button>
                </div>
            </div>
        </form>
        <form v-else @submit.prevent="completeOrder" class="flex flex-col border-t pt-5 px-8 ">
            <button class="button-primary font-semibold w-fit mx-auto">Mark as completed</button>
        </form>
    </div>

</template>

<script setup>

    import CartItem from "@/Components/Order/ControlPanelCartItem.vue"
    import { computed } from 'vue'
    import { useForm } from '@inertiajs/vue3'

    const props = defineProps({
        order: Object,
        status: String,
    })

    const form = useForm({
        url: null
    })

    const sendForm = () => {
        form.put(route('control_panel.order.update', {order: props.order.id}));
    }

    const completeOrder = () => {
        form.put(route('control_panel.order.complete', {order: props.order.id}));
    }

    const created_at = computed(
        ()=>new Date(props.order.created_at).toLocaleDateString()
    )

</script>