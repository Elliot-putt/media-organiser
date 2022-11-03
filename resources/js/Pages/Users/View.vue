<template>
    <Head>
        <title>Users</title>
        <meta type="description" content="Information about my app" head-key="description">
    </Head>

    <div class="row justify-content-center">
        <div class="col-10 col-md-12 mt-3">
            <TitleLayout title="Users"
                         description="This page allows you to search Users. If you Believe you should have more access please contact test@gmail.com"/>
            <div class="d-flex justify-content-end m-4">
                <Link v-if="can.createUser" href="/users/create" class="text-decoration-none my-auto mx-2">Create a new
                    User +
                </Link>
            </div>
        </div>
        <div class="col-10 col-md-12 card shadow mb-4">
            <div class=" card-body">
                <div class="d-flex mx-2">
                    <label class="me-2 my-auto">Name Filter:</label>
                    <input type="text" class="border rounded p-2" v-model="search" placeholder="Search.....">
                </div>
                <table class="table table-striped  table-hover table-responsive">
                    <thead>
                    <tr>
                        <th scope="col" class="text-purple">Name</th>
                        <th scope="col" class="text-purple d-none d-md-table-cell">Email</th>
                        <th scope="col" class="text-end text-purple">Options</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="user in users.data" :key="user.id">
                        <td v-text="user.name"></td>
                        <td class="d-none d-md-table-cell" v-text="user.email"></td>
                        <td class="text-end">
                            <Link :href="`/users/ ${user.id}/edit`">Edit</Link>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <Pagination :links="users.links"/>
            </div>
        </div>
    </div>
</template>
<script setup>
import Pagination from "../../Shared/Pagination"
import {ref, watch} from "vue";
import {Inertia} from "@inertiajs/inertia";
import throttle from "lodash/throttle"
import TitleLayout from "../../Shared/TitleLayout";
import Message from '../../Components/Message'


let props = defineProps({
    users: Object,
    filters: Object,
    can: Object
});
let search = ref(props.filters.search);

watch(search, throttle(function (value) {
    Inertia.get('/users', {search: value}, {
        preserveState: true,
        replace: true
    });
}, 500));
</script>
