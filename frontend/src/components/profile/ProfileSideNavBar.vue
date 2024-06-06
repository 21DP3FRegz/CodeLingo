<script setup lang="ts">
import { useRouter } from 'vue-router';
import { Button } from '@/components/ui/button';

interface Item {
  title: string
  href: string
}

const router = useRouter();

const sidebarNavItems: Item[] = [
  {
    title: 'Profile',
    href: '/profile',
  },
  {
    title: 'Log out',
    href: '/logout',
  },
]
</script>

<template>
  <nav class="flex space-x-2 lg:flex-col lg:space-x-0 lg:space-y-1">
    <Button
        v-for="item in sidebarNavItems"
        :key="item.title"
        as="a"
        :href="item.href"
        variant="ghost"
        :class="[
          'w-full',
          'text-left',
          'justify-start',
          router.currentRoute.value.path === item.href ? 'bg-muted hover:bg-muted' : '',
        ]"
    >
      {{ item.title }}
    </Button>
  </nav>
</template>