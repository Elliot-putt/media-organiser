<template>
    <div id="app">
        <Editor v-model="form.description" api-key="1pwifg6yi8kznrm8fx3n591y166a1gnuj5atlt4rlaawk0jk"
            :init="{
        plugins: 'lists link image table code help ',  branding: false
      }"
        />
    </div>
</template>

<script setup>
import Editor from '@tinymce/tinymce-vue'
import {useForm} from "@inertiajs/inertia-vue3";

let form = useForm({
    description:'',
})
</script>
