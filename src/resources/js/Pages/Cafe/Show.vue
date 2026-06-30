<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({ cafe: { type: Object, required: true } }); // propsに変更

// レビュー投稿フォーム
const form = useForm({
    rating: '',
    comment: '',
});

const submitReview = () => {
    form.post(route('reviews.store', props.cafe.id), {
        onSuccess: () => form.reset(), // 投稿成功後にフォームをリセット
    });
};
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
                <Link :href="route('cafes.edit', cafe.id)" class="btn-edit">編集する</Link>
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
                <!-- レビュー一覧 -->
                <div class="review-list-area">
                    <h2>レビュー一覧（{{ cafe.reviews_count }}件）</h2>
                    <p v-if="cafe.reviews.length === 0">まだレビューがありません</p>
                    <div v-for="review in cafe.reviews" :key="review.id" class="review-item">
                        <div class="review-item-header">
                            <span class="review-rating">★{{ review.rating }}</span>
                            <span class="review-user">{{ review.user.name }}</span>
                        </div>
                        <p class="review-comment">{{ review.comment }}</p>
                    </div>
                </div>
                <!-- レビュー投稿フォーム -->
                <div class="review-form-area">
                    <h2>レビューを投稿する</h2>
                    <form @submit.prevent="submitReview">
                        <div>
                            <label>評価（1〜5）</label>
                            <select v-model="form.rating">
                                <option value="">選択してください</option>
                                <option v-for="n in 5" :key="n" :value="n">★{{ n }}</option>
                            </select>
                            <p v-if="form.errors.rating" class="form-error">{{ form.errors.rating }}</p>
                        </div>
                        <div>
                            <label>コメント</label>
                            <textarea v-model="form.comment" placeholder="感想を書いてください" rows="3"></textarea>
                        </div>
                        <button type="submit" :disabled="form.processing">投稿する</button>
                    </form>
                </div>
                <Link :href="route('cafes.index')" class="btn-cancel">一覧に戻る</Link>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
