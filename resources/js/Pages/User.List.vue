<template>
    <Head title="User List" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                User List
            </h2>
        </template>

        <div class="py-12">
            <div class="mb-2 max-w-4xl mx-auto sm:px-6 lg:px-8">
                <button 
                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                    @click="createUser()">
                    + Create user
                </button>
            </div>
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <table class="w-full whitespace-no-wrap">
                            <tr class="text-left font-bold">
                                <th class="px-6 pt-6 pb-4">Username</th>
                                <th class="px-6 pt-6 pb-4">Mail Address</th>
                                <th class="px-6 pt-6 pb-4" colspan="2">Role</th>
                            </tr>
                            <tr v-for="user in users" :key="user.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                                <td class="border-t">
                                    <Link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('user.edit', user.id)">
                                        {{ user.name }}
                                    </Link>
                                </td>
                                <td class="border-t">
                                    <Link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('user.edit', user.id)">
                                        {{ user.email }}
                                    </Link>
                                </td>
                                <td class="border-t">
                                    <Link v-if="isAdmin(user.role)" class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('user.edit', user.id)">
                                        Administrator
                                    </Link>
                                    <Link v-else class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('user.edit', user.id)">
                                        User
                                    </Link>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head } from '@inertiajs/inertia-vue3';

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
        Link,
    },

    props: {
        users: Array
    },

    methods: {
        createUser() {
            this.$inertia.get(this.route("user.create"));
        },
        isAdmin(role) {
            return !!role;
        }
    }
}
</script>
