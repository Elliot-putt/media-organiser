<template>
    <Head>
        <title>Home</title>
        <meta type="description" content="Information about my homepage" head-key="description">
    </Head>
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
    <Carousel>
        <Slide v-for="slide in 10" :key="slide">
            <div class="carousel__item row justify-content-center"
                 :style="`background-image: url(${stripes}) !important;`">
                <div id="featuredImg" class="d-flex flex-column justify-content-between d-md-none col-12 col-md-6 p-0">
                    <img class="carousel-img"
                         src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80"/>
                </div>
                <div id="content" class="d-flex flex-column justify-content-between col-12 col-md-6 mt-md-0 mt-4 p-4">
                    <div>
                        <h2 class="text-white fs-1">Featured Title Here</h2>
                    </div>
                    <div class="mt-3">
                        <button class="btn btn-dark">Find Our More</button>
                    </div>
                    <div class="mt-3">
                        <a class="btn btn-dark">Click Here</a>
                    </div>
                </div>
                <div id="featuredImgRight"
                     class="d-none flex-column justify-content-between d-md-flex col-12 col-md-6 p-0">
                    <img class="carousel-img"
                         src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80"/>
                </div>

            </div>
        </Slide>
        <template #addons>
            <Navigation/>
            <Pagination/>
        </template>
    </Carousel>


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

const username = computed(() => {
    return usePage().props.value.auth.user.username
});
let page = usePage().props.value;

let form = useForm({
    notes: '',
});
let submit = () => {
    form.post('/test');
}


let scrolled = ref(true);
</script>

<style scoped>
.carousel__item {
    width: 100%;
    background-color: #b2132c !important;
    background-repeat: repeat !important;
    background-size: auto !important;
    color: #fff !important;
    font-size: 20px;
    border-radius: 8px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.carousel__slide {
    padding: 10px;
}

.carousel__prev,
.carousel__next {
    box-sizing: content-box;
    border: 5px solid white;
}

.carousel-img {
    height: 50% !important;
    background-size: cover;
    background-position: center;
    height: 300px;
    width: 100%;
    border: none;
}

/** Smartphones (portrait and landscape) ----------- *!*/
@media only screen and  (max-device-width: 899px) {
    .carousel-img {
        border-top-left-radius: 2%;
        border-top-right-radius: 2%;
        /*mobile query make square*/
        clip-path: polygon(0 0, 100% 0, 100% 100%, 0% 100%);
        -webkit-clip-path: polygon(0 0, 100% 0, 100% 100%, 0% 100%);
    }
}

/* iPads (portrait and landscape) ----------- */
@media only screen and (min-device-width: 900px) {
    .carousel-img {
        border-top-left-radius: 2%;
        border-top-right-radius: 2%;
        /*mobile query make square*/
        clip-path: polygon(0 0, 100% 0, 100% 100%, 0% 100%);
        -webkit-clip-path: polygon(0 0, 100% 0, 100% 100%, 0% 100%);
    }
}

/* Desktops and laptops ----------- */
@media only screen  and (min-width: 1224px) {
    .carousel-img {
        /*desktop larger query make slanted*/
        clip-path: polygon(0 0, 100% 0, 100% 100%, 6% 100%);
        -webkit-clip-path: polygon(0 0, 100% 0, 100% 100%, 6% 100%);
    }
}

/* Large screens ----------- */
@media only screen  and (min-width: 1824px) {
    .carousel-img {
        /*desktop larger query make slanted*/
        clip-path: polygon(0 0, 100% 0, 100% 100%, 6% 100%);
        -webkit-clip-path: polygon(0 0, 100% 0, 100% 100%, 6% 100%);
    }
}
</style>
