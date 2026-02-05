<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import 'vue-sonner/style.css'
import { Toaster } from '@/components/ui/sonner'
import { toast } from 'vue-sonner'
import { router } from '@inertiajs/vue3'
import { onUnmounted } from 'vue'
import UserMenu from '@/components/UserMenu.vue'

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
  <div class="m-auto mb-0 max-w-4xl px-8 py-12">
    <UserMenu />
    <main>
      <slot />
    </main>
  </div>
  <Toaster position="top-center"
  />
</template>
