<template>

    <div class="flash">
        <div class="relative flex items-center gap-x-2">
            <div class="absolute z-20 left-0 h-20 w-20 rounded-full text-white grid place-items-center" :class="type == 'error' ? 'bg-red-600' : 'bg-purple-500'">
                <i 
                    class="fa-solid text-5xl" 
                    :class="type == 'error' ? 'fa-triangle-exclamation' : 'fa-circle-check'"></i>
            </div>
            <div class="flash-text flex items-center" :class="type == 'error' ? 'border-red-600 text-red-600' : 'border-purple-500 text-purple-500'">
                {{flash}}
            </div>
            <button class="absolute top-1 right-1 p-2 flash-close" @click="hideFlash">
                <i class="fa-solid fa-x"></i>
            </button>
        </div>
    </div>

</template>

<style scoped>

    .flash-text {
        padding-left: 5rem;
        padding-right: 2rem;
        height: 5rem;
        width: 100%;
        font-weight: bold;
        font-size: 22px;
        margin-left: 12px;
        background-color: white;
        border: solid 3px;
        border-radius: 10px;
        transform: translateX(-200%);
        animation: slideRight 0.4s ease-in 0.8s forwards;
    }

    .flash-close {
        opacity: 0;
        animation: appear 0.3s ease-in 1.4s forwards;
    }

    .flash {
        position: fixed;
        top: 110px;
        z-index: 50;
        left: 50%;
        transform: translateX(-50%);
        padding-right: 8px;
        border-radius: 1000px;
        padding-right: 20px;
        overflow: hidden;
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        animation: notificationDrop 0.8s ease-in;
    }


    @keyframes notificationDrop {
        0% {
            transform: translate(-50%, -80px);
            opacity: 0;
        }
        70% {
            opacity: 0.2;
        }
        100% {
            opacity: 1; 
        }
    }

    @keyframes appear {
        0% {
            opacity: 0;
        }
        100% {
            opacity: 1; 
        }
    }

    @keyframes slideRight {
        0%{
            transform: translateX(-200%);
        }
        100% {
            transform: translateX(0);
        }
    }

</style>

<script setup>

    const props = defineProps({
        flash: String,
        type: String
    })

    const emit = defineEmits(['hide-flash'])

    const hideFlash = () => {
        emit('hide-flash');
    }


</script>