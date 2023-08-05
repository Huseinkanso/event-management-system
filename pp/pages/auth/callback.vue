<template>
    <div v-if="isLoading" class="p-5 text-3xl text-red-500">
        loading...
    </div>
    <div v-else>
        congratulation
    </div>
</template>

<script>
export default {
    // setup() {

    //     const { data, pending, error, refresh } = await useAsyncData(
    //         'mountains',
    //         () =>
    //     )
    // },
    data()
    {
        return {
            isLoading:false,
        };
    },
    mounted() {
        this.isLoading=true;
        const store=userStore();
        // console.log(this.$route.query);
        this.$api.post('/login/github/callback', this.$route.query).then((res)=>{
            this.isLoading=false;
            this.$cookie.set('token',res.data.token);
            this.$api.defaults.headers.common.Authorization=`Bearer ${res.data.token}`;
            store.setLoggedId();
            navigateTo('/');
        }).catch((er)=>{
            navigateTo('/auth/login');
        })
    }
}

</script>