<template>

    <div class="mt-20">
        <h1 class="mb-10 text-5xl font-bold flex items-center justify-center">
            <i class="button-special-text mr-2 fa-solid fa-crown text-4xl"></i>
            Control Panel
            <br/>
        </h1>

        <div class="grid grid-cols-10 mx-10 gap-10">
            <Link :href="route('control_panel.order.index')" class="bg-black relative col-span-3 row-span-5 grid place-items-center text-8xl font-bold rounded-xl h-[50vh] overflow-hidden hover:-translate-y-1 duration-200" style="box-shadow: 0 0 20px lightgray">
                <div class="opacity-40 absolute top-0 left-0 w-full h-full">
                    <img src="/public/images/control_panel/orders.jpg" class="object-cover w-full h-full" alt="" loading="lazy">
                </div>
                <p class="relative text-white" style="text-shadow: 0 0 20px black">
                    Orders
                </p>
            </Link>
            <Link :href="route('control_panel.sales.index')" class="bg-black relative col-span-2 row-span-3 grid place-items-center text-5xl font-bold rounded-xl overflow-hidden hover:-translate-y-1 duration-200" style="box-shadow: 0 0 10px lightgray">
                <div class="opacity-40 absolute top-0 left-0 w-full h-full">
                    <img src="/public/images/control_panel/sales.jpg" class="object-cover w-full h-full" alt="" loading="lazy">
                </div>
                <p class="relative text-white" style="text-shadow: 0 0 20px black">
                    Sales
                </p>
            </Link>
            <Link :href="route('control_panel.item.index')" class="bg-black relative col-span-5 row-span-3 grid place-items-center text-5xl font-bold rounded-xl overflow-hidden hover:-translate-y-1 duration-200" style="box-shadow: 0 0 10px lightgray">
                <div class="opacity-40 absolute top-0 left-0 w-full h-full">
                    <img src="/public/images/control_panel/manage_products.jpg" class="object-cover w-full h-full" alt="" loading="lazy">
                </div>
                <p class="relative text-white" style="text-shadow: 0 0 20px black">
                    Manage products
                </p>
            </Link>      

            <Link :href="route('control_panel.user.index')" class="bg-black relative col-span-3 row-span-2 grid place-items-center text-3xl font-bold rounded-xl overflow-hidden hover:-translate-y-1 duration-200" style="box-shadow: 0 0 10px lightgray">
                <div class="opacity-40 absolute top-0 left-0 w-full h-full">
                    <img src="/public/images/control_panel/user_list.jpg" class="object-cover w-full h-full" alt="" loading="lazy">
                </div>
                <p class="absolute text-white" style="text-shadow: 0 0 20px black">
                    Users List
                </p>
            </Link>
            <Link :href="route('control_panel.news.index')" class="bg-black relative col-span-2 row-span-2 grid place-items-center text-3xl font-bold rounded-xl overflow-hidden hover:-translate-y-1 duration-200" style="box-shadow: 0 0 10px lightgray">
                <div class="opacity-40 absolute top-0 left-0 w-full h-full">
                    <img src="/public/images/control_panel/news.jpg" class="object-cover w-full h-full" alt="" loading="lazy">
                </div>
                <p class="relative text-white" style="text-shadow: 0 0 20px black">
                    News
                </p>
            </Link>
            <Link :href="route('control_panel.promo_code.index')" class="bg-black relative col-span-2 row-span-2 grid place-items-center text-3xl font-bold rounded-xl overflow-hidden hover:-translate-y-1 duration-200" style="box-shadow: 0 0 10px lightgray">
                <div class="opacity-40 absolute top-0 left-0 w-full h-full">
                    <img src="/public/images/control_panel/promo_codes.jpg" class="object-cover w-full h-full" alt="" loading="lazy">
                </div>
                <p class="absolute text-white" style="text-shadow: 0 0 20px black">
                    Promo Codes
                </p>
            </Link>

        </div>
        
    </div>
</template>

<script setup>

    import { Link } from '@inertiajs/vue3'

</script>