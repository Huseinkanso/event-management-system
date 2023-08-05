<template>
    <client-only>
        <div class="my-3">
            <h3 class="text-center">type your email:</h3>
            <div class="d-flex justify-content-center">
                <div class="shadow p-4 my-2  bg-white">
                    <form @submit.prevent="submit">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Enter Your Email:</label>
                            <input v-model="theEmail" type="email" class="form-control" id="exampleInputEmail1"
                                aria-describedby="emailHelp">
                            <error-field :errors="errors" field="email"/>
                        </div>
                        <div class="my-3">
                            <button type="submit" class="btn btn-primary">send</button>
                        </div>
                        <loading v-if="isLoading"/>
                    </form>
                </div>
            </div>
        </div>
    </client-only>
</template>

<script setup>
definePageMeta({
    middleware: ["guest"],
    layout:"guest-layout",
})
const theEmail = ref("")
const errors = ref({})
const isLoading = ref(false)
function submit() {
    isLoading.value=true;
    useNuxtApp().$api.get(`/sanctum/csrf-cookie`);
    useNuxtApp().$api.post('/forgot-password',{email:theEmail.value}).then((res)=>{
        console.log(res.data);
        userStore().setNotification(res.data.notify)
        isLoading.value=false;
    })
    .catch(er=>{
        isLoading.value=false;
        errors.value=er.response && er.response.data && er.response.data.errors ? er.response.data.errors : ''
    })
}



</script>

<style></style>