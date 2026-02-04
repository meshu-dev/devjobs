<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import 'vue-sonner/style.css'
import { Toaster } from '@/components/ui/sonner'
import { toast } from 'vue-sonner'
import { router } from '@inertiajs/vue3'
import { onUnmounted } from 'vue'

onUnmounted(
  router.on('flash', (event) => {
      if (event.detail.flash['message']) {
        toast(event.detail.flash['message'])
      }
  })
)
</script>

<template>
  <Head title="DevJobs">
    <meta name="description" content="Your page description">
  </Head>
  <main class="m-auto mt-15 mb-0 max-w-4xl">
    <slot />
  </main>
  <Toaster position="top-center"
  />
</template>
