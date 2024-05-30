<template>

    <div class="flex flex-col col-span-7 relative px-6">
 
        
        
        <div v-if="showInstruction" class="py-20 px-40  text-center text-5xl font-bold">
            <p class="opacity-40">
                Add new product or edit existing one by selecting one from the list
            </p>
            <button @click="createNew" class="button-primary font-semibold mx-auto mt-8 text-3xl">
                Create new
            </button>
        </div>
        <div v-if="selectCategories" class="flex flex-col gap-y-4 mx-10">
            <div class="flex justify-between">
                <h3 class="text-2xl font-semibold">
                    <i class="fa-solid fa-table-columns text-purple-500 mr-2 text-xl"></i>
                    Select category
                </h3>
                <button class="text-purple-500 hover:underline text-lg font-semibold" @click="createNew">
                    <i class="fa-solid fa-trash text text-base"></i>
                    Reset
                </button>
            </div>
            <button v-for="category in categoriesToChoseFrom" :key="category.id" @click="addToCategoriesForm(category)" class="py-2 px-10 rounded-lg border w-1/2 mx-auto">
                <i class="fa-solid text-xl mr-2" :class="category.icon"></i>
                {{category.name}}
            </button>
        </div>
        <div v-if="!showInstruction && !selectCategories">
            <div class="flex absolute z-10 top-0 right-6 gap-x-8">
                <button @click="deleteItem" v-if="form.id" class=" text-red-500 hover:underline font-semibold text-xl">
                    <i class="fa-solid fa-trash text-lg"></i>
                    Delete
                </button>
                <button @click="createNew" v-if="form.id" class=" text-purple-500 hover:underline font-semibold text-xl">
                    <i class="fa-solid fa-circle-plus text-lg"></i>
                    Create new
                </button>
            </div>
 
            <h2 v-if="form.id" class="text-2xl font-semibold">
                <i class="fa-solid fa-pen-to-square text-purple-500 text-xl mr-2"></i>
                Edit {{ item.name }}
            </h2>
            <h2 v-else class="text-2xl font-semibold">
                <i class="fa-solid fa-circle-plus text-purple-500 text-xl mr-2"></i>
                Posting new product
            </h2>

            <div class="flex flex-col gap-y-3 mt-10">
                <div v-if="Object.keys(adjustedForm.errors).length != 0" class="my-2 text-red-600 border-red-600 border-[3px] rounded-lg py-1 px-3 flex gap-x-8 w-fit mx-auto">
                    <i class="fa-solid fa-triangle-exclamation text-4xl"></i>
                    <div>
                        <div v-for="error in adjustedForm.errors" class="font-semibold">
                            {{ error }}
                        </div>
                    </div>
                </div>
                <div class="flex justify-between gap-x-3">
                    <div class="relative w-full">
                        <label class="absolute left-3 top-0 -translate-y-1/2 bg-white px-2 text-sm font-semibold">Model name</label>
                        <input v-model="form.name" type="text" class="w-full border rounded-lg pb-1 pt-2 px-2 outline-none">
                    </div>
                    <div class="relative w-full">
                        <label class="absolute left-3 top-0 -translate-y-1/2 bg-white px-2 text-sm font-semibold">Price</label>
                        <input v-model="form.price" type="text" class="w-full border rounded-lg pb-1 pt-2 px-2 outline-none">
                    </div>
                </div>
                <div class="relative w-full">
                    <label class="absolute left-3 top-0 -translate-y-1/2 bg-white px-2 text-sm font-semibold">Description</label>
                    <textarea v-model="form.description" type="text" class="w-full border rounded-lg py-3 px-2 outline-none" spellcheck="false"></textarea>
                </div>
                <label class=" bg-white px-2 text-sm font-semibold">Sizes</label>
                <div v-if="form.sizes.length" class="flex justify-center">
                    <div class="py-2 font-semibold">
                        <div class="border-b whitespace-nowrap px-2 py-1 border-r border-l border-t">Size name</div>
                        <div class="border-b whitespace-nowrap px-2 py-1 border-r border-l">Amount per size</div>
                        <div class="border-b whitespace-nowrap px-2 py-1 border-r border-l text-purple-500">Change amount by</div>
                        <div class="border-b whitespace-nowrap px-2 py-1 border-r border-l">New amount</div>
                    </div>
                    <div v-for="size in form.sizes" class="py-2 rounded-lg">
                        <div class="bg-gray-100 border-b border-r text-center px-2 py-1 border-t">{{ size.name }}</div>
                        <div class="bg-gray-100 border-b border-r text-center px-2 py-1">{{ size.pivot.amount }}</div>
                        <input class="border-b border-r text-center px-2 py-1 w-20 text-black font-bold" :min="-1 * size.pivot.amount" v-model="form.sizes_to_adjust[size.id]" type="number">
                        <div class="bg-gray-100 border-b border-r text-center px-2 py-1">{{ size.pivot.amount + form.sizes_to_adjust[size.id] }}</div>
                    </div>
                </div>
                <div v-else class="flex flex-col gap-y-2">
                    <button as="button" @click="selectedSizes('clothes')" class="py-1 px-2 border-purple-500 hover:bg-gray-100 rounded-lg border-[3px] font-semibold">
                        clothes (XS - 4XL)
                    </button>
                    <button as="button" @click="selectedSizes('shoes')" class="py-1 px-2 border-purple-500 hover:bg-gray-100 rounded-lg border-[3px] font-semibold">
                        shoes (40 - 47)
                    </button>
                </div>
                <label class=" bg-white px-2 text-sm font-semibold">Colors</label>
                <div class="flex flex-wrap px-10 gap-4 py-5">
                    <button    
                        v-for="color in colors" :key="colors.id" 
                        class="h-10 w-10 rounded-full relative duration-200" 
                        :style="'background-color:' + color.color"
                        style="box-shadow: 0 0 10px lightgray"
                        :class="form.colors.map(el => el.id).includes(color.id) ? 'scale-[1.2] -translate-y-3 shadow-lg' : null"
                        @click="toggleColor(color)"
                    >
                    </button>
                </div>
                <label class=" bg-white px-2 text-sm font-semibold">Brands</label>
                <div class="flex flex-wrap px-10 gap-4 py-5">
                    <button    
                        v-for="brand in brands" :key="brand.id" 
                        class="font-semibold py-1 px-2 rounded-lg bg-black text-white duration-200"
                        :class="form.brands.map(el => el.id).includes(brand.id) ? 'bg-purple-500 shadow-lg' : null"
                        @click="toggleBrand(brand)"
                    >
                        {{ brand.name }}
                    </button>
                </div>
                <label class=" bg-white px-2 text-sm font-semibold">Images</label>
                <div class="flex justify-between">
                    <input 
                        id="file"
                        type="file" 
                        multiple
                        @input="addImage"
                        class="h-full cursor-pointer file:cursor-pointer border outline-none w-full rounded-lg file:bg-purple-500 file:px-4 file:py-2 file:text-white file:border-none font-semibold file:mr-4"
                        style="padding: 0"
                    >
                    <button as="button" v-if="form.images.length" @click="resetImages" class="min-w-40 right-1 top-1 font-semibold bg-white" type="button">
                        <i class="fa-solid fa-trash text-purple-500 mr-1"></i>
                        Reset images
                    </button>
                </div>
                <div v-if="form.images.length" class="flex flex-wrap gap-x-2 pb-4">
                    <div v-for="image, index in form.images" class="h-40 w-40 rounded-lg overflow-hidden relative" :key="image.src" style="box-shadow: 0 0 10px lightgray">
                        <button @click="removeImage(index)" class="absolute top-2 right-2 border-[3px] border-red-500 w-6 h-6 bg-white text-red-500 rounded-lg grid place-items-center">
                            <i class="fa-solid fa-trash text-xs"></i>
                        </button>
                        <img :src="image.src" class="w-full h-full object-cover">
                    </div>
                </div>
                <div class="flex gap-x-4 ml-auto w-full">
                    <button @click="sendForm" v-if="form.id" class="text-2xl font-semibold button-primary w-1/2 mx-auto flex justify-center mb-10 mt-3">
                        Update
                    </button>
                    <button @click="sendForm" v-else class="text-2xl font-semibold button-primary w-1/2 mx-auto flex justify-center mb-10 mt-3">
                        Create
                    </button>
                </div>
            </div>

            <div v-if="Object.values(form).some(value => value !== null && value !== undefined && value !== '')" class="w-full  relative  h-fit">
                <h2 class="font-semibold text-2xl">
                    <i class="fa-solid fa-magnifying-glass text-purple-500 text-xl mr-2"></i>
                    Preview
                </h2>
                <div class="absolute -top-[175px] w-[100vw] scale-50 left-1/2 -translate-x-1/2">
                    <item-preview :item="form"/>
                </div>
            </div>
        </div>
    </div>

