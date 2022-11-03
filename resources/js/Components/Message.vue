<template>
    <transition name="fade" class="alerts d-flex justify-content-between">
        <div @click="close" v-if="isAlertOpen">
            <h4> {{ message }}</h4>
            <i @click="close" class="fa-regular fa-circle-xmark my-auto opacity-75 "
               style='cursor: pointer'></i>
        </div>
    </transition>
</template>

<script setup>
import {ref, computed, watchEffect} from "vue";
import {usePage} from '@inertiajs/inertia-vue3'

let props = defineProps({
    sessionKey: String,
    isAlertOpen: Boolean,
});

let page = usePage().props.value;
let isAlertOpen = ref(true);

let message = ref(page.flash[props.sessionKey]);

let close = () => {
    isAlertOpen.value = false
    page.flash[props.sessionKey] = null;
}


</script>

