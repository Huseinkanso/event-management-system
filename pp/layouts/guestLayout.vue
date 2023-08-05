<template>
    <div class=" mt-auto">
        <div class="d-flex justify-content-center">
          <div class="col-12 col-md-6" style="margin:70px">
            <h2 class="text-center text-capitalize">welcome to eventile ,please:</h2>
            <div class="text-center m-5 d-flex justify-content-center">
                <svg  xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
            class="bi bi-calendar-event-fill" viewBox="0 0 16 16">
            <path
                d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4V.5zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2zm-3.5-7h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5z" />
            </svg>
            </div>
            <section class="bg-info-light position-relative overflow-hidden">
              <div class="d-none d-md-block position-absolute top-0 start-0 h-100 bg-white col-6">
              </div>
              <div class="container position-relative">
                <div class="mw-6xl mx-auto">
                  <div class="row align-items-center">
                    <slot></slot>
                  </div>
                </div>
              </div>
            </section>
          </div>
        </div>
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

<style></style>


