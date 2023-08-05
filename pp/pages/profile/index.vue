<template>
    <ClientOnly>
        <div>
            <div class="p-3">
                <ul class="nav nav-underline">
                    <li class="nav-item">
                        <a style="cursor:pointer;" :class="{ active: payments }" class="nav-link text-capitalize" @click="showRelated('payments')">payments
                            and tickets</a>
                    </li>
                    <li class="nav-item">
                        <a style="cursor:pointer;" :class="{ active: userInfo }" class="nav-link text-capitalize " @click="showRelated('userInfo')">User
                            info</a>
                    </li>
                </ul>
            </div>
            <LazyPaymentTicket v-if="payments" />
            <LazyUserInfo v-else />
        </div>
    </ClientOnly>
</template>

<script setup>
definePageMeta({
    middleware: ["auth"],
});

const payments = ref(true);
const userInfo = ref(false);
onMounted(() => {
    userStore().setUser();
})

const emailVerified = computed(() => {
    return userStore().user.email_verified_at;
})




</script>

<style></style>