<template>
    <Head>
        <title>Create User</title>
        <meta type="description" content="Creating a user in my app" head-key="description">
    </Head>
    <Alerts/>
    <h3>Create new User</h3>
    <form @submit.prevent="submit">
        <div class="row justify-content-center">

            <div class="col-10">
                <div class="card shadow mt-4">
                    <div class="card-body row justify-content-center">
                        <div class="col-6">
                            <div class="d-flex">
                                <label for="name" class="form-label fw-bold">Name</label>
                                <div v-if="form.errors.name" v-text="' - ' + form.errors.name"
                                     class=" text-danger fs-6 mx-2"></div>
                            </div>

                            <div class="input-group mb-3">
                                <input type="text" name="name" class="form-control"
                                       :class="form.errors.name ? 'border-danger' : '' " id="name"
                                       placeholder="Please enter a name" v-model="form.name">

                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex">
                                <label for="email" class="form-label fw-bold">Email</label>
                                <div v-if="form.errors.email" v-text="' - ' + form.errors.email"
                                     class="text-danger fs-6 mx-2"></div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="email" name="email" class="form-control"
                                       :class="form.errors.email ? 'border-danger' : '' " id="email"
                                       placeholder="Please enter a valid email" v-model="form.email">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex">
                                <label for="username" class="form-label fw-bold">Username</label>
                                <div v-if="form.errors.username" v-text="' - ' + form.errors.username"
                                     class=" text-danger fs-6 mx-2"></div>
                            </div>

                            <div class="input-group mb-3">
                                <input type="text" name="username" class="form-control"
                                       :class="form.errors.username ? 'border-danger' : '' " id="username"
                                       placeholder="Please enter a username" v-model="form.username">

                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex">
                                <label for="password" class="form-label fw-bold">Password</label>
                                <div v-if="form.errors.password" v-text="' - ' + form.errors.password"
                                     class="text-danger fs-6 mx-2"></div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="password" name="password" class="form-control"
                                       :class="form.errors.password ? 'border-danger' : '' " id="password"
                                       placeholder="Please enter a Password" v-model="form.password">
                            </div>
                        </div>
                        <div class="col-md-1 offset-md-10">
                            <button class="btn btn-success" :disabled="form.processing">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
</template>

<script setup>
import {useForm} from "@inertiajs/inertia-vue3"
import Alerts from '../../Components/Alerts'

let form = useForm({
    name: '',
    username: '',
    email: '',
    password: '',
});
let submit = () => {

    form.post('/users');
}
</script>
