import Cookies from "js-cookie";
export default defineNuxtRouteMiddleware((to) => {
    console.log(userStore().user);
    if(!Cookies.get('token'))
    {
        userStore().logout();
        return navigateTo('/auth/login');
    }

  })