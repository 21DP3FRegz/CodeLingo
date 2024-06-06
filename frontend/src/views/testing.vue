<template>
  <DialogRoot>
    <DialogTrigger>
      Try Again
    </DialogTrigger>

    <DialogPortal v-if="showTryAgainMessage">
      <DialogOverlay />
      <DialogContent>
        <DialogTitle>Try Again Dialog</DialogTitle>
        <DialogDescription>This is your try again message.</DialogDescription>
        <DialogClose @click="showTryAgainMessage = false">Close</DialogClose>
      </DialogContent>
    </DialogPortal>
  </DialogRoot>
</template>

<script setup>
import {
  DialogRoot,
  DialogTrigger,
  DialogPortal,
  DialogOverlay,
  DialogContent,
  DialogTitle,
  DialogDescription,
  DialogClose
} from 'radix-vue'

let showTryAgainMessage = false;
</script>
