<template>
    <h3 class="text-center">register new account</h3>
    <div class="p-3 d-flex justify-content-center align-items-center">
        <ul class="nav nav-underline">
            <li class="nav-item">
                <NuxtLink to="/auth/register/registerUser" class="a nav-link text-capitalize">
                    user
                </NuxtLink>
            </li>
            <li class="nav-item">
                <NuxtLink to="/auth/register/registerSpeaker" class="a nav-link text-capitalize">
                    Speaker
                </NuxtLink>
            </li>
            <li class="nav-item">
                <nuxt-link class="nav-link" to="/auth/login">go to login</nuxt-link>
            </li>
        </ul>

    </div>
        <NuxtPage/>
</template>

<script setup>
definePageMeta({
    middleware: ['guest'],
    layout: "guest-layout",
})


</script>

<style>
.router-link-active.a {
    color:black !important;
}

</style>


<!-- // async RegisterWithGoogle() {
    //     this.isLoading = true;
    //     this.$api.get('/register/google').then((res) => {
    //         this.isLoading = false;
    //         if (res.data.url) {

    //             window.location.href = res.data.url
    //         }
    //     }).catch((er) => { this.isLoading = false; })
    // }, -->

    <!-- <div class="d-flex mb-5 flex-wrap align-items-center justify-content-between">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="" id=""/>
          <label class="form-check-label fs-9" for="" >Remember Me</label>
        </div>
        <div><a class="btn p-0 btn-link fs-9" href="#" >Forgot Password?</a></div>
      </div><a class="btn w-100 mb-8 btn-primary shadow" href="#" >Sign In</a>
      <div class="text-center mb-5"><span class="fs-9 text-secondary" >Or continue with</span></div>
      <div class="d-lg-flex align-items-center"><a class="btn d-flex justify-content-center px-3 mb-2 mb-lg-0 me-lg-4 btn-light border fw-semibold" href="#">
          <svg width="19" height="20" viewbox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M9.64622 3.94602C10.9855 3.9452 12.2818 4.41846 13.3054 5.28195L16.1729 2.55134C15.0721 1.53639 13.75 0.791963 12.3114 0.377139C10.8727 -0.0376843 9.35723 -0.111485 7.88511 0.161594C6.41298 0.434673 5.02477 1.04711 3.83064 1.95031C2.63651 2.85351 1.66933 4.02261 1.00586 5.36482L4.23849 7.85648C4.61549 6.71964 5.34062 5.73023 6.31117 5.0284C7.28173 4.32657 8.4485 3.9479 9.64622 3.94602Z" fill="#D94F3D"></path>
            <path d="M3.94597 9.64569C3.94678 9.03746 4.04537 8.43333 4.23797 7.85641L1.00534 5.36475C0.344108 6.69493 0 8.16021 0 9.64569C0 11.1312 0.344108 12.5964 1.00534 13.9266L4.23797 11.435C4.04537 10.858 3.94678 10.2539 3.94597 9.64569Z" fill="#F2C042"></path>
            <path d="M18.8967 7.89197H9.68945V11.8379H14.9069C14.5965 12.9537 13.8854 13.9156 12.9098 14.5396L16.1174 17.0124C18.1672 15.1727 19.3715 12.1812 18.8967 7.89197Z" fill="#5085ED"></path>
            <path d="M12.9091 14.5397C11.9178 15.107 10.7877 15.3862 9.64622 15.3455C8.4485 15.3436 7.28173 14.965 6.31117 14.2631C5.34062 13.5613 4.61549 12.5719 4.23849 11.4351L1.00586 13.9267C1.80432 15.5363 3.03604 16.8911 4.56247 17.8389C6.0889 18.7866 7.84949 19.2897 9.64622 19.2915C12.0105 19.3557 14.315 18.5437 16.1167 17.0116L12.9091 14.5397Z" fill="#57A75C"></path>
          </svg><span class="ms-2" >Sign in with Google</span></a><a class="btn d-flex justify-content-center px-3 btn-light border fw-semibold" href="#">
          <svg width="22" height="20" viewbox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M21.0617 10.0602C21.0615 8.13735 20.5103 6.25481 19.4734 4.63546C18.4365 3.01611 16.9573 1.72778 15.211 0.922985C13.4646 0.118189 11.5243 -0.169366 9.61956 0.0943624C7.71486 0.358091 5.92561 1.16206 4.46364 2.41109C3.00166 3.66011 1.92819 5.30189 1.3703 7.14205C0.812418 8.98222 0.793484 10.9437 1.31574 12.7943C1.838 14.6449 2.87958 16.3071 4.31717 17.5841C5.75476 18.8611 7.52816 19.6995 9.42741 19.9999V12.969H6.87247V10.0602H9.42741V7.84321C9.42741 5.32181 10.93 3.9282 13.2275 3.9282C13.9823 3.93903 14.7353 4.0046 15.4806 4.12441V6.60137H14.2111C13.829 6.55064 13.4423 6.65376 13.1361 6.88805C12.83 7.12234 12.6294 7.46862 12.5785 7.85075C12.5641 7.95776 12.5619 8.06606 12.5718 8.17358V10.0602H15.3599L14.9138 12.969H12.566V19.9999C14.9339 19.6268 17.0909 18.4204 18.6484 16.5982C20.206 14.7759 21.0618 12.4574 21.0617 10.0602Z" fill="#3A81EF"></path>
          </svg><span class="ms-2" >Sign in with Facebook</span></a></div> -->