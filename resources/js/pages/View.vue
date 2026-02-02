<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue'
import type { Job } from '@/types/job.ts'

const { job } = defineProps<{ job: Job }>()
</script>

<template>
  <div v-if="job">
    <h1 class="text-3xl mb-4">{{ job.data.title }}</h1>
    <div class="flex mb-4">
      <div class="flex-1">
        <div class="flex mb-4">
          <span class="w-32 font-extrabold">Recruiter:</span>
          <span>{{ job.data.employer }}</span>
        </div>
        <div class="flex">
          <span class="w-32 font-extrabold">Location:</span>
          <span>{{ job.data.location }}</span>
        </div>
      </div>
      <div class="flex-1">
        <div class="flex mb-4">
          <span class="w-32 font-extrabold">Posted At:</span>
          <span>{{ job.data.posted_at }}</span>
        </div>
      </div>
    </div>
    <div class="flex mb-4">
      <Button variant="outline">View Original</Button>
    </div>
    <div v-html="job.data.description"></div>
  </div>
</template>
