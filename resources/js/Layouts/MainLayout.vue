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
            <Link :href="route('help')" class="button-special-back">
                Help
                <div class="button-special-front">
                    <div class="button-special-text-2">
                        <i class="fa-solid fa-handshake text-sm text-purple-500"></i>
                        Help
                    </div>
                </div>
            </Link>
            <cart v-if="user" :cart-items="cartItems" :show-cart="showCartRef" @toggle-show-cart="toggleShowCart" @hide-cart="hideCart"/>
            <Link v-if="user" :href="route('logout')" as="button" method="DELETE" class="button-special-back">
                {{ user.name }}
                <div class="button-special-front">
                    <div class="button-special-text-2">
                        <i class="fa-solid fa-user text-sm text-purple-500"></i>
                        {{ user.name }}
                    </div>
                </div>
            </Link>
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
    <div style="min-height: 100vh; padding-top: 96px;" class="font-barlow">
        <slot></slot>
    </div>
</template>

<script setup>

    import Category from '@/Components/MainLayout/Category.vue'
    import Cart from '@/Components/MainLayout/Cart.vue'
    import Flash from '@/Components/UX/Flash.vue'
    import { Link, usePage } from '@inertiajs/vue3'
    import { ref, computed, watch } from 'vue'

    const page = usePage()
    const user = computed(() => page.props.user)
    const categories = computed(() => page.props.categories)
    const cartItems = computed(() => page.props.cart_items)
    const flashRef = ref(page.props.flash)
    const showFlash = ref(true);
    const showCategoryId = ref(null);
    const showCartRef = ref(false);

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

    const toggleShowCart = () => {
        showCartRef.value = !showCartRef.value
    }

    const hideCart = () => {
        showCartRef.value = false
    }

    watch(()=>page.props.flash, ()=>{
        showFlash.value = true;
        flashRef.value = page.props.flash;
    })

    // watch(()=>page.props.cart_items, (newValue, oldValue)=>{
    //     if(newValue != oldValue){
    //         console.log(newValue);
    //         console.log(oldValue);
    //         showCartRef.value = true;
    //     }
    // })


</script>