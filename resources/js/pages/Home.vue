<script setup lang="ts">
import JobTable from '@/components/JobTable.vue'

defineProps({ jobs: Object })
</script>

<template>
  <JobTable :jobs="jobs" />
</template>
