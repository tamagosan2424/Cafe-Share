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
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
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
