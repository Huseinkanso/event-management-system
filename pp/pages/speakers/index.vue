<template>
  <div class="speakers my-5" style="min-height:100vh">
    <loading v-if="isLoading" />
    <div v-else class="container">
        <div v-if="speakers" class="row justify-content-center justify-content-md-around  align-items-center flex-wrap">
            <div  v-for="(speaker,i) in speakers" :key="i" class=" my-3 py-2 col-lg-4 col-md-5 col-sm-10">
                <speakerCard
                :img="speaker.image"
                :speaker_name="speaker.name"
                :description="speaker.description"
                :link="`/speakers/${speaker.slug}`" />
            </div>

        </div>
        <div v-else class="" ></div>
    </div>
  </div>
</template>

<script setup>
const isLoading=ref(false);
onMounted(()=>{
    getSpeakers();
})
const speakers=ref([]);
const getSpeakers=()=>{
    isLoading.value=true;
    useNuxtApp().$api.get('/speakers').then((res)=>{
        isLoading.value=false;
        console.log(res.data.speakers);
        speakers.value=res.data.speakers
    }).catch((err)=>{
        isLoading.value=false;
        console.log(err);
    })
}
</script>

<style>

</style>