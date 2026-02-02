<script setup lang="ts">
import JobTable from '@/components/JobTable.vue'

defineProps({ jobs: Object })
</script>

<template>
  <h1>Council Tax</h1>
  <JobTable :jobs="jobs" />
</template>
