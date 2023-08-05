<template>
    <div>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <LayoutsHeader />
        <slot></slot>
        <LayoutsFooter />
    </div>
</template>

<script setup>
import {useToast}  from "vue-toast-notification";
watch(
  () => userStore().notification,
  (not, prevNot) => {
    useToast().success(userStore().notification);
  }
)






</script>

<style>
.notification {
    position: fixed;
    right: 1rem;
    bottom: 1rem;
    z-index: 100;
    padding: 1rem 1.5rem;
    background-color: #00a762;
    color: white;
    border-radius: 0.5rem;
}
.v-toast__text{
    background-color: green;
    color:white;
    animation-name: slideIn;
    animation-duration: 0.5s;
    animation-timing-function: ease-out;
    animation-delay: 0s;
    animation-iteration-count: 1;
    animation-direction: normal;
    animation-fill-mode: forwards;
    width: fit-content;
    position: absolute;
    top: 5%;
    right: 5%;
    padding: 20px;
    font-size: 20px;
    text-transform: capitalize;
    border-radius: 6px;
}

@keyframes slideIn {
    0% {
      transform: translateY(-100%);
      opacity: 0;
    }
    100% {
      transform: translateY(0);
      opacity: 1;
    }
  }
</style>
