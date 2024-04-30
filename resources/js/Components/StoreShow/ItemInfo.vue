<template>

    <div class="flex flex-col gap-y-4">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-4xl">
                {{ item.name }}
            </h2>
            <colors :colors="item.colors" class="scale-150"/>
        </div>
        <item-categories :categories="item.categories"/>
        <item-brands :brands="item.brands"/>
        <p class="font-bold text-4xl my-6">{{ item.price }}$</p>
        <item-sizes :sizes="item.sizes" @selected-size="setSelectedSize" :selected-size="selectedSizeRef" :no-size-selected-error="noSizeSelectedError"/>
        <div class="mx-auto mt-2 mb-12">
            <button @click="addToCart" class="button-special-back text-5xl hover:shadow-xl">
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
    import { ref } from 'vue'
    import { router } from '@inertiajs/vue3'

    const props = defineProps({
        item: Object, 
        selectedSize: Number
    })

    const selectedSizeRef = ref(props.selectedSize);
    const noSizeSelectedError = ref(false);

    const setSelectedSize = (sizeId) => {
        if(selectedSizeRef.value == sizeId){
            selectedSizeRef.value = null
        } else {
            selectedSizeRef.value = sizeId;
            noSizeSelectedError.value = false;
        }
    }

    const addToCart = () => {
        if(selectedSizeRef.value){
            router.post(route('cart.store', {item_id: props.item.id, size_id: selectedSizeRef.value}))
        } else {
            alert('No size selected');
            noSizeSelectedError.value = true;
        }
    }

</script>