<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div>
        <div class="flex min-h-screen flex-col bg-gray-100">
            <!-- サイトヘッダー -->
            <header class="cafe-share-header">
                <div class="header-inner">
                    <Link :href="route('dashboard')" class="site-logo">☕ Cafe Share</Link>
                    <nav class="header-nav">
                        <Link :href="route('cafes.create')">新規カフェ追加</Link>
                        <Link :href="route('profile.edit')">マイページ</Link>
                        <Link :href="route('logout')" method="post" as="button">ログアウト</Link>
                    </nav>
                </div>
            </header>

            <!-- Page Heading -->
            <header
                class="bg-white shadow"
                v-if="$slots.header"
            >
                <div style="max-width:1000px; margin:0 auto; padding:18px 16px;">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-grow">
                <slot />
            </main>

            <!-- Page Footer -->
            <footer class="site-footer">
                <div class="footer-inner">
                    <p class="footer-logo">☕ Cafe Share</p>
                    <p class="footer-copy">&copy; 2026 Cafe Share. All rights reserved.</p>
                </div>
            </footer>
        </div>
    </div>

</template>
