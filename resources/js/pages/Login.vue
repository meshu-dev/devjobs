<script setup lang="ts">
import { Form } from '@inertiajs/vue3'
import { Link } from '@inertiajs/vue3'
import { Field } from '@/components/ui/field'
import Button from '@/components/ui/button/Button.vue'
import Input from '@/components/ui/input/Input.vue'
import {
  Card,
  CardContent,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'
</script>

<template>
  <Card class="w-full max-w-sm mx-auto mt-50">
    <CardHeader>
      <CardTitle class="text-center">DevJobs</CardTitle>
    </CardHeader>
    <CardContent>
      <Form action="/login" method="post">
        <Field class="mb-4">
          <Input type="email" name="email" autoComplete="off" placeholder="Email" />
        </Field>
        <Field class="mb-4">
          <Input type="password" name="password" autoComplete="off" placeholder="Password" />
        </Field>
        <Button
          class="w-full cursor-pointer"
          type="submit">
          Login
        </Button>
      </Form>
      <div class="mt-2 text-center">
        <span>No user account?</span>
        <Link href="/login/demo" method="post" as="button" class="ml-1 cursor-pointer">
          <span class="cursor-pointer">Use demo account</span>
        </Link>
      </div>
    </CardContent>
  </Card>
</template>
