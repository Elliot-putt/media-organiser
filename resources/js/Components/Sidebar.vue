<template>
    <transition name="slide">
        <div v-if="isPanelOpen" class="sidebar-panel  vh-100 bg-blue d-inline-flex flex-column" style="z-index: 100">
            <div class="mb-3">
                <Link  as="h3" href="/" class=" text-center cursor-click"><img class="img-small" :src="image"></Link>
            </div>
            <slot></slot>
        </div>
    </transition>
</template>

<script setup>
import image from "../../../public/images/singlemedialogo.png"

defineProps({
    isPanelOpen: Boolean,
})
</script>

