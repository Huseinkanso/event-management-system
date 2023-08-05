<template>
    <loading v-if="isLoading" />
    <div v-else class="">

        <div v-if="speaker" class="container mt-5">
            <div class="row align-items-center">
              <div class="col-md-4">
                <img :src="speaker.image" alt="Profile Image" class="img-fluid rounded-circle">
                <h3 class="text-capitalize text-center py-2 ">{{ speaker.name }} </h3>
              </div>
              <div class="col-md-8 py-2">
                <h2>Web Developer | 5 Years of Experience</h2>
                <p>{{ speaker.description }} </p>
                <ul class="list-unstyled">
                  <li class="py-3"><strong class="mx-2 text-secondary">Company Name:</strong>{{ speaker.company_name }}</li>
                  <li class="py-3"><strong class="mx-2 text-secondary">Job Title:</strong>{{ speaker.job_title }} </li>
                </ul>
                <div>
                  <strong class="mx-2 text-secondary">Social Links:</strong>
                  <a :href="speaker.facebook_url" class="  text-primary    mx-3" target="_blank" >
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-facebook-filled " style="width:20px;height:20px;border-radius:50%" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M18 2a1 1 0 0 1 .993 .883l.007 .117v4a1 1 0 0 1 -.883 .993l-.117 .007h-3v1h3a1 1 0 0 1 .991 1.131l-.02 .112l-1 4a1 1 0 0 1 -.858 .75l-.113 .007h-2v6a1 1 0 0 1 -.883 .993l-.117 .007h-4a1 1 0 0 1 -.993 -.883l-.007 -.117v-6h-2a1 1 0 0 1 -.993 -.883l-.007 -.117v-4a1 1 0 0 1 .883 -.993l.117 -.007h2v-1a6 6 0 0 1 5.775 -5.996l.225 -.004h3z" stroke-width="0" fill="currentColor" />
                      </svg>
                </a>
                <a :href="speaker.twitter_url" class=" text-primary   mx-3" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-twitter-filled " style="width:20px;height:30px;border-radius:50%" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M14.058 3.41c-1.807 .767 -2.995 2.453 -3.056 4.38l-.002 .182l-.243 -.023c-2.392 -.269 -4.498 -1.512 -5.944 -3.531a1 1 0 0 0 -1.685 .092l-.097 .186l-.049 .099c-.719 1.485 -1.19 3.29 -1.017 5.203l.03 .273c.283 2.263 1.5 4.215 3.779 5.679l.173 .107l-.081 .043c-1.315 .663 -2.518 .952 -3.827 .9c-1.056 -.04 -1.446 1.372 -.518 1.878c3.598 1.961 7.461 2.566 10.792 1.6c4.06 -1.18 7.152 -4.223 8.335 -8.433l.127 -.495c.238 -.993 .372 -2.006 .401 -3.024l.003 -.332l.393 -.779l.44 -.862l.214 -.434l.118 -.247c.265 -.565 .456 -1.033 .574 -1.43l.014 -.056l.008 -.018c.22 -.593 -.166 -1.358 -.941 -1.358l-.122 .007a.997 .997 0 0 0 -.231 .057l-.086 .038a7.46 7.46 0 0 1 -.88 .36l-.356 .115l-.271 .08l-.772 .214c-1.336 -1.118 -3.144 -1.254 -5.012 -.554l-.211 .084z" stroke-width="0" fill="currentColor" />
                      </svg>
                </a>
                </div>
              </div>
            </div>
          </div>
          <div v-else class="text-danger text-italic fs-4 text-capitalize text-center" >
            sorry ,info not found
          </div>
          <div v-if="events" class="events">
            <div class="container my-4">
                <h1 class="text-secondary my-2">Events:</h1>
                <section  v-for="(event, i) in events" :key="i" class="w-80 p-5 my-4 mh-100  rounded shadow">
                    <LazyEventComponent :event="event" :to="`/event/${event.slug}`" />
                </section>
            </div>
          </div>
          <div v-if="events.length==0" class="fs-3 text-center p-4">
            sorry,there is no events right now
          </div>
    </div>
</template>

<script setup>
const isLoading=ref(false);
const speaker = ref([]);
const events=ref([]);
onMounted(()=>{
    getSpeakerInfo(useRoute().params.speakerSlug);
})

const getSpeakerInfo=(speakerSlug)=>{
    isLoading.value=true;
    useNuxtApp().$api.get(`/speakerInfo/${speakerSlug}`).then((res)=>{
        isLoading.value=false;
        speaker.value=res.data.speaker
        events.value=res.data.events
    }).catch((err)=>{
        isLoading.value=false;
        console.log(err);
    })
}
definePageMeta({
    middleware: ["auth"],
    layout:"default"
});





</script>

<style></style>