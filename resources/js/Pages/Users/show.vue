<template>
    <main class='mt-3 container'>
        <TitleLayout title="Create new Company" description="This Page allows you to view a users details. If you have any queries please contact the web development team on sc@clpt.co.uk."/>
        <div class='card shadow mb-4'>
            <div class='card-body row justify-content-evenly'>
                <div class='col-12 col-md-4'>
                    <div class="box bg-light">
                        <div class="bg-white p-1 m-0">
                            <p class='text-center'>Profile Picture</p>
                        </div>
                        <div class="p-2 px-5 border-top border-secondary border-2 h-100 d-flex justify-content-center align-items-center flex-column">
                            <img
                                src="#"
                                width="100%"
                                class="rounded border border-secondary mb-4"
                                alt="profile image">
                        </div>
                    </div>
                </div>

                <div class='col-12 col-md-4'>
                    <div class="box bg-light">
                        <div class="bg-white p-1 m-0">
                            <p class='text-center'>Information</p>
                        </div>
                        <div class="bg-light p-4 border-top border-secondary border-2 min-box text-center d-flex justify-content-center align-items-center flex-column">

                            <div class="mb-4">
                                <h4>{{user.name}}</h4>
                                <hr class="m-0 p-0 w-25 mx-auto">
                                <div class="model_title text-center h4 mb-1">
                                    <strong>Name:</strong> {{user.name}}
                                </div>
                                <p class="mb-3"><a href="mailto:{{user.email}}">{{user.email}}</a></p>
                            </div>
                            <div class="mb-4">
                                <h4 class="mb-3">Account Information</h4>
                                <p>Created: {{user.created_at}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='col-12 col-md-4'>
                    <div class="box bg-light">
                        <div class="bg-white p-1 m-0">
                            <p class='text-center'>Location</p>
                        </div>
                        <div class="bg-light p-4 border-top border-secondary border-2 min-box">
                            <div
                                class="model_title text-center h4 mb-1"></div>
                            <div
                                class="model_image p-4 d-flex justify-content-center align-items-middle">
                                <img id="profileImage"
                                     src="#"
                                     height="125px" alt="Select Profile Picture">
                            </div>
                            <div class="model_no py-2 px-4 text-center">

                                <small>

                                </small>
                            </div>
                            <div class="model_no py-2 px-4 text-center">

                            </div>
                            <div class="model_no py-2 px-4 text-center">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script setup>
import TitleLayout from "../../Shared/TitleLayout";
defineProps({
    user :Object
})
</script>


