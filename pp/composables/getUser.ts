export const getUser = async()=>{
    await useAsyncData(()=>{
        useNuxtApp().$api.get('/me').then((res)=>{
            console.log(res.data.user);
            userStore().user=res.data.user;
        })
    })
}