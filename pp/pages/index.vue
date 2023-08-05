<template>
    <h1>home</h1>
</template>

<script setup>
import { userStore } from '../store';

definePageMeta({
    middleware: ["auth"],
});


</script>

<style></style>