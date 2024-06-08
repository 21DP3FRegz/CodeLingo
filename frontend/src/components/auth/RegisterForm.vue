<script setup lang="ts">
import { useRouter } from 'vue-router';
import { useForm } from 'vee-validate';
import { toTypedSchema } from '@vee-validate/zod';
import * as z from 'zod';
import api from '@/api.js';

import { Button } from '@/components/ui/button';
import {
  FormControl,
  FormDescription,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from '../ui/form';
import { Input } from '@/components/ui/input';
import { useToast } from '@/components/ui/toast/use-toast'

const router = useRouter();

const { toast } = useToast()

const formSchema = toTypedSchema(z.object({
  name: z.string().min(2).max(50),
  email: z.string().email(),
  password: z.string().min(6),
  password_confirmation: z.string().min(6),
}).refine(data => data.password === data.password_confirmation, {
  message: "Passwords don't match",
  path: ["password_confirmation"],
}));


const { handleSubmit, error } = useForm({
  validationSchema: formSchema,
});

const onSubmit = handleSubmit(async (formValues) => {
  console.log('Submitted values:', formValues);
  try {
    const response = await api.post('/register', formValues);
    localStorage.setItem('token', response.data.token);
    const course = localStorage.getItem('course');
    if (course) {
      router.push(`/courses/${course}`);
    } else {
      router.push('/');
    }
  } catch (error) {
    toast({
      title: 'Registration failed',
      description: error.response.data.message || 'Registration failed',
      variant: 'destructive',
    });
  }
});
</script>

<template>
  <form class="space-y-6" @submit="onSubmit">
    <FormField v-slot="{ field, meta }" name="name">
      <FormItem>
        <FormLabel>Name</FormLabel>
        <FormControl>
          <Input type="text" v-bind="field" placeholder="Your Name" />
        </FormControl>
        <FormDescription>
          This is your full name.
        </FormDescription>
        <FormMessage v-if="meta.touched && meta.error">{{ meta.error }}</FormMessage>
      </FormItem>
    </FormField>

    <FormField v-slot="{ field, meta }" name="email">
      <FormItem>
        <FormLabel>Email</FormLabel>
        <FormControl>
          <Input type="email" v-bind="field" placeholder="yourname@example.com" />
        </FormControl>
        <FormDescription>
          This is your email address.
        </FormDescription>
        <FormMessage v-if="meta.touched && meta.error">{{ meta.error }}</FormMessage>
      </FormItem>
    </FormField>

    <FormField v-slot="{ field, meta }" name="password">
      <FormItem>
        <FormLabel>Password</FormLabel>
        <FormControl>
          <Input type="password" v-bind="field" placeholder="******" />
        </FormControl>
        <FormDescription>
          Your password must be at least 6 characters long.
        </FormDescription>
        <FormMessage v-if="meta.touched && meta.error">{{ meta.error }}</FormMessage>
      </FormItem>
    </FormField>

    <FormField v-slot="{ field, meta }" name="password_confirmation">
      <FormItem>
        <FormLabel>Confirm Password</FormLabel>
        <FormControl>
          <Input type="password" v-bind="field" placeholder="******" />
        </FormControl>
        <FormDescription>
          Please re-enter your password.
        </FormDescription>
        <FormMessage v-if="meta.touched && meta.error">{{ meta.error }}</FormMessage>
      </FormItem>
    </FormField>

    <Button type="submit">
      Submit
    </Button>
  </form>
</template>
