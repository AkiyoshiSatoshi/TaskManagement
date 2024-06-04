<script setup lang="ts">
const logout = () => {
  useUserAuthApi().logout();
  navigateTo("/login");
};

const setting = () => {
  navigateTo("/user/setting");
};

const name = "テストUser";

const items = ref([
  {
    label: name,
    items: [
      {
        label: "ユーザー設定",
        command: () => {
          setting();
        },
      },
      {
        label: "ログアウト",
        command: () => {
          logout();
        },
      },
    ],
  },
]);
</script>

<template>
  <header class="fixed h-16 w-full bg-gray-50">
    <div class="item-center flex h-full justify-between pl-4">
      <div class="flex items-center">
        <NuxtLink to="/projects">
          <img
            class="block h-8 cursor-pointer"
            src="@/assets/img/logo.svg"
            alt="logo"
          />
        </NuxtLink>
      </div>
      <Menubar class="border-none bg-inherit" :model="items" />
    </div>
  </header>
</template>
