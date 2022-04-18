<template lang="">
    <div>
        <Head :title="`${cast.name} Actor`" />
        <FontLayout>
                <main v-if="cast" class="my-2">
                    <section class="bg-gradient-to-r from-indigo-700 to-transparent">
                        <div class="max-w-6xl mx-auto m-4 p-2">
                            <div class="flex">
                                <div class="w-3/12">
                                    <div class="w-full">
                                        <img class="w-full h-full rounded"
                                            :src="`https://www.themoviedb.org/t/p/w220_and_h330_face/${cast.poster_path}`">
                                    </div>
                                </div>
                                <div class="w-8/12">
                                    <div class="m-4 p-6">
                                        <h1 class="flex text-white font-bold text-4xl">Actor: {{ cast.name }}</h1>
                                        <div class="flex p-3 text-white space-x-4">
                                            <!-- <span>Movies: {{ moives.length }}</span> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="max-w-6xl mx-auto bg-gray-200 dark:bg-gray-900 p-2 rounded">
                        <div class="flex justify-between">
                            <div class="w-7/12">
                                <h1 class="flex text-white font-bold text-xl">{{cast.name}} Movies</h1>
                                <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mt-4">
                                        <MovieCard v-for="movie in movies.data" :key="movie.id">
                                            <template #image>
                                                <Link :href="`/movies/${movie.slug}`">
                                                    <img class=""
                                                        :src="`https://www.themoviedb.org/t/p/w220_and_h330_face/${movie.poster_path }`">
                                                </Link>
                                            </template>
                                            <Link :href="`/movies/${episode.slug}`">
                                                <span class="text-white">{{ movie.title }}</span>
                                            </Link>
                                        </MovieCard>
                                </div>
                            </div>
                        </div>
                    </section>
                </main>
        </FontLayout>
    </div>
</template>
<script setup>
import FontLayout from '@/Layouts/FontLayout';
import MovieCard from '@/Components/MovieCard';
import Pagination from '@/Components/Pagination';
import { Link,Head } from '@inertiajs/inertia-vue3';



defineProps({
        movies:Array,
        cast:Object,
});

</script>
<style lang="">
    
</style>