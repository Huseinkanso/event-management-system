<template>
    <div class="dashboard p-5 m-3">

    </div>
</template>

<script setup>
console.log(userStore().user);
definePageMeta({
    middleware: ["speaker"],
    layout:"dashboard",
})
</script>