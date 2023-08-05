<template>
    <LayoutsHeader />
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="container-fluid">
            <div class="row flex-nowrap">
                <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
                    <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                        <a href="#" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                            <span class="fs-5 d-none d-sm-inline">Menu</span>
                        </a>
                        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                            <li class="nav-item">
                                <nuxt-link :to="dashboardPrefix" class="nav-link align-middle px-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                                        <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5ZM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5 5 5Z"/>
                                      </svg> <span class="ms-1 d-none d-sm-inline">Dachboard</span>
                                </nuxt-link>
                            </li>
                            <li>
                                <a href="#submenu1" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                                    <svg  xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-calendar-event-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4V.5zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2zm-3.5-7h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5z" />
                                    </svg> <span class="ms-1 d-none d-sm-inline">Events</span> </a>
                                <ul class="collapse show nav flex-column ms-1" id="submenu1" data-bs-parent="#menu">
                                    <li class="w-100">
                                        <nuxt-link :to="`${dashboardPrefix}/event`" class="nav-link px-0"> <span class="d-none d-sm-inline text-capitalize">all my event</span> </nuxt-link>
                                    </li>
                                    <li>
                                        <nuxt-link :to="`${dashboardPrefix}/event/create`" class="nav-link px-0"> <span class="d-none d-sm-inline text-capitalize">create new event</span> </nuxt-link>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <nuxt-link :to="`${dashboardPrefix}/profile`" class="nav-link px-0"> <span class="d-none d-sm-inline text-capitalize">profile</span> </nuxt-link>
                            </li>
                            <li>
                                <nuxt-link :to="`${dashboardPrefix}/profile/edit`" class="nav-link px-0"> <span class="d-none d-sm-inline text-capitalize">edit profile</span> </nuxt-link>
                            </li>
                            <li>
                                <a href="#submenu2" data-bs-toggle="collapse" class="nav-link px-0 align-middle ">
                                    <i class="fs-4 bi-bootstrap"></i> <span class="ms-1 d-none d-sm-inline">Bootstrap</span></a>
                                <ul class="collapse nav flex-column ms-1" id="submenu2" data-bs-parent="#menu">
                                    <li class="w-100">
                                        <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Item</span> 1</a>
                                    </li>
                                    <li>
                                        <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Item</span> 2</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#submenu3" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                                    <i class="fs-4 bi-grid"></i> <span class="ms-1 d-none d-sm-inline">Products</span> </a>
                                    <ul class="collapse nav flex-column ms-1" id="submenu3" data-bs-parent="#menu">
                                    <li class="w-100">
                                        <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Product</span> 1</a>
                                    </li>
                                    <li>
                                        <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Product</span> 2</a>
                                    </li>
                                    <li>
                                        <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Product</span> 3</a>
                                    </li>
                                    <li>
                                        <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Product</span> 4</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" class="nav-link px-0 align-middle">
                                    <i class="fs-4 bi-people"></i> <span class="ms-1 d-none d-sm-inline">Customers</span> </a>
                            </li>
                        </ul>
                        <hr>
                    </div>
                </div>
                <div class="col py-3">
                    <slot ></slot>
                </div>
            </div>
        </div>



        <!-- Main content -->

    </div>
    <LayoutsFooter />
</template>

<script setup>
import {useToast}  from "vue-toast-notification";

const dashboardPrefix='/speaker/dashboard';

watch(
  () => userStore().notification,
  (not, prevNot) => {
    useToast().success(userStore().notification);
  }
)
watch(userStore().user, (newValue, oldValue) => {
  if(newValue==undefined)
  {
    useNuxtApp().$api.get(`/sanctum/csrf-cookie`);
    useNuxtApp().$api.get('/me').then((res)=>{
        userStore().user=res.data.user;
    });
  }
})
onMounted(() => {

})


</script>

<script >

</script>

<style>
.toggle {
    position: absolute;
    right: -10%;
    width: 30px;
    height: 30px;
    cursor:pointer;
}

.sidebar {
    position: relative;
    top: 20%;
    left: 0;
    height: 100vh;
    width: 0;
    background-color: #f8f9fa;
    padding: 20px;
    transition: all 0.3s ease;
}

.sidebar.open {
    width: 250px;
}

/* Media query for smaller screens */
@media (max-width: 576px) {}

.router-link-active {
    color:white !important;
}
</style>







  <!-- <div class="sidebar open ">
    <svg @click="toggleClass" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
        class="bi bi-list toggle" viewBox="0 0 16 16">
        <path fill-rule="evenodd"
            d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
    </svg>

</div> -->