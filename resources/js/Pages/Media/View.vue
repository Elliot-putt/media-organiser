<template>
    <Head>
        <title>Manage Media </title>
        <meta type="Media management" content="Information about my Media management page" head-key="Media management">
    </Head>
    <div class="row justify-content-center">
        <div class="col-10 mt-3">
            <TitleLayout title="Media"
                         description="This page allows you to manage Media. If you Believe you should have more access please contact support."/>
            <div class="d-flex justify-content-end m-4">
                <Link href="/media" class="btn btn-blue  my-auto mx-2" v-if="path !== ''">Top Level <i
                    class="fa-solid text-white fa-arrow-turn-up "></i></Link>
                <Link @click.prevent="levelUp" v-if="path !== ''" class="btn btn-green e my-auto mx-2">Up One Level <i
                    class="fa-solid text-white fa-circle-left "></i></Link>
                <Link href="#" class="btn btn-grey my-auto mx-2" @click="fileUpload">Add new Media <i
                    class="fa-solid text-white fa-plus "></i>
                </Link>
                <Link href="#" class="btn btn-grey my-auto mx-2" @click="folderCreate">Create a Folder <i
                    class="fa-solid text-white fa-plus "></i>
                </Link>
                <Link href="#" class="btn btn-red my-auto mx-2"
                      v-if="filesArray.length !== 0 || foldersArray.length !== 0"
                      @click.prevent="deleteFiles">
                    Remove Items <i
                    class="fa-solid text-white fa-trash-can "></i>

                </Link>
                <Link href="#" class="btn btn-yellow my-auto mx-2"
                      v-if="filesArray.length !== 0 || foldersArray.length !== 0"
                      @click.prevent="filesMove">
                    Move Items <i class="fa-solid text-white fa-arrow-right-arrow-left"></i>
                </Link>
            </div>
            <div class="d-flex m-3">
                <p class="text-secondary mx-2 my-auto" v-if="directories.length < 1">{{ directories.length }} Folder(s)
                    at this
                    path</p>
                <p class="btn btn-green disabled mx-2 my-auto" v-if="directories.length > 0">{{ directories.length }}
                    Folder(s)
                    at this
                    path</p>
                <p class="text-secondary mx-2 my-auto" v-if="documents.length < 1">{{ documents.length }} Document(s) at
                    this
                    path</p>
                <p class=" btn btn-green disabled mx-2 my-auto" v-if="documents.length > 0">{{ documents.length }}
                    Document(s)
                    at this
                    path</p>
            </div>

            <div class="card shadow mb-4"
                 :class="[active === true ? 'bg-primary' : 'bg-light' , processing === true || form.processing === true ? 'backdrop' : '']"
                 @drop.prevent="onDrop($event)"
                 @dragenter.prevent="setActive" @dragover.prevent="setActive" @dragleave.prevent="setInactive">
                <div class="d-flex m-2 p-2">
                    <label class="me-2 my-auto">Name Filter:</label>
                    <input type="text" class="border rounded p-2 input-search" v-model="search"
                           placeholder="Search.....">
                    <button v-if="search" class="btn btn-red  " @click.prevent="clearFilter"><i
                        class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="loader" v-if="processing || form.processing"></div>
                <div class=" card-body row justify-content-start">
                    <div v-for="folder in directories" :key="folder" class="col-md-3">
                        <div class="d-flex flex-column" style="z-index: 5">
                            <i class="fa-solid fa-folder mx-auto cursor-click" @click="nextDir(folder) "
                               :disabled="processing || form.processing"
                               style="font-size:80px"></i>
                            <div class="d-flex mx-auto ">
                                <input type="checkbox" class="my-auto" @change="toggleFolder(folder)" :id="folder">
                                <label :for="folder" class="text-secondary text-center fs-4 mx-2 my-auto">{{
                                        folder
                                    }}</label>
                            </div>
                        </div>
                    </div>
                    <div v-for="file in documents" :key="file.name" class=" col-md-3 " >
                        <div class="d-flex flex-column m-2">
                            <a class="cursor-click text-center text-decoration-none text-black" target="_blank"
                               :href="file.fullPath">
                                <i :class="[(icon(file.ext))  , 'fa-solid mx-auto'] "
                                   :disabled="processing || form.processing"
                                   style="font-size:80px"></i>
                            </a>
                            <div class="d-flex mx-auto ">
                                <input type="checkbox" class="my-auto" @change="toggleFile(file)" :id="file.name">
                                <label :for="file.name" class="text-secondary text-center fs-4 mx-2 my-auto">{{
                                        file.name
                                    }}</label>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="row justify-content-center m-4" v-if="documents.length < 1 && directories.length < 1">
                    <div class="d-flex flex-column col-4">
                        <h3 class="text-secondary text-center">No Items within the Folder click add folder or drag and
                            drop
                            files to begin...</h3>
                        <Link href="/media"
                              class="fa-solid fa-arrows-rotate text-center text-purple text-decoration-none"
                              style="font-size: 70px"></Link>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script setup>
