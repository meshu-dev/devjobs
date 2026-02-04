<script setup lang="ts">
import {
  NavigationMenu,
  NavigationMenuItem,
  NavigationMenuLink,
  NavigationMenuList,
  navigationMenuTriggerStyle,
} from '@/components/ui/navigation-menu'
import { Link } from '@inertiajs/vue3'
</script>

<template>
  <NavigationMenu :viewport="false">
    <NavigationMenuList>
      <NavigationMenuItem>
        <NavigationMenuLink as-child :class="navigationMenuTriggerStyle()">
          <Link href="/home">Home</Link>
        </NavigationMenuLink>
      </NavigationMenuItem>
      <NavigationMenuItem>
        <NavigationMenuLink as-child :class="navigationMenuTriggerStyle()">
          <Link href="/favourites">Favourites</Link>
        </NavigationMenuLink>
      </NavigationMenuItem>
      <NavigationMenuItem>
        <NavigationMenuLink as-child :class="navigationMenuTriggerStyle()">
          <Link href="/profile">Profile</Link>
        </NavigationMenuLink>
      </NavigationMenuItem>
      <NavigationMenuItem>
        <NavigationMenuLink as-child :class="navigationMenuTriggerStyle()">
          <a href="/logout">Logout</a>
        </NavigationMenuLink>
      </NavigationMenuItem>
    </NavigationMenuList>
  </NavigationMenu>
</template>
