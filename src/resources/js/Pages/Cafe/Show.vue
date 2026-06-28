<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({ cafe: { type: Object, required: true } });
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
                <div class="cafe-img-placeholder">
                    <img
                        v-if="cafe.image"
                        :src="`/storage/${cafe.image}`"
                        :alt="cafe.name"
                        class="cafe-img"
                    >
                    <span v-else class="cafe-img-icon">☕</span>
                </div>
                <div class="show-header">
                    <h1 class="show-name">{{ cafe.name }}</h1>
                    <p class="show-address">{{ cafe.address }}</p>
                </div>

                <dl class="show-info-table">
                    <div class="show-info-row">
                        <dt>電話番号</dt>
                        <dd>{{ cafe.phone_number ?? '未登録' }}</dd>
                    </div>
                    <div class="show-info-row">
                        <dt>営業時間</dt>
                        <dd>{{ cafe.opening_at ? cafe.opening_at.slice(0,5) : '未登録' }}～{{ cafe.closing_at ? cafe.closing_at.slice(0,5) : '未登録' }}</dd>
                    </div>
                </dl>

                <div class="show-description-area">
                    <h2>カフェ紹介</h2>
                    <p>{{ cafe.description }}</p>
                </div>
                <Link :href="route('cafes.index')" class="btn-cancel">一覧に戻る</Link>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
