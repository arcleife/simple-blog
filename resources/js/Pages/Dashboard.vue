<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mb-2 max-w-4xl mx-auto sm:px-6 lg:px-8">
                <button 
                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                    @click="createBlog()">
                    + Create blog
                </button>
            </div>
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200 grid grid-cols-1 divide-y divide-gray-400">
                        <div v-for="blog in blogs">
                            <div
                                class="cursor-pointer hover:bg-gray-100 focus-within:bg-gray-100" 
                                @click="blogDetails(blog.id)">
                                <div>
                                    <span class="font-semibold text-xl text-gray-800">{{ blog.title }}</span>
                                </div>
                                <div>
                                    <span class="font-italic text-sm text-gray-600">by {{ blog.username }} ({{ blog.date }})</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head } from '@inertiajs/inertia-vue3';

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
    },

    props: {
        blogs: Object
    },

    methods: {
        createBlog() {
            this.$inertia.get(this.route("blog.create"));
        },

        blogDetails(blog_id) {
            this.$inertia.get(this.route("blog", blog_id));
        }
    }
}
</script>
