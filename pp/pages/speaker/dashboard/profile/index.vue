<template>
    <div class="profile my-4">
        <div class="container">
          <div v-if="user" class="row justify-content-center flex-column">
            <div class="col-lg-6 col-md-8 col-sm-10 text-center m-auto">
              <img :src="user.image" alt="" class="rounded shadow border border-1 border-black w-50 h-50">
              <h2 class="my-3 mx-auto">{{ user.name }}</h2>
            </div>
            <div class="col-lg-8 col-md-10 col-sm-12 fs-4 my-3">
              <div class="description">
                <span class="text-secondary fw-bold m-2 p-2 text-capitalize">description:</span>
                <div class="ms-4 border-0">
                  <span v-if="user.description">{{ user.description }}</span>
                  <span v-else class="text-muted">Not provided</span>
                </div>
              </div>
            </div>
            <div class="col-lg-8 col-md-10 col-sm-12 fs-4 my-3">
              <div class="company">
                <span class="text-secondary fw-bold m-2 p-2 text-capitalize">company name:</span>
                <div class="ms-4 border-0">
                  <span v-if="user.company_name">{{ user.company_name }}</span>
                  <span v-else class="text-muted">Not provided</span>
                </div>
              </div>
            </div>
            <div class="col-lg-8 col-md-10 col-sm-12 fs-4 my-3">
              <div class="job-title">
                <span class="text-secondary fw-bold m-2 p-2 text-capitalize">job title:</span>
                <div class="ms-4 border-0">
                  <span v-if="user.job_title">{{ user.job_title }}</span>
                  <span v-else class="text-muted">Not provided</span>
                </div>
              </div>
            </div>
            <div class="col-lg-8 col-md-10 col-sm-12 fs-4 my-3">
              <div class="created-at">
                <span class="text-secondary fw-bold m-2 p-2 text-capitalize">created at:</span>
                <div class="ms-4 border-0">
                  <span v-if="user.created_at">{{ user.created_at }}</span>
                  <span v-else class="text-muted">Not provided</span>
                </div>
              </div>
            </div>
            <div class="col-lg-8 col-md-10 col-sm-12 fs-4 my-3">
              <div class="updated-at">
                <span class="text-secondary fw-bold m-2 p-2 text-capitalize">updated at:</span>
                <div class="ms-4 border-0">
                  <span v-if="user.updated_at">{{ user.updated_at }}</span>
                  <span v-else class="text-muted">Not provided</span>
                </div>
              </div>
            </div>
            <div class="col-lg-8 col-md-10 col-sm-12 fs-4 my-3">
              <div class="social-links">
                <span class="text-secondary fw-bold m-2 p-2 text-capitalize">social links:</span>
                <a v-if="user.facebook_url" :href="user.facebook_url" class="text-primary mx-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-facebook-filled" style="width:20px;height:20px;border-radius:50%" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M18 2a1 1 0 0 1 .993 .883l.007 .117v4a1 1 0 0 1 -.883 .993l-.117 .007h-3v1h3a1 1 0 0 1 .991 1.131l-.02 .112l-1 4a1 1 0 0 1 -.858 .75l-.113 .007h-2v6a1 1 0 0 1 -.883 .993l-.117 .007h-4a1 1 0 0 1 -.993 -.883l-.007 -.117v-6h-2a1 1 0 0 1 -.993 -.883l-.007 -.117v-4a1 1 0 0 1 .883 -.993l.117 -.007h2v-1a6 6 0 0 1 5.775 -5.996l.225 -.004h3z" stroke-width="0" fill="currentColor" />
                  </svg>
                </a>
                <a v-if="user.twitter_url" :href="user.twitter_url" class="text-primary mx-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-twitter-filled" style="width:20px;height:30px;border-radius:50%" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M14.058 3.41c-1.807 .767 -2.995 2.453 -3.056 4.38l-.002 .182l-.243 -.023c-2.392 -.269 -4.498 -1.512 -5.944 -3.531a1 1 0 0 0 -1.685 .092l-.097 .186l-.049 .099c-.719 1.485 -1.19 3.29 -1.017 5.203l.03 .273c.283 2.263 1.5 4.215 3.779 5.679l.173 .107l-.081 .043c-1.315 .663 -2.518 .952 -3.827 .9c-1.056 -.04 -1.446 1.372 -.518 1.878c3.598 1.961 7.461 2.566 10.792 1.6c4.06 -1.18 7.152 -4.223 8.335 -8.433l.127 -.495c.238 -.993 .372 -2.006 .401 -3.024l.003 -.332l.393 -.779l.44 -.862l.214 -.434l.118 -.247c.265 -.565 .456 -1.033 .574 -1.43l.014 -.056l.008 -.018c.22 -.593 -.166 -1.358 -.941 -1.358l-.122 .007a.997 .997 0 0 0 -.231 .057l-.086 .038a7.46 7.46 0 0 1 -.88 .36l-.356 .115l-.271 .08l-.772 .214c-1.336 -1.118 -3.144 -1.254 -5.012 -.554l-.211 .084z" stroke-width="0" fill="currentColor" />
                  </svg>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
</template>

<script setup>
definePageMeta({
    middleware: ["speaker"],
    layout:"dashboard"
});

const user = computed(() => {
    return userStore().user;
})




</script>

<style></style>