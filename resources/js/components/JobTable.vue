<script setup lang="ts">
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table'
import {
  Pagination,
  PaginationContent,
  PaginationItem,
  PaginationNext,
  PaginationPrevious,
} from '@/components/ui/pagination'
import { Link } from '@inertiajs/vue3'
import { toRaw } from 'vue'

const j = defineProps({ jobs: Object })
console.log('BBB', toRaw(j.jobs)) 
</script>

<template>
  <div class="min-h-[650px]">
    <Table class="table-fixed">
      <TableHeader>
        <TableRow class="text-xl font-extrabold">
          <TableHead class="w-lg">Title</TableHead>
          <TableHead>Location</TableHead>
          <TableHead>Posted At</TableHead>
        </TableRow>
      </TableHeader>
      <TableBody>
        <TableRow v-for="job in jobs.data">
          <TableCell>
            <Link :href="'/view/' + job.id">{{ job.title }}</Link>
          </TableCell>
          <TableCell>{{ job.location }}</TableCell>
          <TableCell>{{ job.posted_at }}</TableCell>
        </TableRow>
      </TableBody>
    </Table>
  </div>
  <Pagination
    v-if="jobs && jobs.last_page > 1"
    :items-per-page="jobs.per_page"
    :total="jobs.total">
    <PaginationContent>
        <Link
          v-if="jobs.links.prev"
          :href="jobs.links.prev">
          <PaginationPrevious
            class="cursor-pointer"
            :disabled="false" />
        </Link>
        <PaginationPrevious
          v-else
          :disabled="true"
        />

        <template v-for="link in jobs.links">
          <Link v-if="link.url" :href="link.url">
            <PaginationItem
              v-if="link.page && !isNaN(link.label)"
              class="cursor-pointer"
              :value="link.page"
              :is-active="link.active">
              {{ link.page }}
            </PaginationItem>
          </Link>
        </template>

        <Link
          v-if="jobs.links.next"
          :href="jobs.links.next">
          <PaginationNext
            class="cursor-pointer"
            :disabled="false" />
        </Link>
        <PaginationNext
          v-else
          :disabled="true"
        />
    </PaginationContent>
  </Pagination>
</template>
