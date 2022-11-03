<template>
    <!-- modal-->
    <transition name="fade" v-if="Object.keys($page.props.errors).length  > 0 ">
        <div @click="isAlertOpen = false" v-if="isAlertOpen"
             class="alerts alert-colour-danger d-flex justify-content-between">
            <ul>
                <li v-for="message in $page.props.errors" v-text="message"></li>

                <li v-if="Object.keys($page.props.errors).length > 3">You have multiple errors in the create form</li>
            </ul>
            <i class="fa-regular fa-circle-xmark my-auto opacity-75 " @click="isAlertOpen = false"
               style='cursor: pointer'></i>
        </div>
    </transition>
    <transition name="fade">
        <a class="position-fixed  p-3 btn alert-danger"
           v-if="!isAlertOpen && Object.keys($page.props.errors).length  > 0"
           style="right: 10px; top: 90%; z-index: 10" @click="isAlertOpen = true">
            Errors <i class="fa-solid fa-circle-exclamation ms-1"></i>
        </a>
    </transition>
</template>

<script setup>
import {ref} from "vue";
import {usePage} from '@inertiajs/inertia-vue3'


let page = usePage().props.value;
let isAlertOpen = ref(true);
</script>


