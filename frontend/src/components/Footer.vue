<script setup lang="ts">
import {
  NavigationMenu,
  NavigationMenuItem,
  NavigationMenuLink,
  NavigationMenuList,
} from '@/components/ui/navigation-menu';
import { navigationMenuTriggerStyle } from '@/components/ui/navigation-menu';
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