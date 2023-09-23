<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    generatedToken: {
        type: String,
        required: false,
        default: null
    },
    tokens: Array
})

const form = useForm({
    name: '',
})

const handleSubmit = async () => {
    form.post(route('project.store'), {
        onSuccess: () => form.reset()
    })
}

const handleCopy = () => {
    navigator.clipboard.writeText(props.generatedToken)
}

</script>

<template>
    <Head title="Projects" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Projects</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-10 pb-10 pt-4">
                    <h4 class="text-semibold text-lg text-gray-500 darK:text-gray-200 py-4">Create New Access Project</h4>
                    <form @submit.prevent="handleSubmit">
                        <div class="md:flex justify-between align-center gap-12">
                            <InputLabel for="name" value="Name" />

                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                required
                                autofocus
                                autocomplete="My Project"
                            />

                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>

                        <div class="flex justify-center pt-5">
                            <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Create Token
                            </PrimaryButton>
                        </div>

                        <div v-if="generatedToken">
                            <div>
                                <p class="text-gray-500">Token generated: </p>
                                <p>{{generatedToken}}</p>
                            </div>
                            <button type="button" @click.prevent="handleCopy" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                                Copy
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-8">
                    <h3 class="font-semibold text-2xl text-center pb-4 text-gray-800 text-gray-200">My Access Projects</h3>
                    <div class="grid gap-6 grid-cols-1 md:grid-cols-3">
                        <div class="relative max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700" v-for="token in tokens" :key="token">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{token.name}}</h5>
                            <div class="absolute bottom-0 right-0 p-4">
                                <Link :href="route('project.destroy', [token.id])" as="button" method="delete" class="text-red-600 dark:text-red-400">Revoke</Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
