export default defineNuxtRouteMiddleware(() => {
    if(userStore().user.type==1)
    {
        return;
    }else
    {
        return navigateTo('/');
    }

  })