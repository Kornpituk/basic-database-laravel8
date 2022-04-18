<template>
    <Link :href="link"
            class="bg-green-500 hover:bg-green-700 text-white px-6 py-4 rounded-lg"><slot /></Link>
</template>
<script setup>
import { Link } from "@inertiajs/inertia-vue3"
import { defineProps } from "vue";

defineProps({
    link:{
        type: String,
        required: true,
    }
})

</script>