import {computed, ref, watch} from 'vue'
import {usePage} from '@inertiajs/inertia-vue3'
import {Inertia} from "@inertiajs/inertia";
import {useForm} from "@inertiajs/inertia-vue3"
import Swal from "sweetalert2";
import TitleLayout from "../../Shared/TitleLayout";
import throttle from "lodash/throttle"

let emit = defineEmits(["onDrag"]);
let active = ref(false);
let processing = ref(false);
let page = usePage().props.value;
let path = ref(page.path ?? '');
let filesArray = ref([]);
let foldersArray = ref([]);
let search = ref(props.filters.search);

let props = defineProps({
    directories: Array,
    documents: Object,
    path: String,
    filters: Object,
});
//search bar
watch(search, throttle(function (value) {
    Inertia.get(`/media?path=${path.value}`, {search: value}, {
        preserveState: true,
        replace: true
    });
}, 500));

let clearFilter = () => {
    search.value = '';
}


//form for uploading files
let form = useForm({
    files: Array,
    path: path.value,
});
//form for deleting files
let formDelete = useForm({
    filesDeleted: filesArray.value,
    foldersDeleted: foldersArray.value,
    path: path.value,
    dir: '',
});

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

let onDrop = (e) => {
    setInactive()
    form.files = e.dataTransfer.files
    form.post(`/media/upload/`, form, {
        preserveState: true,
        preserveScroll: true
    });
}
let nextDir = (dirName) => {
    setProcessingActive();
    //add slashes in the correct places
    page.path = page.path + dirName + '/'
    Inertia.get(`/media`, {path: page.path}, {
        preserveScroll: true
    });
}

let levelUp = () => {
    setProcessingActive();
    Inertia.get(`/media/levelup`, {path: page.path}, {
        preserveScroll: true
    });
}

let toggleFile = (file) => {
    let index = filesArray.value.indexOf(file.name);
    if (index !== -1) {
        filesArray.value.splice(index, 1)
    } else {
        filesArray.value.push(file.name);
    }
}
let toggleFolder = (folder) => {
    let index = foldersArray.value.indexOf(folder);
    if (index !== -1) {
        foldersArray.value.splice(index, 1)
    } else {
        foldersArray.value.push(folder);
    }
}
let deleteFiles = () => {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#777',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            Inertia.post(`/media/delete/`, formDelete);
            Swal.fire(
                'Deleted!',
                'Your files has been deleted.',
                'success'
            )
        }
    })
}
let fileUpload = async () => {
    const {value: file} = await Swal.fire({
        title: 'Select a File for upload',
        input: 'file',
        inputAttributes: {
            'multiple': 'multiple',
            'aria-label': 'Upload your profile picture'
        }
    })

    if (file) {
        form.files = file
        form.post(`/media/upload/`, form, {
            preserveState: true,
            preserveScroll: true
        });
        Swal.fire(
            'Your File Will be Processed shortly',
            'Sit tight were working on it...',
            'success'
        )

    } else {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!',
            footer: '<a href="/">Why do I have this issue?</a>'
        })
    }
}
let folderCreate = () => {
    Swal.fire({
        title: 'Enter a Folder name',
        input: 'text',
        inputAttributes: {
            autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonText: 'Create',
        showLoaderOnConfirm: true,
        preConfirm: (folder) => {
            return fetch(`/media/folder/${folder}?path=${page.path}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText)
                    }

                    return response.json()
                })
                .catch(error => {
                    Swal.showValidationMessage(
                        `This Directory is invalid or already exists!`
                    )
                })
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            Inertia.post(`/media/folder/create/${result.value}?path=${page.path}`)
            Swal.fire({
                title: `${result.value} Directory Has been Created`,
            })
        }
    })
}
//moving files
let filesMove = () => {
    Swal.fire({
        title: 'Enter a Folder Name to migrate documents to',
        input: 'text',
        inputAttributes: {
            autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonText: 'Look up',
        showLoaderOnConfirm: true,
        preConfirm: (folder) => {
            return fetch(`/media/folder/${folder}/check`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText)
                    }
                    return response.json()
                })
                .catch(error => {
                    Swal.showValidationMessage(
                        // `Request failed: ${error}`
                        `No Directory found please create one or search again!`
                    )
                })
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        console.log();
        if (result.isConfirmed) {
            formDelete.dir = result.value[1];
            Inertia.post(`/media/folder/move/`, formDelete)
            Swal.fire({
                title: `Files have been moved to ${result.value[0]} successfully!`,
            })
        }
    })
}


const icon = computed(async => (ext) => {
    switch (ext) {
        default:
            return "fa-file-circle-question";
        case 'pdf':
            return "fa-file-pdf";
        case 'txt':
            return "fa-file-lines";
        case 'png':
            return "fa-image";
        case 'jpeg':
            return "fa-image";
        case 'jpg':
            return "fa-image";
        case 'svg':
            return "fa-image";
        case 'docx':
            return "fa-file-word";
        case 'doc':
            return "fa-file-word";
    }
});
</script>

