<script setup lang="ts">
import { onMounted } from 'vue'
import { useForm } from 'vee-validate'
import { toTypedSchema } from '@vee-validate/zod'
import * as z from 'zod'

import { Input } from '@/components/ui/input'
import { FormControl, FormDescription, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form'
import { Separator } from '@/components/ui/separator'
import { Textarea } from '@/components/ui/textarea'
import { Button } from '@/components/ui/button'
import { toast } from '@/components/ui/toast'
import api from '@/api.js'
import router from '@/router.js'

const profileFormSchema = toTypedSchema(z.object({
  username: z
      .string()
      .min(2, {
        message: 'Username must be at least 2 characters.',
      })
      .max(30, {
        message: 'Username must not be longer than 30 characters.',
      }),
  bio: z.string().max(160, { message: 'Bio must not be longer than 160 characters.' })
}))

const { handleSubmit, setValues } = useForm({
  validationSchema: profileFormSchema,
  initialValues: {
    username: '',
    bio: '',
  },
})

onMounted(async () => {
  await fetchUserData();
})

const fetchUserData = async () => {
  try {
    const token = localStorage.getItem('token');
    if (!token) {
      router.push('/login');
    }

    const response = await api.get('/user', {
      headers: {
        Authorization: `Bearer ${token}`
      }
    });
    const userData = response.data
    setValues({
      username: userData.name,
      bio: userData.bio,
    })
  } catch (error) {
    toast({
      title: 'Error fetching user data',
      description: 'Unable to load user data. Please try again later.',
    })
  }
};

const onSubmit = handleSubmit(async (values) => {
  try {
    const token = localStorage.getItem('token');
    if (!token) {
      router.push('/login');
    }

    await api.put('/user', values, {
      headers: {
        Authorization: `Bearer ${token}`
      }
    });

    toast({
      title: 'Profile Updated',
      description: 'Your profile has been successfully updated.',
    })
  } catch (error) {
    toast({
      title: 'Error updating profile',
      description: 'Unable to update your profile. Please try again later.',
    })
  }
})
</script>

<template>
  <div>
    <h3 class="text-lg font-medium">
      Profile
    </h3>
    <p class="text-sm text-muted-foreground">
      This is how others will see you on the site.
    </p>
  </div>
  <Separator />
  <form class="space-y-8" @submit.prevent="onSubmit">
    <FormField v-slot="{ field }" name="username">
      <FormItem>
        <FormLabel>Username</FormLabel>
        <FormControl>
          <Input type="text" placeholder="Think of a cool username" v-bind="field" />
        </FormControl>
        <FormDescription>
          This is your public display name. It can be your real name or a pseudonym. You can only change this once every 30 days.
        </FormDescription>
        <FormMessage />
      </FormItem>
    </FormField>

    <FormField v-slot="{ field }" name="bio">
      <FormItem>
        <FormLabel>Bio</FormLabel>
        <FormControl>
          <Textarea placeholder="Tell us a little bit about yourself" v-bind="field" />
        </FormControl>
        <FormMessage />
      </FormItem>
    </FormField>

    <div class="flex gap-2 justify-start">
      <Button type="submit">
        Update profile
      </Button>

      <Button
          type="button"
          variant="outline"
          @click="fetchUserData"
      >
        Reset form
      </Button>
    </div>
  </form>
</template>