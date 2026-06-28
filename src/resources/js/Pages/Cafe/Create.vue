<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    address: '',
    phone_number: '',
    opening_at: '',
    closing_at: '',
    description: '',
    image: null,  // ファイルはnullで初期化
});

// フォームをPOST送信してカフェを新規作成する
const submit = () => {
    form.post(route('cafes.store'));
};

// 半角数字とハイフン以外の文字を自動削除
const sanitizePhone = () => {
    form.phone_number = form.phone_number.replace(/[^0-9\-]/g, '');
};

</script>

<template>
    <Head title="カフェ作成" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                新規カフェ作成
            </h2>
        </template>

        <!-- フォームカード -->
        <div class="create-form-card">
            <h3 class="create-form-title">新規カフェ追加</h3>
            <!-- submit.prevent でページリロードを防ぎ、submit関数を呼び出す -->
            <form @submit.prevent="submit" class="create-form">
                <!-- カフェ名 -->
                <div class="form-group">
                    <label class="form-label">カフェ名<span class="required">*</span></label>
                    <input v-model="form.name" type="text" class="form-input" placeholder="例：○○珈琲 渋谷店" />
                    <p v-if="form.errors.name" class="form-error">{{ form.errors.name }}</p>
                </div>
                 <!-- 住所 -->
                <div class="form-group">
                    <label class="form-label">住所<span class="required">*</span></label>
                    <input v-model="form.address" type="text" class="form-input" placeholder="例:東京都 渋谷区1-1-1">
                    <p v-if="form.errors.address" class="form-error">{{ form.errors.address }}</p>
                </div>
                <!-- 電話番号 -->
                <div class="form-group">
                    <label class="form-label">電話番号</label>
                    <input v-model="form.phone_number" type="text" class="form-input"
                    placeholder="例:123-4567"
                    @input="sanitizePhone"
                    @compositionend="sanitizePhone">
                </div>
                <!-- 営業時間 -->
                <div class="form-group">
                    <label class="form-label">営業時間</label>
                    <div class="time-range">
                        <input v-model="form.opening_at" type="time" class="form-input-time">
                        <span class="time-sep">〜</span>
                        <input v-model="form.closing_at" type="time" class="form-input-time">
                    </div>
                </div>
                <!-- 紹介文 -->
                <div class="form-group">
                    <label class="form-label">カフェ紹介文</label>
                    <textarea v-model="form.description" class="form-input form-textarea" placeholder="カフェの雰囲気や特徴を入力してください" rows="4"></textarea>
                </div>
                <!-- 画像送信 -->
                <div class="form-group">
                    <label class="form-label">画像</label>
                    <input type="file" accept="image/*" @change="form.image = $event.target.files[0]">
                </div>
                <!-- 送信ボタン -->
                <div class="form-actions">
                    <Link :href="route('cafes.index')" class="btn-cancel">キャンセル</Link>
                    <button type="submit" class="btn-submit" :disabled="form.processing">
                        追加する
                    </button>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
