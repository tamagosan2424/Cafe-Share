<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,Link,useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    address: '',
    phone_number: '',
    opening_at: '',
    closing_at: '',
    description: '',
});

const submit = () => {
    form.post(route('cafes.store'));
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
            <form @submit.prevent="submit" class="create-form">
                <!-- カフェ名 -->
                 <div class="form-group">
                    <label class="form-label">カフェ名<span class="required">*</span></label>
                        <input v-model="form.name" type="text" class="form-input" placeholder="例：○○珈琲 渋谷店" />
                        <p v-if="form.errors.name" class="form-error">{{ form.errors.name }}</p>   
                 </div>
                 <!-- 住所-->
                <div class="form-group">
                    <label class="form-label">住所<span class="required">*</span></label>
                    <input v-model="form.address" type="text" class="form-input" placeholder="例:東京都 渋谷区1-1-1">
                    <p v-if="form.errors.address" class="form-error">{{ form.errors.address }}</p> 
                </div>
                <!-- 電話番号-->
                <div class="form-group">
                    <label class="form-label">電話番号</label>
                    <!--半角数字以外の文字の入力を自動削除-->
                    <input v-model="form.phone_number" type="text" class="form-input" placeholder="例:123-4567" @input="form.phone_number = form.phone_number.replace(/[^0-9\-]/g, '')" @compositionend="form.phone_number = form.phone_number.replace(/[^0-9\-]/g, '')">
                </div>
                <!-- 営業時間-->
                <div class="form-group">
                    <label class="form-label">営業時間</label>
                    <div class="time-range">
                        <input v-model="form.opening_at" type="time" class="form-input-time">
                        <span class="time-sep">〜</span>
                        <input v-model="form.closing_at" type="time" class="form-input-time">
                    </div>
                </div>
                <!-- 紹介文-->
                <div class="form-group">
                    <label class="form-label">カフェ紹介文</label>
                        <textarea v-model="form.description" class="form-input form-textarea"placeholder="カフェの雰囲気や特徴を入力してください" rows="4">
                        </textarea>
                </div>
                <!-- ボタン -->
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
