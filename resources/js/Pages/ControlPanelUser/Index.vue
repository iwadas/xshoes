<template>

    <div class="mt-20">
        <h1 class="mb-10 text-5xl font-bold flex items-center justify-center">
            <i class="button-special-text mr-2 fa-solid fa-user-group text-4xl"></i>
                User List
            <br/>
        </h1>
        <form @submit.prevent="sendForm" class="mx-auto w-1/2">
            <div class="h-10 flex w-full">
                <div class="relative w-full">
                    <input type="text" class="border px-4 h-full rounded-l-lg outline-none pr-8 w-full" placeholder="Search..." v-model="form.search">
                    <button type="button" class="absolute top-1/2 -translate-y-1/2 right-2" @click="clearForm">
                        <i class="fa-solid fa-x text-xs"></i>
                    </button>
                </div>
                <button type="submit" class="h-full min-w-10 bg-purple-500 rounded-r-lg">
                    <i class="fa-solid fa-magnifying-glass text-white"></i>
                </button>
            </div>
        </form>
        <div class="mx-10 gap-10">
            <table class="rounded-lg overflow-hidden mx-auto" style="box-shadow: 0 0 10px lightgray">
                <tr style="box-shadow: 0 0 10px lightgray">
                    <th class="py-4 px-20 text-xl border-r">
                        Id
                    </th>
                    <th class="py-4 px-20 text-xl border-r">
                        Name
                    </th>
                    <th class="py-4 px-5 text-xl border-r">
                        Email
                    </th>
                    <th class="py-4 px-5 text-xl border-r">
                        Roles
                    </th>
                    <th class="py-4 px-5 text-xl border-r">
                        Actions
                    </th>
                </tr>
                <tr v-for="user in users.data" :key="user.id" class="lower-tr text-center">
                    <td>{{ user.id }}</td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>
                        <div v-if="user.roles.length || user.deleted_at" class="flex gap-x-2 justify-center text-black">
                            <p v-for="role in user.roles">
                                <i class="fa-solid" :class="roleIcons[role.name]"></i>
                            </p>
                            <p v-if="user.deleted_at">
                                <i class="fa-solid fa-ban text-red-500"></i>
                            </p>
                        </div>
                        <div v-else class="opacity-50">
                            none
                        </div>
                    </td>
                    <td class="flex gap-x-1">
                        <Link preserve-scroll :href="route('control_panel.user.update', {user: user.id})" as="button" method="PUT" class="button-primary font-semibold" v-if="!user.roles.length && isAdmin">Promote</Link>
                        <Link preserve-scroll :href="route('control_panel.user.destroy', {user: user.id})" as="button" method="DELETE" class="button-primary font-semibold" v-if="(isAdmin || !user.roles.length) && !user.deleted_at">Ban</Link>
                        <Link preserve-scroll :href="route('control_panel.user.restore', {user: user.id})" as="button" method="PUT" class="button-primary font-semibold" v-if="user.deleted_at">Unban</Link>
                    </td>
                </tr>
            </table>
        </div>
        <div class="flex items-center py-10">
            <pagination :links="users.links"/>
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
        padding: 10px 40px;
    }
</style>

<script setup>
    
    import Pagination from '@/Components/UX/Pagination.vue';
    import { useForm, Link, usePage } from '@inertiajs/vue3'
    import { computed } from 'vue'

    const roleIcons = {
        'admin' : 'fa-crown',
        'moderator' : 'fa-gear',
    }

    const props = defineProps({
        users: Object,
        search: String,
    })

    const page = usePage();
    
    const isAdmin = computed(
        ()=> page.props.role.filter(role => role.name == 'admin').length
    )

    const form = useForm({
        search: props.search
    })

    const sendForm = () => {
        form.get(route('control_panel.user.index'));
    }

    const clearForm = () => {
        form.search = null;
        sendForm();
    }


</script>