<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    cards: Array
})

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <h3 class="text-xl font-semibold text-center m-6">Test Credit Cars</h3>

                    <div class="grid grid-cols-3">
                        <div></div>
                        <ul class="col-span-2 max-w-md divide-y divide-gray-200 dark:divide-gray-700">
                            <li class="py-3 sm:pb-4" v-for="card, key in cards" :key="key">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <i :class="card.icon"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                        {{card.number}}
                                        </p>
                                        <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                        {{card.cvv}}
                                        </p>
                                    </div>
                                    <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                        {{card.status}}
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
