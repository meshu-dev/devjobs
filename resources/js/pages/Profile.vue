<script setup lang="ts">
import { Form } from '@inertiajs/vue3'
import { Field } from '@/components/ui/field'
import { Label } from '@/components/ui/label'
import Input from '@/components/ui/input/Input.vue'
import { Button } from '@/components/ui/button'

const props = defineProps({ user: Object })
console.log('props', props)
</script>

<template>
  <Form action="/profile" method="post" class="max-w-md">
    <Field class="flex flex-row mb-4">
      <Label for="name" class="flex-1">Name</Label>
      <Input type="text" name="name" v-model="user.name" autoComplete="off" class="flex-2" />
    </Field>
    {{ user.min_salary }}
    {{ user.max_salary }}
    <Button
      class="cursor-pointer"
      type="submit">
      Update
    </Button>
  </Form>
</template>
