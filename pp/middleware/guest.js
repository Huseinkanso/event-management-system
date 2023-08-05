export default  defineNuxtRouteMiddleware(async (to,from) => {
    console.log(to.path);
    console.log(from.path);
    const cookie=useNuxtApp().$cookie.get('token');
    if(!(!!cookie))
    {
        return;
    }else
    {
        const user=userStore().user;
        if(to.path==from.path)
        {
           if(user)
           { console.log(user);
            if(user.type==0)
            {
                return navigateTo('/');
            }else if(user.type==1)
            {
                return navigateTo('/speaker/dashboard');
            }else
            {
                return navigateTo('/admin');
            }
           }
        }else
        {
            return navigateTo(to.path);
        }

    }


    // console.log(cookie);
    // console.log(!!cookie);
    // console.log(userStore().getUser());
    // if (!!cookie// const cookie = useNuxtApp().$cookie.get("token");) {
    //     userStore().setUser();
    //     const user=userStore().user;
    //     console.log(user);
    //     console.log(user.value);
    //     if(user)
    //     {
    //         console.log(userStore().user);
    //         if(user.type==0)
    //              return navigateTo("/");
    //         else if(user.type==1)
    //             return navigateTo("/speaker/dashboard");
    //         else if(user.type==2)
    //             return navigateTo("/admin");
    //     }else
    //     {
    //         useNuxtApp().$cookie.remove('token');
    //         navigateTo("/auth/login");
    //     }
    // }
});
