<script setup>

import Leaderboard from "@/components/Leaderboard.vue";
</script>

<template>
  <div class="relative flex flex-col justify-center items-center min-h-screen selection:bg-red-500 selection:text-white">
    <h2 class="scroll-m-20 text-4xl font-extrabold tracking-tight lg:text-5xl">Leaderboard</h2>
    <div class="container mx-auto p-4 text-xl flex justify-center">
      <div class="w-full max-w-md">
        <Leaderboard/>
      </div>
    </div>
  </div>
</template>

