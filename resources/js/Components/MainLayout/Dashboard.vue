
<template>
    <div>
        <div class="absolute duration-200 right-10 bg-white shadow-lg rounded-lg flex flex-col max-h-[600px]" style="border: solid 3px #a855f7" :class="showDashboard ? 'top-28' : '-top-[1000px]' ">
            <button v-if="role.length" @click="redirectControlPanel" class="py-1.5 px-12 gap-x-2 flex justify-between items-center">
                <i class="fa-solid fa-crown"></i>
                <span class="hover:underline">
                    Panel
                </span>           
             </button>
            <button @click="redirectOrders" class="py-1.5 px-12 gap-x-2 flex justify-between items-center">
                <i class="fa-solid fa-shopping-bag"></i>
                <span class="hover:underline relative">
                    <div v-if="uncompletedOrders" class="absolute -top-1 -right-3 text-[10px] text-purple-500 text-base grid place-items-center rounded-full">
                        <i class="fa-solid fa-circle-exclamation"></i>
                    </div>
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
                        <div v-if="uncompletedOrders" class="absolute -top-1 -right-3 text-[10px] text-purple-500 text-base grid place-items-center rounded-full">
                            <i class="fa-solid fa-circle-exclamation"></i>
                        </div>
                        <i class="fa-solid fa-user text-sm text-purple-500"></i>
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
        role: Array,
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

    const redirectControlPanel = () => {
        hideDashboard()
        router.get(route('control_panel.index'));
    }

    const logout = () => {
        hideDashboard()
        router.delete(route('logout'));
    }


</script>

