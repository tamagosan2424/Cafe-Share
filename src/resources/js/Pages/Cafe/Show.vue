<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    cafe: { type: Object, required: true },
    canEdit:   { type: Boolean, default: false },
});

// レビュー投稿フォーム
const form = useForm({
    rating: '',
    comment: '',
});

const submitReview = () => {
    form.post(route('reviews.store', props.cafe.id), {
        onSuccess: () => form.reset(),
    });
};

// メニュー画像プレビュー
const menuPreviewUrl = ref(null);

// メニュー投稿フォーム
const menuForm = useForm({
    name:        '',
    description: '',
    price:       '',
    image:       null,
});

const onMenuImageChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        menuForm.image = file;
        menuPreviewUrl.value = URL.createObjectURL(file);
    }
};

const submitMenu = () => {
    menuForm.post(route('menus.store', props.cafe.id), {
        onSuccess: () => {
            menuForm.reset();
            menuPreviewUrl.value = null;
        },
    });
};

// メニュー削除
const deleteMenu = (menuId) => {
    if (confirm('このメニューを削除しますか？')) {
        router.delete(route('menus.destroy', { cafe: props.cafe.id, menu: menuId }));
    }
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
                <Link v-if="canEdit" :href="route('cafes.edit', cafe.id)" class="btn-edit">
                    編集する
                </Link>
                <div class="cafe-img-placeholder">
                    <img
                        v-if="cafe.image"
                        :src="`${cafe.image}`"
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

                <!-- メニュー一覧 -->
                <div class="menu-list-area">
                    <h2>メニュー（{{ cafe.menus ? cafe.menus.length : 0 }}件）</h2>
                    <p v-if="!cafe.menus || cafe.menus.length === 0">まだメニューが登録されていません</p>
                    <div class="menu-grid">
                        <div v-for="menu in cafe.menus" :key="menu.id" class="menu-card">
                            <div class="menu-img-wrap">
                                <img v-if="menu.image" :src="menu.image" :alt="menu.name" class="menu-img" />
                                <span v-else class="menu-img-placeholder">🍽️</span>
                            </div>
                            <div class="menu-info">
                                <p class="menu-name">{{ menu.name }}</p>
                                <p class="menu-price">¥{{ Number(menu.price).toLocaleString() }}</p>
                                <p v-if="menu.description" class="menu-description">{{ menu.description }}</p>
                            </div>
                            <button
                                v-if="canEdit"
                                type="button"
                                @click="deleteMenu(menu.id)"
                                class="menu-delete-btn"
                            >削除</button>
                        </div>
                    </div>
                </div>

                <!-- メニュー投稿フォーム（編集権限ありの場合のみ表示） -->
                <div v-if="canEdit" class="menu-form-area">
                    <h2>メニューを追加する</h2>
                    <form @submit.prevent="submitMenu" class="menu-form">
                        <!-- メニュー名 -->
                        <div class="menu-form-group">
                            <label class="menu-form-label">メニュー名<span class="required">*</span></label>
                            <input
                                v-model="menuForm.name"
                                type="text"
                                class="menu-form-input"
                                placeholder="例：カフェラテ"
                            />
                            <p v-if="menuForm.errors.name" class="form-error">{{ menuForm.errors.name }}</p>
                        </div>
                        <!-- 価格 -->
                        <div class="menu-form-group">
                            <label class="menu-form-label">価格（円）<span class="required">*</span></label>
                            <input
                                v-model="menuForm.price"
                                type="number"
                                min="0"
                                class="menu-form-input"
                                placeholder="例：580"
                            />
                            <p v-if="menuForm.errors.price" class="form-error">{{ menuForm.errors.price }}</p>
                        </div>
                        <!-- 説明 -->
                        <div class="menu-form-group">
                            <label class="menu-form-label">説明</label>
                            <textarea
                                v-model="menuForm.description"
                                class="menu-form-input menu-form-textarea"
                                placeholder="例：濃厚なエスプレッソにスチームミルクを合わせた一杯"
                                rows="2"
                            ></textarea>
                        </div>
                        <!-- 画像 -->
                        <div class="menu-form-group">
                            <label class="menu-form-label">メニュー画像</label>
                            <div v-if="menuPreviewUrl" class="menu-preview-wrap">
                                <img :src="menuPreviewUrl" alt="プレビュー" class="menu-preview-img" />
                            </div>
                            <input type="file" accept="image/*" @change="onMenuImageChange" class="menu-file-input" />
                            <p v-if="menuForm.errors.image" class="form-error">{{ menuForm.errors.image }}</p>
                        </div>
                        <!-- 送信ボタン -->
                        <div class="menu-form-actions">
                            <button type="submit" class="btn-submit" :disabled="menuForm.processing">
                                メニューを追加する
                            </button>
                        </div>
                    </form>
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
