<template>

    <header class="flex fixed top-0 w-full bg-white z-50 gap-x-2 py-2 px-10 items-center justify-between shadow-lg font-barlow">
        <Link class="h-20 object-cover" :href="route('home')">
            <img 
                src="\storage\app\public\default\logo_text.png" 
                class="h-full w-full"
                alt=""
            >
        </Link>
        <div class="flex gap-x-2">
            <category v-for="category in categories" :category="category" :show-category-id="showCategoryId" :key="category.id" @toggle-show-category="changeShowCategory"/>
        </div>
        <div class="flex gap-x-2">
            <!-- <Link :href="route('help')" class="button-special-back">
                Help
                <div class="button-special-front">
                    <div class="button-special-text-2">
                        <i class="fa-solid fa-handshake text-sm text-purple-500"></i>
                        Help
                    </div>
                </div>
            </Link> -->
            <cart v-if="user" :cart-items="cartItems" :show-cart="showCartRef" @toggle-show-cart="toggleShowCart" @hide-cart="hideCart"/>
            <dashboard v-if="user" :show-dashboard="showDashboardRef" :uncompleted-orders="uncompletedOrdersCount" :user="user" @toggle-show-dashboard="toggleShowDashboard" @hide-dashboard="hideDashboard"/>
            <Link v-else :href="route('login')" class="button-special-back">
                Login
                <div class="button-special-front">
                    <div class="button-special-text-2">
                        <i class="fa-solid fa-arrow-right-to-bracket text-sm text-purple-500"></i>
                        Login
                    </div>
                </div>
            </Link>
        </div>
    </header>
    <flash v-if="flashRef.error && showFlash" :flash="flashRef.error" type="error" @hide-flash="hideFlash"/>
    <flash v-if="flashRef.success && showFlash" :flash="flashRef.success" type="success" @hide-flash="hideFlash"/>
    <div style="min-height: calc(100vh - 120px); padding-top: 96px;" class="font-barlow mb-10 h-fit">
        <slot></slot>
    </div>
    <div class="bg-black h-20 text-white font-barlow flex flex-col justify-center px-10 text-sm">
        <div class="flex justify-between items-center">
            <ul class="flex gap-x-3">
                <li>Help</li>
                <li>About</li>
                <li>Work</li>
                <li>Website terms and conditions</li>
            </ul>
            <ul class="flex gap-x-6 text-lg">
                <i class="fa-brands fa-instagram"></i>
                <i class="fa-brands fa-facebook"></i>
                <i class="fa-brands fa-tiktok"></i>
                <i class="fa-brands fa-youtube"></i>
            </ul>
        </div>
        <div class="text-center">
            &copy; 2024 xshoes all rights reserved
        </div>
    </div>
</template>

<script setup>

    import Category from '@/Components/MainLayout/Category.vue'
    import Cart from '@/Components/MainLayout/Cart.vue'
    import Dashboard from '@/Components/MainLayout/Dashboard.vue'
    import Flash from '@/Components/UX/Flash.vue'
    import { Link, usePage } from '@inertiajs/vue3'
    import { ref, computed, watch } from 'vue'

    const page = usePage()
    const user = computed(() => page.props.user)
    const categories = computed(() => page.props.categories)
    const cartItems = computed(() => page.props.cart_items)
    const uncompletedOrdersCount = computed(() => page.props.uncompleted_orders_count);
    const flashRef = ref(page.props.flash)
    const showFlash = ref(true);
    const showCategoryId = ref(null);
    const showCartRef = ref(false);
    const showDashboardRef = ref(false);

    const hideFlash = () => {
        showFlash.value = false;
    }

    const changeShowCategory = (id) => {
        if (showCategoryId.value == id) {
            showCategoryId.value = null
        } else {
            showCategoryId.value = id;
        }
    }

    const toggleShowDashboard = () => {
        hideCart();
        showDashboardRef.value = !showDashboardRef.value;
    }

    const toggleShowCart = () => {
        hideDashboard();
        showCartRef.value = !showCartRef.value
    }

    const hideCart = () => {
        showCartRef.value = false
    }

    const hideDashboard = () => {
        showDashboardRef.value = false;
    }

    watch(()=>page.props.flash, ()=>{
        showFlash.value = true;
        flashRef.value = page.props.flash;
    })


</script>