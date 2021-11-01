<template>
    <Head title="User" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ user.name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="updateUser">
                            <div>
                                <BreezeLabel for="name" value="Name" />
                                <BreezeInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name" />
                            </div>

                            <div class="mt-4">
                                <BreezeLabel for="email" value="Email" />
                                <BreezeInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autocomplete="username" />
                            </div>

                            <div class="mt-4">
                                <BreezeLabel for="role" value="Role" />
                                <BreezeInput 
                                    :disabled="isCurrentUser()"
                                    id="role-admin" 
                                    type="radio" 
                                    v-model="form.role" 
                                    name="role-admin" 
                                    :value="ID_ADMIN"
                                    :checked="form.role == ID_ADMIN" />
                                <label class="ml-1" for="role-admin">Administrator</label>
                                <BreezeInput 
                                    :disabled="isCurrentUser()"
                                    id="role-user"
                                    class="ml-4" 
                                    type="radio" 
                                    v-model="form.role" 
                                    name="role-user" 
                                    :value="ID_USER"
                                    :checked="form.role == ID_USER" />
                                <label class="ml-1" for="role-user">User</label>
                            </div>

                            <div class="mt-4">
                                <BreezeLabel for="password" value="New Password" />
                                <BreezeInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" autocomplete="password" />
                            </div>

                            <div class="mt-4">
                                <BreezeLabel for="password_confirmation" value="Confirm New Password" />
                                <BreezeInput id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" autocomplete="password" />
                            </div>
                        </form>
                        <div class="flex mt-4">
                            <button  
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                                @click="updateUser()">
                                Update
                            </button>                            
                            <delete-user
                                v-if="!isCurrentUser()"
                                @remove="deleteUser" 
                                :user="user"></delete-user>
                        </div>
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
import DeleteUser from '@/Modals/DeleteUser.vue'
import { Head } from '@inertiajs/inertia-vue3';

export const ID_USER = 0;
export const ID_ADMIN = 1;

export default {
    components: {
        BreezeAuthenticatedLayout,
        BreezeInput,
        BreezeLabel,
        DeleteUser,
        Head,
    },

    data() {
        return {
            ID_USER: ID_USER,
            ID_ADMIN: ID_ADMIN,
            form: this.$inertia.form({
                name: '',
                email: '',
                role: Number,
                password: '',
                password_confirmation: ''
            })
        }
    },

    props: {
        user: Object
    },

    methods: {
        getRole() {
            return this.user.role == 1 ? 'Administrator':'User';
        },

        isCurrentUser() {
            return this.user.id == this.$page.props.auth.user.id;
        },

        updateUser() {
            this.form.put(this.route("user.update", this.user.id), {
                onError: () => this.form.reset('password', 'password_confirmation'),
            });
        },

        deleteUser() {
            this.$inertia.delete(this.route("user.delete", this.user.id));
        }
    },

    mounted() {
        this.form.name = this.user.name;
        this.form.email = this.user.email;
        this.form.role = this.user.role;
    }
}
</script>
