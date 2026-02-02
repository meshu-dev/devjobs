<script setup lang="ts">
  import { Head } from '@inertiajs/vue3';
</script>

<template>
  <Head title="DevJobs">
    <meta name="description" content="Your page description">
  </Head>
  <main class="m-auto mt-15 mb-0 max-w-4xl">
    <slot />
  </main>
</template>
