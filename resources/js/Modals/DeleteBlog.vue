<template>
    <button
        class="ml-2 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150" 
        @click="modalOpen = true">
        Delete
    </button>
    <teleport to="body">
        <div v-if="modalOpen" class="modal fixed w-full h-full top-0 left-0 flex items-center justify-center">
            <div @click="modalOpen = false" class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
            <div class="modal-container p-4 bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
                <div class="flex justify-center items-center pb-3">
                    <p class="text-lg font-bold">Are you sure you want to delete this blog?</p>
                </div>

                <div class="flex flex-col justify-center items-center p-2">
                    <div class="text-sm text-gray-500">
                        <p>
                        {{ blog.title }}
                        </p>
                    </div>
                </div>

                <div class="flex justify-end pt-2 space-x-2">
                    <div>
                        <a @click="modalOpen = false" class="cursor-pointer inline-flex items-center rounded-lg border border-teal-700 h-8 px-4 text-sm text-teal-700 transition-colors duration-150 bg-white focus:shadow-outline hover:bg-teal-500 hover:text-teal-100">
                            Cancel
                        </a>
                    </div>

                    <div>
                        <button type="button" @click="$emit('remove')" class="rounded-lg h-8 px-4 text-sm text-white transition-colors duration-150 bg-red-600 focus:shadow-outline hover:bg-red-500">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </teleport>
</template>

<script>
    export default {
        name: 'DeleteBlog',
        props: {
            blog: Object
        },

        data() {
            return {
            modalOpen: false
            }
        },

        emits: [
            "remove"
        ],
    }
</script>