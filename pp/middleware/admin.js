export default defineNuxtRouteMiddleware(() => {
    const user=userStore().user;

    if(user && user.type==2)
    {
        return;
    }
    if(!useNuxtApp().$cookie.get('token'))
    {
        return navigateTo('/login', { redirectCode: 301 });
    }

  })