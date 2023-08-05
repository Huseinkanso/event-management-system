<template>
  <client-only>
    verify...
  </client-only>
</template>

<script>
export default {
    mounted()
    {
        this.$api.get(`/email/verify/${this.$route.query.id}/${this.$route.query.hash}?expires=${this.$route.query.expires}&signature=${this.$route.query.signature}`)
        .then((res)=>{
            console.log(res.data.notify);
            userStore().setNotification(res.data.data.notify);
            // userStore().getUser();
            navigateTo('/profile');

        })
        .catch((er)=>{

        })
    }
}
</script>

<style>

</style>