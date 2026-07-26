<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue';
const props = defineProps({
    cafe: { type: Object, required: true },
    canEdit: { type: Boolean, default: false },
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
            closeMenuModal();
        },
    });
};

// メニュー削除
const deleteMenu = (menuId) => {
    if (confirm('このメニューを削除しますか？')) {
        router.delete(route('menus.destroy', { cafe: props.cafe.id, menu: menuId }));
    }
};

// モーダルの開閉状態を管理
const isMenuModalOpen = ref(false);

const openMenuModal = () => { isMenuModalOpen.value = true; };
const closeMenuModal = () => {
    isMenuModalOpen.value = false;
    menuForm.reset();
    menuPreviewUrl.value = null;
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

                <!-- カフェ画像とGoogle Mapを横並び -->
                <div class="cafe-img-map-row">
                    <div class="cafe-img-placeholder">
                        <img
                            v-if="cafe.image"
                            :src="`${cafe.image}`"
                            :alt="cafe.name"
                            class="cafe-img"
                        >
                        <span v-else class="cafe-img-icon">☕</span>
                    </div>

                    <!-- Google Maps Embed API（iframeで埋め込み） -->
                    <div class="cafe-map-area">
                        <iframe
                            :src="`https://maps.google.co.jp/maps?q=${encodeURIComponent(cafe.name + ' ' + cafe.address)}&output=embed&hl=ja`"
                            width="100%"
                            height="100%"
                            style="border:0; border-radius:8px;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                        ></iframe>
                    </div>
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
                    <div style="display:flex; align-items:center; justify-content:space-between;">
                        <h2>メニュー（{{ cafe.menus ? cafe.menus.length : 0 }}件）</h2>
                        <button v-if="canEdit" type="button" @click="openMenuModal" class="btn-menu-add">
                            ＋ メニューを追加
                        </button>
                    </div>
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
                            <button v-if="canEdit" type="button" @click="deleteMenu(menu.id)" class="menu-delete-btn">削除</button>
                        </div>
                    </div>
                </div>

                <!-- メニュー追加モーダル -->
                <TransitionRoot appear :show="isMenuModalOpen" as="template">
                    <Dialog as="div" @close="closeMenuModal">

                        <!-- 背景の暗幕 -->
                        <TransitionChild as="template">
                            <div style="position:fixed; inset:0; background:rgba(0,0,0,0.4);" />
                        </TransitionChild>

                        <!-- モーダル本体 -->
                        <div style="position:fixed; inset:0; overflow-y:auto; display:flex; align-items:center; justify-content:center;">
                            <TransitionChild as="template">
                                <DialogPanel style="background:#fff; border-radius:8px; padding:24px; width:90%; max-width:480px;">

                                    <DialogTitle>メニューを追加する</DialogTitle>

                                    <form @submit.prevent="submitMenu" class="menu-form">
                                        <!-- メニュー名 -->
                                        <div class="menu-form-group">
                                            <label class="menu-form-label">メニュー名<span class="required">*</span></label>
                                            <input v-model="menuForm.name" type="text" class="menu-form-input" placeholder="例：カフェラテ" />
                                            <p v-if="menuForm.errors.name" class="form-error">{{ menuForm.errors.name }}</p>
                                        </div>
                                        <!-- 価格 -->
                                        <div class="menu-form-group">
                                            <label class="menu-form-label">価格（円）<span class="required">*</span></label>
                                            <input v-model="menuForm.price" type="number" min="0" class="menu-form-input" placeholder="例：580" />
                                            <p v-if="menuForm.errors.price" class="form-error">{{ menuForm.errors.price }}</p>
                                        </div>
                                        <!-- 説明 -->
                                        <div class="menu-form-group">
                                            <label class="menu-form-label">説明</label>
                                            <textarea v-model="menuForm.description" class="menu-form-input menu-form-textarea" placeholder="例：濃厚なエスプレッソにスチームミルクを合わせた一杯" rows="3"></textarea>
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
                                        <!-- ボタン -->
                                        <div class="modal-form-actions">
                                            <button type="button" @click="closeMenuModal" class="btn-cancel">キャンセル</button>
                                            <button type="submit" class="btn-submit" :disabled="menuForm.processing">追加する</button>
                                        </div>
                                    </form>

                                </DialogPanel>
                            </TransitionChild>
                        </div>

                    </Dialog>
                </TransitionRoot>

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
