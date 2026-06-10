<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({cafes: Array,});

const starClass = (avg, position) => {
    const score = avg ?? 0;                 // null（レビュー無し）は0扱い
    if (score >= position) return 'filled';     // 平均が位置以上なら塗る
    if (score >= position - 0.5) return 'half';  // 端数0.5は半分
    return 'empty';                          // それ以外は空
};
</script>

<template>
    <Head title="カフェ一覧" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                カフェ一覧
            </h2>
        </template>

        <!-- ========== カフェカード一覧 ========== -->
        <div class="cafe-list">

              <!-- 取得した一覧を表示 -->
            <article v-for="cafe in cafes" :key="cafe.id" class="cafe-card">
                <a href="#" class="cafe-img-link">
                    <div class="cafe-img-placeholder">
                        <span class="cafe-img-icon">☕</span>
                    </div>
                </a>
                <div class="cafe-info">
                    <div class="cafe-info-top">
                        <div>
                            <a href="#" class ="cafe-name">{{ cafe.name }}</a>
                            <div class="cafe-category">{{ cafe.address }}</div>
                        </div>
                        <div class="cafe-rating-area">
                            <div class="cafe-score cafe-score--no-review">-</div>
                            <div class="cafe-stars">
                                <span v-for="position in 5" :key="position" class="star" :class="starClass(cafe.reviews_avg_rating, position)">★</span>
                                <span v-if="cafe.reviews_avg_rating" class="cafe-rating-value">{{ Number(cafe.reviews_avg_rating).toFixed(1) }}</span>
                            </div>
                            <div class="cafe-review-count">レビュー <strong>{{ cafe.reviews_count }}</strong> 件</div>
                        </div>
                    </div>
                    <p class="cafe-description">{{ cafe.description }}</p>
                </div>

            </article>
        </div>
    </AuthenticatedLayout>
</template>
