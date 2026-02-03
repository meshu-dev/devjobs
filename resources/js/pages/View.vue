<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue'
import type { Job } from '@/types/job.ts'

const { job } = defineProps<{ job: Job }>()
</script>

<template>
  <div v-if="job">
    <h1 class="text-3xl mb-4">{{ job.data.title }}</h1>
    <div class="flex mb-2">
      <div class="flex-1">
        <div class="flex mb-4">
          <span class="w-24 font-extrabold">Recruiter:</span>
          <span>{{ job.data.employer }}</span>
        </div>
        <div class="flex">
          <span class="w-24 font-extrabold">Location:</span>
          <span>{{ job.data.location }}</span>
        </div>
      </div>
      <div class="flex-1">
        <div class="flex mb-4">
          <span class="w-24 font-extrabold">Posted At:</span>
          <span>{{ job.data.posted_at }}</span>
        </div>
        <div class="flex mb-4">
          <span class="w-24 font-extrabold">Salary:</span>
          <span>{{ job.data.min_salary }} - {{ job.data.max_salary }}</span>
        </div>
      </div>
    </div>
    <div class="flex mb-6 gap-2">
      <Button variant="outline" class="cursor-pointer">Favourite</Button>
      <a :href="job.data.posted_at" target="_blank">
        <Button variant="outline" class="cursor-pointer">View Original</Button>
      </a>
    </div>
    <div v-html="job.data.description"></div>
  </div>
</template>
