<template >
    <ClientOnly>

        <div class="container py-3">
            <div class="d-flex flex-column justify-content-center  container">
                <div
                    class="d-flex flex-lg-row flex-column justify-content-lg-between justify-content-center align-items-center p-3">
                    <h1 class="p-2 ">All New Events</h1>
                    <search-data @setLoading="setLoading" @setData="setData" />
                </div>
                <div class="text-end">
                    <nuxt-link to="/speaker/dashboard/event/create" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-plus-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                            <path
                                d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                        </svg>
                        create new event</nuxt-link>
                </div>
            </div>
            <div v-if="isLoading">
                <Lazyloading />
            </div>
            <div v-else-if="status != ''">
                <span class="text-secondary text-capitalize fs-3">
                    {{ status }}
                </span>
            </div>
            <section v-else v-for="(event, i) in events" :key="i" class="w-80 p-5 my-2 mh-100  rounded shadow">
                <LazyEventComponent :event="event"  />
            </section>

        </div>
    </ClientOnly>
</template>

<script  setup>
definePageMeta({
    middleware: ["speaker"],
    layout: "dashboard",
})
const events = ref();
const isLoading = ref(false);
function setLoading(bool) {
    isLoading.value = bool
}
function setData(data) {
    events.value = data
}

const status = ref('');


onMounted(() => {
    fetchEvents()
})

function fetchEvents(url = '') {
    isLoading.value = true;

    useNuxtApp().$api.get(`/myEvents`).then((res) => {
        isLoading.value = false;
        console.log(res);
        events.value = res.data;
        // storePaginationInfo(res.data.events.meta, res.data.events.links);
        console.log(events.value);

    })
        .catch((er) => {
            isLoading.value = false;
            console.log(er)
        })
}







// function runPaginationRequestForTheGivenData(url) {
//     if (functionName.value == 'searchEvent') {
//         searchEvent(url);
//     } else if (functionName.value == 'fetchEvents') {
//         fetchEvents(url);
//     } else if (functionName.value == 'fetchEventsByTime') {
//         fetchEventsByTime(url);
//     }
// }
// function storePaginationInfo(info, links) {
//     paginationData.value.current_page = info.current_page;
//     paginationData.value.last_page = info.last_page;
//     paginationData.value.from = info.from;
//     paginationData.value.to = info.to;
//     paginationData.value.total = info.total;
//     paginationData.value.links = links;
//     console.log(paginationData.value);
// }
</script>

<style></style>
