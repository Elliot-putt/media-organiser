<template>
    <transition name="fade" class="alerts d-flex justify-content-between">
        <div @click="close" v-if="isAlertOpen">
            <h4> {{ $page.props.flash[props.sessionKey] }}</h4>
            <i @click="close" class="fa-regular fa-circle-xmark my-auto opacity-75 "
               style='cursor: pointer'></i>
        </div>
    </transition>
</template>

<script setup>
import {ref, computed, watchEffect} from "vue";
import {usePage} from '@inertiajs/inertia-vue3'
import {Inertia} from "@inertiajs/inertia";

let props = defineProps({
    sessionKey: String,
    isAlertOpen: Boolean,
});

let page = usePage().props.value;
let isAlertOpen = ref(true);

let close = () => {
    Inertia.get(`/remove/session/?key=${props.sessionKey}`)
    isAlertOpen.value = false
    page.flash[props.sessionKey] = null;
}


</script>

