<template lang="">
    <div>
        <admin-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Movie Edit Attach
            </h2>
        </template>

        <div class="py-2">
            <div class="max-w-7xl mx-auto">
                <section class="container mx-auto p-6 font-mono">
                    <div class="w-full flex mb-4 p-2">
                        <Link :href="route('admin.movies.index')"
                            class="bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded-lg">Movie Index</Link>
                    </div>

                    <div class="w-full sm:max-w-md mb-8 p-6 overflow-hidden bg-white rounded-lg shadow-lg">
                        <div class="flex space-x-2">
                            <div v-for="trailer in trailers" :key="trailer.id">
                                <Link 
                                    class="px-4 py-2 bg-red-500 hover:bg-red-700 rounded"
                                    :href="route('admin.trailers.destroy' ,trailer.id)" 
                                    method="delete" as="buttom" 
                                    type="button">
                                {{ trailer.name }}
                                </Link>
                            </div>
                        </div>
                        <form @submit.prevent="submitTrailer">
                            <div>
                                <jet-label for="name" value="Name" />
                                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name" />
                                <div class="text-sm text-red-400" v-if="form.errors.name">{{ form.errors.name }}</div>
                            </div>

                            <div class="mt-4">
                                <jet-label for="embed_html" value="Embed" />
                                <textarea id="embed_html" type="text" class="mt-1 block w-full" v-model="form.embed_html" required ></textarea>
                                <div class="text-sm text-red-400" v-if="form.errors.embed_html">{{ form.errors.embed_html }}</div>
                            </div>

                            <div class="flex items-center justify-end mt-4">

                                <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    add trailer
                                </jet-button>
                            </div>
                        </form>
                    </div>

                    <div class="w-full sm:max-w-md mb-8 p-6 bg-white rounded-lg shadow-lg">
                        casts
                    </div>

                     
                    
                        
                    <div class="w-full sm:max-w-md mb-8 p-6 overflow-hidden bg-white rounded-lg shadow-lg">
                    Tags From
                    </div>

                </section>
            </div>
        </div>
    </admin-layout>
    </div>
</template>
<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Link, useForm} from "@inertiajs/inertia-vue3";
import { ref, watch, defineProps } from 'vue';
import JetButton from '@/Jetstream/Button.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetCheckbox from '@/Jetstream/Checkbox.vue'
import JetLabel from '@/Jetstream/Label.vue'
import Multiselect from '@vueform/multiselect'


const props = defineProps({
    movie: Object,
    trailers: Array,
    casts: Array,
    tags: Array,
    movieTags:Array,
    movieCasts:Array,
});

const value = [];
const options = ['Batman', 'Robin', 'Joker'];



const form = useForm({
    name: ' ',
    embed_html: ''
});




function submitTrailer() {
    form.post(`/admin/movies/${props.movie.id}/add-trailer`, {
        onSuccess: () => form.reset(),
    });
}

function addCast(){
    castForm.post(`/admin/movies/${props.movie.id}/add-casts`, {
        preserveState: true,
        preserveScroll: true,
        // onSuccess: () => castForm.reset(),
    });
}
</script >

<style src="@vueform/multiselect/themes/default.css"></style>