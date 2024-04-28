<template>

    <div class="flex flex-col gap-y-4">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-4xl">
                {{ item.name }}
            </h2>
            <colors :colors="item.colors"/>
        </div>
        <item-categories :categories="item.categories"/>
        <item-brands :brands="item.brands"/>
        <p class="font-bold text-4xl my-6">{{ item.price }}$</p>
        <item-sizes :sizes="item.sizes"/>
        <!-- <button class="mx-auto mt-4 text-xl font-bold text-white bg-gradient-to-tr from-black to-purple-500 py-4 px-12 rounded-lg relative overflow-hidden hover:scale-105 duration-100">
            <div class="w-full h-full absolute top-0 left-0 bg-gradient-to-tr from-purple-500 to-transparent via-transparent via-25%">
            </div>
            <div class="w-full h-full absolute top-0 right-0 bg-gradient-to-tl from-purple-900 to-transparent via-transparent via-40% translate-x-1/5">
            </div>
            <p class="relative">
                <i class="fa-solid fa-cart-shopping text-lg mr-2 "></i>
                Add to cart
            </p>
        </button> -->
        <div class="mx-auto my-4">
            <button class="button-special-back text-5xl">
                Add to cart
                <div class="button-special-front text-black">
                    <p class="font-bold text-2xl">
                        <i class="fa-solid fa-cart-shopping text-xl mr-2 text-purple-500"></i>
                        Add to cart
                    </p>
                </div>
            </button>
        </div>
        
        <item-description :description="item.description"/>
    </div>


</template>

<script setup>

    import ItemCategories from '@/Components/UX/Categories.vue'
    import Colors from '@/Components/Store/Colors.vue'
    import ItemBrands from '@/Components/Store/ItemBrands.vue'
    import ItemSizes from '@/Components/StoreShow/ItemSizes.vue'
    import ItemDescription from '@/Components/StoreShow/ItemDescription.vue'

    const props = defineProps({
        item: Object
    })

</script>