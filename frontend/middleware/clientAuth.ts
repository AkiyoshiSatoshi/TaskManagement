export default defineNuxtRouteMiddleware(() => {
  const user = useUserAuthApi().me();

  if (!user.value) {
    const path = "/login";
    return { path };
  }
});
