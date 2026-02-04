<script setup lang="ts">
//import { usePage } from '@inertiajs/vue3'
import { Form } from '@inertiajs/vue3'
import {
  Field,
  FieldLabel
} from '@/components/ui/field'
import Button from '@/components/ui/button/Button.vue'
import Input from '@/components/ui/input/Input.vue'

/*
const page = usePage()

document.addEventListener('inertia:flash', (event) => {
  console.log('FLASH!!!', event.detail.flash)
  console.log(event.detail.flash)
}) */

</script>

<template>
  <h1>Login</h1>
  <Form action="/login" method="post">
    <Field class="mb-4">
      <FieldLabel htmlFor="email">Email:</FieldLabel>
      <Input type="email" name="email" autoComplete="off" placeholder="Email" />
    </Field>
    <Field class="mb-4">
      <FieldLabel htmlFor="password">Password:</FieldLabel>
      <Input type="password" name="password" autoComplete="off" placeholder="Password" />
    </Field>
    <Button
      variant="outline"
      class="cursor-pointer"
      type="submit">
      Submit
    </Button>
  </Form>
</template>