</template>

<script setup>

    import ItemPreview from '@/Components/ControlPanelItem/ItemPreview.vue'
    import { useForm, router } from '@inertiajs/vue3';
    import { watch, ref, reactive } from 'vue'

    const props = defineProps({
        item: Object,
        categories: Array,
        sizes: Array,
        colors: Array,
        brands: Array,
    })

    const emit = defineEmits(['creating-new', 'item-updated-successfully'])

    const form = reactive({
        id: null,
        name: null,
        price: null,
        description: null,
        images: [],
        categories: [],
        sizes: [],
        sizes_to_adjust: {},
        brands: [],
        colors: [],
    })

    const adjustedForm = useForm({
        id: null,
        name: null,
        price: null,
        description: null,
        newImages: [],
        oldImages: [],
        categories: [],
        sizes: [],
        sizes_to_adjust: {},
        brands: [],
        colors: [],
    })


    const showInstruction = ref(true);
    const selectCategories = ref(false);
    const categoriesToChoseFrom = ref(props.categories);

    const selectedSizes = (value) => {
        form.sizes = props.sizes.filter(size => size.for == value).map(el => ({...el, pivot: {amount: 0}}));
        form.sizes_to_adjust = {},
        form.sizes.forEach(size => {
            form.sizes_to_adjust[size.id] = 0
        })
    } 

    const addToCategoriesForm = (category) => {
        form.categories.push(category);
        if(category.children){
            categoriesToChoseFrom.value = category.children
        } else {
            selectCategories.value = false;
        }
    }

    const addImage = (event) => {
        for (let i = 0; i < event.target.files.length; i++) {
            let file = event.target.files[i];
            form.images.push({newImage: file, src: URL.createObjectURL(file)})
        }
    }

    const removeImage = (index) => {
        form.images.splice(index, 1)
    }

    const toggleColor = (color) => {
        let index = form.colors.findIndex(col => col.id === color.id);
        if(index != -1){
            form.colors.splice(index, 1);
        } else {
            form.colors.push(color);
        }
    }

    const toggleBrand = (brand) => {
        let index = form.brands.findIndex(b => b.id === brand.id);
        if(index != -1){
            form.brands.splice(index, 1);
        } else {
            form.brands.push(brand);
        }
    }

    const createNew = () => {
        emit('creating-new');
        showInstruction.value = false;
        selectCategories.value = true;
        categoriesToChoseFrom.value = props.categories;
        form.id = null;
        form.name = null;
        form.price = null;
        form.description = null;
        form.images = [];
        form.categories = [];
        form.sizes = [];
        form.sizes_to_adjust = {};
        form.brands = [];
        form.colors = [];
    }

    const deleteItem = () => {
        if(confirm("Are you sure your want to delete this item?")){
            router.delete(route('control_panel.item.destroy', {item: props.item.id}), {onSuccess: ()=>{showInstruction.value = true}})
        }
    }

    const updateForm = () => {
        if (props.item) {
            form.id = props.item.id;
            form.name = props.item.name;
            form.price = props.item.price;
            form.description = props.item.description;
            form.images = [...props.item.images];
            form.categories = props.item.categories;
            form.sizes = props.item.sizes;
            form.sizes_to_adjust = {};
            form.sizes.forEach(size => {
                form.sizes_to_adjust[size.id] = 0;
            });
            form.brands = props.item.brands;
            form.colors = props.item.colors;
        }
    }

    const adjustForm = (f) => {
        let oldImages = [];
        let newImages = [];
        f.images.forEach(image => {
            if(image.id){
                oldImages.push(image.id);
            } else {
                newImages.push(image.newImage);
            }
        })
        adjustedForm.id = f.id;
        adjustedForm.name = f.name;
        adjustedForm.price = f.price;
        adjustedForm.description = f.description;
        adjustedForm.newImages = newImages;
        adjustedForm.oldImages = oldImages;
        adjustedForm.categories = f.categories.map(el => el.id);
        adjustedForm.sizes = f.sizes.length ? f.sizes[0].for : null;
        adjustedForm.sizes_to_adjust = Object.fromEntries(Object.entries(f.sizes_to_adjust).filter(([key, value]) => value !== 0)) ?? [];
        adjustedForm.brands = f.brands.map(el => el.id);
        adjustedForm.colors = f.colors.map(el => el.id);
    }

    const sendForm = () => {
        adjustForm(form);
        console.log(adjustedForm)
        if(adjustedForm.id){
            adjustedForm.post(route('control_panel.item.update', {item: adjustedForm.id}), {onSuccess: ()=>{showInstruction.value = true}})
        } else {
            adjustedForm.post(route('control_panel.item.store'), {onSuccess: ()=>{showInstruction.value = true}})
        }
    }

    watch(()=>props.item, ()=>{
        if(props.item){
            selectCategories.value = false
        }
        showInstruction.value = false
        updateForm();
    })

</script>