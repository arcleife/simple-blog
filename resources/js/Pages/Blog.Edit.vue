<template>
    <Head title="Edit Blog" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Blog
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="update">
                            <div>
                                <BreezeLabel for="title" value="Title" />
                                <BreezeInput id="title" type="text" class="mt-1 block w-full" v-model="form.title" required autofocus autocomplete="title" />
                            </div>

                            <div class="mt-2">
                                <BreezeLabel for="content" value="Content" />
                                <textarea id="content" class="mt-1 h-40 block w-full resize-none border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" v-model="form.content" required autocomplete="content" />
                            </div>

                            <div class="mt-2">
                                <BreezeLabel for="categories" value="Categories" />
                                <BreezeInput id="categories" type="text" class="mt-1 block w-full" v-model="form.categories" autocomplete="categories" />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <BreezeButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Update
                                </BreezeButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import BreezeInput from '@/Components/Input.vue'
import BreezeLabel from '@/Components/Label.vue'
import BreezeButton from '@/Components/Button.vue'
import { Head } from '@inertiajs/inertia-vue3';

export default {
    components: {
        BreezeAuthenticatedLayout,
        BreezeInput,
        BreezeLabel,
        BreezeButton,
        Head,
    },

    props: {
        blog: Object
    },

    data() {
        return {
            form: this.$inertia.form({
                title: '',
                content: '',
                categories: ''
            })
        }
    },

    methods: {
        update() {
            this.form.put(this.route('blog.update', this.blog.id));
        }
    },

    mounted() {
        this.form.title = this.blog.title;
        this.form.content = this.blog.content;
    },
}
</script>
