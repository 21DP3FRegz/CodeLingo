<script setup lang="ts">
import { ref, onMounted } from 'vue';
import {
  NavigationMenu,
  NavigationMenuItem,
  NavigationMenuLink,
  NavigationMenuList,
} from '@/components/ui/navigation-menu';
import { navigationMenuTriggerStyle } from '@/components/ui/navigation-menu';
import router from "@/router.js";
import api from '@/api.js';

const isAdmin = ref(false);
const token = localStorage.getItem('token');
if (!token) {
  router.push('/login');
}

onMounted(async () => {
  try {
    const response = await api.get(`/user`, {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });
    isAdmin.value = response.data.role === 'admin';
  } catch (error) {
    console.error('Error fetching user data:', error);
    isAdmin.value = false;
  }
});
</script>

<template>
  <footer class="fixed bottom-0 left-0 right-0 z-10 bg-white shadow-md border">
    <div class="p-4 flex justify-center">
        <NavigationMenu>
          <NavigationMenuList class="flex space-x-20">
            <NavigationMenuItem>
              <RouterLink to="/">
                <NavigationMenuLink :class="navigationMenuTriggerStyle()">
                  Home
                </NavigationMenuLink>
              </RouterLink>
            </NavigationMenuItem>

            <NavigationMenuItem v-if="isAdmin">
              <RouterLink to="/">
                <NavigationMenuLink :class="navigationMenuTriggerStyle()">
                  Home
                </NavigationMenuLink>
              </RouterLink>
            </NavigationMenuItem>

            <NavigationMenuItem>
              <RouterLink to="/leaderboard">
                <NavigationMenuLink :class="navigationMenuTriggerStyle()">
                  Leaderboard
                </NavigationMenuLink>
              </RouterLink>
            </NavigationMenuItem>

            <NavigationMenuItem>
              <RouterLink to="/profile">
                <NavigationMenuLink :class="navigationMenuTriggerStyle()">
                  Profile
                </NavigationMenuLink>
              </RouterLink>
            </NavigationMenuItem>
          </NavigationMenuList>
        </NavigationMenu>
      </div>
  </footer>
</template>