<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';

// コントローラーからカフェデータを受け取る
const props = defineProps({ cafe: { type: Object, required: true } });

// 初期値を既存データに
const form = useForm({
    name:         props.cafe.name,
    address:      props.cafe.address,
    phone_number: props.cafe.phone_number ?? '',
    opening_at:   props.cafe.opening_at ? props.cafe.opening_at.slice(0, 5) : '',
    closing_at:   props.cafe.closing_at ? props.cafe.closing_at.slice(0, 5) : '',
    description:  props.cafe.description ?? '',
    image: null,
});

//バリデーションが誤作動するのでmethod スプーフィングする
const submit = () => {
    form.transform(data => ({
        ...data,
        _method: 'PATCH',
    })).post(route('cafes.update', props.cafe.id));
};

const destroy = () => {
    if (confirm('本当に削除しますか？')) {
        router.delete(route('cafe.destroy', props.cafe.id));
    }
};

const sanitizePhone = () => {
    form.phone_number = form.phone_number.replace(/[^0-9\-]/g, '');
};
</script>


<template>
    <Head title="カフェ編集" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                カフェ編集
            </h2>
        </template>

        <!-- フォームカード -->
        <div class="create-form-card">
            <h3 class="create-form-title">カフェ情報の編集</h3>
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
                        更新する
                    </button>
                    <button type="button" @click="destroy" class="btn-delete">
                        削除する
                    </button>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
