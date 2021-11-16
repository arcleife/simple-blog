<template>
    <Head title="Blog" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Blog
            </h2>
        </template>

        <div class="pt-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div>
                            <div class="border-b border-gray-200">
                                <span class="font-semibold text-xl text-gray-800">{{ blog.title }}</span>
                            </div>
                            <div class="mt-2">
                                <pre class="text-gray-600">{{ blog.content }}</pre>
                            </div>
                            <div>
                                <span class="font-italic text-sm text-gray-400">by {{ blog.username }} ({{ blog.date }})</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="mt-2" 
                    v-if="isCreator()">
                    <button  
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                        @click="editBlog()">
                        Edit
                    </button>
                    <delete-blog
                        @remove="deleteBlog" 
                        :blog="blog"></delete-blog>
                </div>
            </div>
        </div>
        <div class="py-4">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div>
                            <div class="border-b border-gray-200">
                                <span class="font-semibold text-xl text-gray-800">Comments</span>
                            </div>
                            <div v-for="(comment, index) in comments" class="border-b py-2 border-gray-200 grid grid-cols-1">
                                <div class="mt-2">
                                    <p class="font-semibold text-md text-gray-800">{{ comment.content }}</p>
                                </div>
                                <div class="flex flex-row-reverse justify-between">
                                    <span class="font-italic text-sm text-gray-600">by {{ comment.username }} ({{ comment.date }})</span>
                                    <div class="space-x-1">
                                        <edit-comment 
                                            v-if="comment.user_id == $page.props.auth.user.id"
                                            @edit="editComment" 
                                            :comment="comment"></edit-comment>
                                        
                                        <delete-comment 
                                            v-if="comment.user_id == $page.props.auth.user.id"
                                            @remove="deleteComment" 
                                            :comment="comment"></delete-comment>
                                    </div>
                                </div>
                            </div>
                            <form @submit.prevent="postComment">
                                <div class="mt-2">
                                    <textarea 
                                        id="content" 
                                        class="mt-1 h-20 block w-full resize-none border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" 
                                        v-model="form.content" 
                                        required 
                                        autocomplete="content" />
                                </div>

                                <div class="flex items-center justify-end mt-2">
                                    <BreezeButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                        Post
                                    </BreezeButton>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import BreezeLabel from '@/Components/Label.vue'
import BreezeButton from '@/Components/Button.vue'
import DeleteBlog from '@/Modals/DeleteBlog.vue'
import DeleteComment from '@/Modals/DeleteComment.vue'
import EditComment from '@/Modals/EditComment.vue'
import { Head } from '@inertiajs/inertia-vue3';

export default {
    components: {
        BreezeAuthenticatedLayout,
        BreezeLabel,
        BreezeButton,
        DeleteBlog,
        DeleteComment,
        EditComment,
        Head,
    },

    props: {
        blog: Object,
        comments: Object
    },

    data() {
        return {
            form: {
                content: '',
                blog_id: this.blog.id,
                user_id: this.$page.props.auth.user.id
            },
        }
    },

    methods: {
        isCreator() {
            return this.blog.user_id == this.$page.props.auth.user.id;
        },

        editBlog() {
            this.$inertia.get(this.route("blog.edit", this.blog.id));
        },

        deleteBlog() {
            this.$inertia.delete(this.route("blog.delete", this.blog.id));
        },

        postComment() {
            const data = new FormData();
            data.append('content', this.form.content || '');
            data.append('blog_id', this.form.blog_id || '');
            data.append('user_id', this.form.user_id || '');
            this.$inertia.post(this.route('comment.store'), data, {
                onSuccess: () => this.form.content = '',
            });
        },
        
        editComment(comment, newContent) {
            const data = new FormData();
            data.append('content', newContent || '');
            data.append('_method', 'post');
            this.$inertia.post(this.route("comment.update", comment.id), data);
        },
        
        deleteComment(comment_id) {
            this.$inertia.delete(this.route("comment.delete", comment_id));
        }
    }
}
</script>
