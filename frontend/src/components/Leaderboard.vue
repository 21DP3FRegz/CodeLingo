<script setup lang="ts">
import { ref, onMounted } from 'vue';
import api from '@/api.js';
import Footer from "@/components/Footer.vue";

import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table'

interface User {
  id: number;
  name: string;
  score: number;
}

const users = ref<User[]>([]);

const fetchLeaderboard = async () => {
  try {
    const response = await api.get('/leaderboard');
    users.value = response.data;
    console.log(users.value);
  } catch (error) {
    console.error('Ошибка при загрузке данных таблицы лидеров:', error);
  }
};

onMounted(() => {
  fetchLeaderboard();
});
</script>

<template>
  <div>
    <Table>
      <TableHeader>
        <TableRow>
          <TableHead class="w-[100px]">
            Место
          </TableHead>
          <TableHead >Имя</TableHead>
          <TableHead class="text-right">
            Очки
          </TableHead>
        </TableRow>
      </TableHeader>
      <TableBody>
        <TableRow v-for="(user, index) in users" :key="user.id">
          <TableCell class="font-medium">
            {{ index + 1 }}
          </TableCell>
          <TableCell>{{ user.name }}</TableCell>
          <TableCell class="text-right">
            {{ user.points }}
          </TableCell>
        </TableRow>
      </TableBody>
    </Table>
  </div>
  <Footer/>
</template>
