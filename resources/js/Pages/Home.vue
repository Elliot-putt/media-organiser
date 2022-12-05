<template>
    <Head>
        <title>Home</title>
        <meta type="description" content="Information about my homepage" head-key="description">
    </Head>
    <Alerts/>
    <!--    if you have a company or are assigned one show company stats -->
    <div class="container-fluid ">
        <div class="row justify-content-center full">
            <div class="col-md-5 col-10 d-flex mx-auto my-auto ">
                <div class="mx-auto">
                    <button @click="submit"></button>
                    <a href="/viva/checkout/redirect">Api Test</a>
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
        <div>
            <div class="row justify-content-center my-4">
                <div class="col-10">
                    <label for="image-upload" class="form-label fw-bold text-black">Upload Featured
                        Photos</label>
                    <input type="file" @input="uploadFiles($event.target.files)" multiple
                           class="form-control" id="image-upload" name="files[]"
                           accept='file_extension|image/*|media_type'>
                    <div class="my-4 row justify-content-start ">
                        <div v-for="file in files" :key="file.id" class="col-md-2  drop-zone"
                             @drop="onDrop($event.target, file.id)" @dragenter.prevent="setActive"
                             @dragover.prevent="setActive" @dragleave.prevent="setInactive">
                            <div class="drag-el mx-2">
                                <div class="d-flex justify-content-between mb-2 mx-2">
                                    <p class="text-dark-blue-purple fs-5 cursor-click " v-text="'Photo ' + file.order"></p>
                                </div>
                                <div :draggable="!processing" @dragstart="startDrag($event.target, file.id)" style="z-index: -1"
                                     :class="[active === true ? 'drop-image' : '' , processing === true || form.processing === true ? 'drop-image' : 'cursor-click']">
                                    <div class="loader" v-if="processing || form.processing"></div>
                                    <img :src="file.url" draggable="false" @dragstart.prevent class="img-featured"
                                         style="z-index: 11">
                                </div>

                            </div>

                        </div>
                        <p v-if="files.length === 0" class="text-center text-muted">No photo's for
                            this competition.</p>
                    </div>
                </div>
            </div>
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

defineProps({
    files: Object
})
const username = computed(() => {
    return usePage().props.value.auth.user.username
});
let page = usePage().props.value;

let first = useForm({
    message: '',
});

let addSuccess = () => {
    Inertia.post('/add')
}
let addSecond = () => {
    Inertia.post('/second')
}
let addDanger = () => {
    Inertia.post('/danger')
}

let scrolled = ref(true);

let form = useForm({
    files: null,
});


//move files around code
let uploadFiles = (files) => {
    Inertia.post(`/file`, {files: files}, {
        preserveState: true,
    });
}

let submit = () => {
    form.post('/competitions', {
        onSuccess: () => flash('Success', 'This form has submitted correctly.'),
        onError: () => flash('Oops', 'This form has not submitted correctly please try again.', 'error'),
    });
}
let draggable = ref();
let dropped = ref();
let active = ref(false);
let processing = ref(false);
let startDrag = (evt, fileId) => {
    draggable.value = fileId
}
let onDrop = (evt, fileId) => {
    if (processing.value !== true) {
        setInactive()
        dropped.value = fileId
        Inertia.post(`/file/move`, {draggable: draggable.value, dropped: dropped.value}, {
            onStart: () => setProcessingActive(),
            onFinish: () => setProcessingInactive(),
        })
    }

}

function setActive() {
    active.value = true
}

function setInactive() {
    active.value = false
}

function setProcessingInactive() {
    processing.value = false;
}

function setProcessingActive() {
    processing.value = true;
}
</script>
<style scoped>
.drop-zone {
    background-color: #eee;
    margin-bottom: 10px;
    padding: 10px;
}

.drag-el {
    background-color: #fff;

}

.drop-image {
    opacity: 30%;
    border: black 2px solid;
}
</style>
