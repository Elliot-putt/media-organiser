<template>
    <nav class="navbar navbar-expand-lg navbar-light py-4 px-2 justify-content-between  bg-blue sidebar"
         style="border-radius: 0">
        <div class="d-flex">
            <Link class="mx-2 m-auto  text-decoration-none text-white fs-4" href="/"><img class="img-small-nav mb-3"
                                                                                          :src="imageSmall"><img
                class="img d-none d-md-inline-block" :src="image"> |
            </Link>
            <p class="navbar-brand fs-6 m-auto text-white fs-4">Welcome Back , {{ username }} !</p>
        </div>

        <div class="d-flex justify-content-center">
            <!--            new dropdown-->
            <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item dropstart">
                        <a class="nav-link " href="#" id="navbarDarkDropdownMenuLink" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-basket-shopping text-white fs-4"></i> <span
                            class="badge badge-danger badge-counter">5</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-center pt-0 rounded-3"
                            aria-labelledby="navbarDarkDropdownMenuLink">
                            <li class="dropdown-header fs-5 fw-bold mb-2 text-white rounded-3"
                                style="background-color:#b2132c; ">
                                Entered Competitions
                            </li>
                            <li><a class="dropdown-item" href="#">
                                <div class="d-flex justify-content-between">
                                    <img @dragstart.prevent
                                         src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80"
                                         class="img-featured-small">
                                    <p class=" badge-counter fw-bold">x5</p>
                                    <div class="d-flex justify-content-between mt-2">
                                        <p class="ms-2 me-1"> Item nameItem nameItem nameItem nameItem nameItem nameItem
                                            name </p>
                                        <p><strong><i class="fa-solid fa-sterling-sign ms-2 me-1"></i></strong> 5.99</p>
                                    </div>
                                </div>
                            </a></li>
                            <hr class="dropdown-divider w-75 mx-auto">
                            <li>
                                <button class="dropdown-item">View Basket</button>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <label for="check" class="bar">
                <input v-model="isPanelOpen" id="check" type="checkbox">
                <span class="top"></span>
                <span class="middle"></span>
                <span class="bottom"></span>
            </label>

        </div>
    </nav>
    <Sidebar :is-panel-open="isPanelOpen" :img="image">
        <NavLink class="mx-2" href="/" :active="$page.component === 'Home'">Home</NavLink>
        <NavLink class="mx-2" href="/users" :active="$page.component === 'Users/View'">Users</NavLink>
        <NavLink class="mx-2" href="/media" :active="$page.component === 'Media/View'">Media</NavLink>
        <NavLink class="mx-2" href="/media/guide" :active="$page.component === 'Media/Guide'">User Guide</NavLink>
        <NavLink class="mx-2 border-top mt-2" method="post" as="button" href="/logout">Logout</NavLink>
    </Sidebar>
    <div class="sidebar-backdrop" @click="isPanelOpen = !isPanelOpen" v-if="isPanelOpen"></div>

</template>

<script setup>
import imageSmall from "../../../public/images/singlemedialogo.png"
import image from "../../../public/images/mediatext.png"
import NavLink from './NavLInk';
import {usePage} from '@inertiajs/inertia-vue3'
import {computed, ref} from 'vue'
import Sidebar from "../Components/Sidebar";

let isPanelOpen = ref(false);
const username = computed(() => {
    return usePage().props.value.auth.user.username
});

</script>

