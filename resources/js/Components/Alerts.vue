<template>
    <Message sessionKey="danger_message" class="alert-colour-danger" v-if="$page.props.flash.danger_message"/>
    <Message sessionKey="success_message" class="alert-colour-success" v-if="$page.props.flash.success_message"/>
    <Errors/>
</template>

<script setup>
import Message from './Message'
import Errors from './Errors'


</script>

