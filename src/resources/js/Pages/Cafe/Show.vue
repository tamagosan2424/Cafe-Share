<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({cafe: Object});
</script>

<template>
    <Head title="詳細画面" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                カフェ詳細画面
            </h2>
        </template>
        <div class="show-container">
            <div class="show-detail-wrapper">
                <div class="show-header">
                    <h1 class="show-name">{{ cafe.name }}</h1>
                    <p class="show-address">{{ cafe.address }}</p>
                </div>

                <dl class="show-info-table">
                    <div class="show-info-row">
                        <dt>電話番号</dt>
                        <dd>{{ cafe.phone_number }}</dd>
                    </div>
                    <div class="show-info-row">
                        <dt>営業時間</dt>
                        <dd>{{ cafe.opening_at }}~{{ cafe.closing_at }}</dd>
                    </div>
                </dl>

                <div class="show-description-area">
                    <h2>カフェ紹介</h2>
                    <p>{{ cafe.description }}</p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
