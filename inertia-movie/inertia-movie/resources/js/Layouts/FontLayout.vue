<template>
    <div>
        <Head :title="title" />

        <jet-banner />

        <div class="min-h-screen bg-gray-100 dark:bg-gray-800">
            <!-- nav -->
            <Navbar></Navbar>
            <!-- Page Content -->
            <main>
                <slot></slot>
            </main>
            
        </div>
        <!-- Footer -->
            <Footer></Footer>
    </div>
</template>

<script>
    import { defineComponent } from 'vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import Navbar from "@/components/Navbar"
    import Footer from "@/components/Footer"

    export default defineComponent({
        props: {
            title: String,
        },

        components: {
            Head,
            Link,
            Navbar,
            Footer
        },

        // data() {
        //     return {
        //         showingNavigationDropdown: false,
        //     }
        // },

        // methods: {
        //     switchToTeam(team) {
        //         this.$inertia.put(route('current-team.update'), {
        //             'team_id': team.id
        //         }, {
        //             preserveState: false
        //         })
        //     },

        //     logout() {
        //         this.$inertia.post(route('logout'));
        //     },
        // }
    })
</script>
