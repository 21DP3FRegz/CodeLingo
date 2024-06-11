<script setup lang="ts">
import { useRouter } from 'vue-router';
import { useForm } from 'vee-validate';
import { toTypedSchema } from '@vee-validate/zod';
import * as z from 'zod';
import api from '@/api.js';

import { Button } from '@/components/ui/button';
import {
  FormControl,
  FormLabel,
  FormField,
  FormItem,
  FormMessage,
} from '../ui/form';
import { Input } from '@/components/ui/input';
import { useToast } from '@/components/ui/toast/use-toast'

const router = useRouter();

const { toast } = useToast()

const formSchema = toTypedSchema(z.object({
  email: z.string(),
  password: z.string(),
}));

const { handleSubmit, errors } = useForm({
  validationSchema: formSchema,
});

const onSubmit = handleSubmit(async (formValues) => {
  try {
    const response = await api.post('/login', formValues);
    localStorage.setItem('token', response.data.token);
    const course = localStorage.getItem('course');
    if (course) {
      router.push(`/courses/${course}`);
    } else {
      router.push('/');
    }
  } catch (error) {
    toast({
      title: 'Login failed',
      description: 'Wrong username or password. Please check if the entered data is correct and try again',
      variant: 'destructive',
    });
  }
});
</script>

<template>
  <form class="space-y-6" @submit="onSubmit">
    <FormField v-slot="{ field, meta }" name="email">
      <FormItem>
        <FormLabel>Email</FormLabel>
        <FormControl>
          <Input type="email" v-bind="field" placeholder="yourname@example.com" />
        </FormControl>
        <FormMessage v-if="meta.touched && meta.error">{{ meta.error }}</FormMessage>
      </FormItem>
    </FormField>

    <FormField v-slot="{ field, meta }" name="password">
      <FormItem>
        <FormLabel>Password</FormLabel>
        <FormControl>
          <Input type="password" v-bind="field" placeholder="******" />
        </FormControl>
        <FormMessage v-if="meta.touched && meta.error">{{ meta.error }}</FormMessage>
      </FormItem>
    </FormField>

    <Button type="submit">
      Login
    </Button>
  </form>
</template>
