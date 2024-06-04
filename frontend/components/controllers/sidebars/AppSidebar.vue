<script setup lang="ts">
const linkItems = [
  { label: "プロジェクト一覧", to: "/projects" },
  { label: "ユーザ一覧", to: "/users" },
];
</script>

<template>
  <div class="fixed bottom-0 left-0 top-16 w-48 bg-client">
    <ul>
      <NuxtLink
        v-for="linkItem in linkItems"
        :key="linkItem.label"
        class="block w-full py-3 pl-4 text-sm text-white"
        active-class="bg-white !text-client"
        :to="linkItem.to"
      >
        <li>{{ linkItem.label }}</li>
      </NuxtLink>
    </ul>
  </div>
</template>
