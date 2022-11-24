<template>
    <Head>
        <title>Home</title>
        <meta type="description" content="Information about my homepage" head-key="description">
    </Head>
    <Alerts />
    <!--    if you have a company or are assigned one show company stats -->
    <div class="container-fluid ">
        <div class="row justify-content-center full">
            <div class="col-md-5 col-10 d-flex mx-auto my-auto ">
                <div class="mx-auto">
                    <button @click="submit"></button>
                    <h1 class="text-purple">
                        Online Media Organiser <br> <span class="text-red">for all service based users</span></h1>
                    <p class="text-secondary">
                        Simply upload your media , create a folder, and you will be able to manage your media hassle
                        free. </p>
                    <div class="d-flex">
                        <div class="me-2">
                            <Link as="button" href="/media" class="fancy" type="submit">
                                <span class="top-key"></span>
                                <span class="text">Manage Media</span>
                                <span class="bottom-key-1"></span>
                                <span class="bottom-key-2"></span>
                            </Link>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end my-4">
                        <Link as="button" href="/media" class="cssbuttons-io-button"> Get started
                            <div class="icon">
                                <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0 0h24v24H0z" fill="none"></path>
                                    <path
                                        d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"
                                        fill="currentColor"></path>
                                </svg>
                            </div>
                        </Link>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-10 justify-content-end my-auto d-flex ">
                <div class="mx-auto">
                    <Link :href="`/users/${$page.props.auth.user.id}/edit`" as="span">
                        <div class="card-css cursor-click">
                            <div class="blob"></div>
                            <span class="img"><img class="img-card" :src="imageSmall"> </span>
                            <h2>{{ username }}</h2>
                            <p class="text-blue">
                                View Your profile </p>
                        </div>
                    </Link>
                </div>
            </div>
            <div>
                <button class="btn btn-theme-colour"><strong>Enter Now</strong></button>
                <button class="btn btn-grad"><strong>Enter Now</strong></button>
            </div>
            <button @click="addSuccess">add first</button>
            <button @click="addSecond">add second</button>
            <button @click="addDanger">add danger</button>
            <div class="text-center scroll d-none d-md-block" v-show="scrolled" @click="scrolled.value = !scrolled ">
                <section id="section07" class="demo">
                    <a href="#card"><span></span><span></span><span></span>Scroll</a>
                </section>
            </div>
        </div>
        <div class="row justify-content-center" id="card">
            <div class="col-12 my-auto justify-content-center row">
                <div class="col-md-4 col-10 my-4 my-md-0  justify-content-center d-flex">
                    <div class="card-box shadow">
                        <div class="body-bottom">
                            <div class="card-details">
                                <i class="fa-solid fa-magnifying-glass text-center fs-2 text-grey"></i>
                                <p class="fs-3 text-blue">View all Users</p>
                            </div>
                            <div>
                                <p class="text-muted">Finding a User is easy. Search for an name you would like to
                                    find , click on the options menu to proceed and find out more.</p>
                            </div>
                        </div>
                        <Link as="a" href="/users" class="card-button text-center btn">More info</Link>
                    </div>
                </div>
                <div class="col-md-4 col-10 my-4 my-md-0 justify-content-center d-flex">
                    <div class="card-box shadow">
                        <div class="body-bottom">
                            <div class="card-details">
                                <i class="fa-solid fa-building text-center fs-2 text-grey"></i>
                                <p class="fs-3 text-blue">Organise media</p>
                            </div>
                            <div>
                                <p class="text-muted">Organising Your Media couldn't be easier. Either search for your
                                    media and click ahead , else upload your media in your specific
                                    area.Click below to find out more.</p>

                            </div>
                        </div>
                        <Link as="a" href="/media" class="card-button text-center btn">More info</Link>
                    </div>
                </div>
                <div class="col-md-4 col-10 my-4 my-md-0  justify-content-center d-flex">
                    <div class="card-box shadow">
                        <div class="body-bottom">
                            <div class="card-details">
                                <i class="fa-solid fa-user text-center fs-2 text-grey"></i>
                                <p class="fs-3 text-blue">Adding Members</p>
                            </div>
                            <div>
                                <p class="text-muted">Adding members to this application is simple! Either create the
                                    user an account or click invite a user and it will send them a login link.</p>

                            </div>
                        </div>
                        <Link as="a" href="/users" class="card-button text-center btn">More info</Link>
                    </div>
                </div>
            </div>
        </div>
    </div>



</template>
<script setup>
import imageSmall from "../../../public/images/singlemedialogo.png"
import {computed, onBeforeMount, onMounted, ref} from "vue";
import {usePage} from "@inertiajs/inertia-vue3";
import {useForm} from "@inertiajs/inertia-vue3"
import Message from '../Components/Message'
//carousel
import {defineComponent} from 'vue'
import {Carousel, Navigation, Pagination, Slide} from 'vue3-carousel'
import stripes from '../../../public/images/stripes.png'

import 'vue3-carousel/dist/carousel.css'
import {Inertia} from "@inertiajs/inertia";
import Alerts from "../Components/Alerts";

const username = computed(() => {
    return usePage().props.value.auth.user.username
});
let page = usePage().props.value;

let form = useForm({
    notes: '',
});
let first = useForm({
    message: '',
});
let submit = () => {
    form.post('/test');
}

let addSuccess = () =>{
Inertia.post('/add')
}
let addSecond = () =>{
    Inertia.post('/second')
}
let addDanger = () =>{
    Inertia.post('/danger')
}

let scrolled = ref(true);
</script>
