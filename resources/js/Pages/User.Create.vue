<template>
    <Head title="Create User" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create User
            </h2>
        </template>
        <div class="mt-4 max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form @submit.prevent="submit">
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
                                id="role-admin" 
                                type="radio" 
                                v-model="form.role" 
                                name="role-admin" 
                                :value="ID_ADMIN"
                                :checked="form.role == ID_ADMIN" />
                            <label class="ml-1" for="role-admin">Administrator</label>
                            <BreezeInput 
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
                            <BreezeLabel for="password" value="Password" />
                            <BreezeInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />
                        </div>

                        <div class="mt-4">
                            <BreezeLabel for="password_confirmation" value="Confirm Password" />
                            <BreezeInput id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <BreezeButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Create
                            </BreezeButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import BreezeButton from '@/Components/Button.vue'
import BreezeInput from '@/Components/Input.vue'
import BreezeLabel from '@/Components/Label.vue'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';

export const ID_USER = 0;
export const ID_ADMIN = 1;

export default {
    components: {
        BreezeAuthenticatedLayout,
        BreezeButton,
        BreezeInput,
        BreezeLabel,
        BreezeValidationErrors,
        Head,
        Link,
    },

    data() {
        return {
            ID_USER: ID_USER,
            ID_ADMIN: ID_ADMIN,
            form: this.$inertia.form({
                name: '',
                email: '',
                password: '',
                role: Number,
                password_confirmation: '',
                terms: false,
            })
        }
    },

    props: {
        user: Object
    },

    methods: {
        submit() {
            this.form.post(this.route('user.store'), {
                onFinish: () => this.form.reset('password', 'password_confirmation'),
            })
        }
    },

    mounted() {
        // Set the default value for form
        this.form.role = 1;
    }
}
</script>
