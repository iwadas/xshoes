
<template>
    <div>
        <div class="absolute duration-200 right-10 bg-white shadow-lg rounded-lg flex flex-col max-h-[600px]" style="border: solid 3px #a855f7" :class="showDashboard ? 'top-28' : '-top-[1000px]' ">
            <button @click="redirectOrders" class="py-1.5 px-12 gap-x-2 flex justify-between items-center">
                <i class="fa-solid fa-shopping-bag"></i>
                <span class="hover:underline">
                    Orders
                </span>           
             </button>
            <button @click="logout" class="py-1.5 px-12 gap-x-2 flex justify-between items-center text-red-600">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span class="hover:underline">
                    Logout
                </span>
            </button>
        </div>
        <button
            @click="toggleShowDashboard"
        >
            <div class="button-special-back">
                {{user.name}}
                <div class="button-special-front">
                    <div class="button-special-text-2 relative">
                        <div v-if="uncompletedOrders" class="absolute -top-1 -right-3 text-[10px] h-4 w-4 grid place-items-center rounded-full bg-purple-500 text-white"></div>
                        <i class="fa-solid fa-shopping-cart text-sm text-purple-500"></i>
                        {{user.name}}
                    </div>
                </div>
            </div>
        </button>
    </div>
</template>

<script setup>

    import { router } from '@inertiajs/vue3'

    const emit = defineEmits(['toggle-show-dashboard', 'hide-dashboard'])

    const props = defineProps({
        user: Object,
        showDashboard: Boolean,
        uncompletedOrders: Number
    })

    const toggleShowDashboard = () => {
        console.log('emituje');
        emit('toggle-show-dashboard')
    }
    
    const hideDashboard = () => {
        emit('hide-dashboard')
    }

    const redirectOrders = () => {
        hideDashboard()
        router.get(route('order.index'));
    }

    const logout = () => {
        hideDashboard()
        router.delete(route('logout'));
    }


</script>

