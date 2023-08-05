<template>
    <ClientOnly>
        <div class="container py-3" style="min-height:100vh">
            <div class="d-flex flex-column justify-content-center  container">
                <div
                    class="d-flex flex-lg-row flex-column justify-content-lg-between justify-content-center align-items-center p-3">
                    <h1 class="p-2 ">All New Events</h1>
                    {{ status }}
                    <div class="d-flex flex-md-row flex-column justify-content-md-between justify-content-center ">
                        <div class="dropdown m-auto p-3 ">
                            <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                search by category
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark" data-bs-theme="dark">
                                <li v-for="(categorie, i) in categories" :key="i">
                                    <a style="cursor:pointer;" class="dropdown-item"
                                        @click="byCategory(categorie.categorie_name)">{{ categorie.categorie_name }}</a>
                                </li>

                            </ul>
                        </div>
                        <div class="dropdown m-auto p-3 ">
                            <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                search by time
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark" data-bs-theme="dark">
                                <li>
                                    <a style="cursor:pointer;" class="dropdown-item text-capitalize"
                                        @click="fetchEventsByTime('today')">today</a>
                                    <a style="cursor:pointer;" class="dropdown-item text-capitalize"
                                        @click="fetchEventsByTime('tomorrow')">tomorrow</a>
                                    <a style="cursor:pointer;" class="dropdown-item text-capitalize"
                                        @click="fetchEventsByTime('nextWeek')">next week</a>
                                    <a style="cursor:pointer;" class="dropdown-item text-capitalize"
                                        @click="fetchEventsByTime('nextMonth')">next month</a>
                                </li>

                            </ul>
                        </div>
                        <form @submit.prevent="searchEvent" class="p-3">
                            <input type="text" placeholder="Event Name "
                                class="form-controll p-1 rounded shadow border border-1 border-primary  mx-2"
                                v-model="form.searchValue">
                            <button type="submit" class="btn btn-primary mx-2">search</button>
                        </form>
                    </div>
                </div>
                <div class="d-flex justify-content-end p-3">
                    <ClientOnly>
                        <pagination v-if="isLoading == false" :paginationData="paginationData"
                             :fetchPaginationRequest="fetchPaginationRequest" />
                    </ClientOnly>
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
                <LazyEventComponent :event="event" :to="`event/${event.slug}`" />
            </section>
        </div>
    </ClientOnly>
</template>

<script setup>
definePageMeta({
    middleware:"auth",
    layout:"default",
})
const events = ref({});
const categories = ref([]);

const isLoading = ref(false);

const paginationData = ref({
    current_page: 0,
    from: 0,
    to: 0,
    last_page: 0,
    total: 0,

})
// variable to check if the first fetch or pagination fetch
const current_time = ref('');
const current_categorie = ref('');
const functionName = ref('');


const status = ref('');
const form = reactive({ searchValue: '' })

// const isThereNext = computed(() => {
//     return paginationData.value.current_page === paginationData.value.last_page
// })
// const isTherePrev = computed(() => {
//     return paginationData.value.current_page === 1;
// })
onMounted(() => {
    console.log(userStore().user);
    fetchCategories()
    fetchEvents()
})
function fetchCategories() {
    useNuxtApp().$api.get('categorie').then((res) => {
        categories.value = res.data.categories;
    })
}

function fetchEvents() {
    isLoading.value = true;
    let urlFetch = '';
        if (current_categorie.value != '') {
            urlFetch = `/categorie/${current_categorie.value}`;
            // form.searchValue = current_categorie.value;
        } else {
            urlFetch = `/event`;
        }
    useNuxtApp().$api.get(urlFetch).then((res) => {
        isLoading.value = false;
        console.log(res);
        if (res.data.events.data.length == 0) {
            status.value = 'there is no events';
        }
        events.value = res.data.events.data;
        storePaginationInfo(res.data.events.meta, res.data.events.links);
        console.log(events.value);

    })
        .catch((er) => {
            isLoading.value = false;
            console.log(er)
        })
}



function searchEvent(url) {
    isLoading.value = true;
    if (form.searchValue == '') {
        return;
    }
    useNuxtApp().$api.get(`/event/search/${form.searchValue}`).then((res) => {
        console.log(res.data);
        isLoading.value = false;
        if (events.value.length == 0) {
            status.value = 'there is no event with this name';
        } else {
            events.value = res.data.events.data;
            storePaginationInfo(res.data.events.meta, res.data.events.links);
        }

    }).catch((er) => {
        isLoading.value = false;
    })
}

function byCategory(categorie) {
    current_categorie.value = categorie;
    fetchEvents();
}

function fetchEventsByTime(time) {
    form.searchValue = current_time.value;
    isLoading.value = true;
    useNuxtApp().$api.get( `/event/time/${time}`).then((res) => {
        console.log(res);
        isLoading.value = false;
        events.value = res.data.events.data;
        storePaginationInfo(res.data.events.meta, res.data.events.links);
    }).catch((er) => {
        isLoading.value = false;
        console.log(er);
    })
}

function fetchPaginationRequest(url)
{
    isLoading.value = true;
    useNuxtApp().$api.get(url).then((res) => {
        isLoading.value = false;
        console.log(res);
        if (res.data.events.data.length == 0) {
            status.value = 'there is no events';
        }
        events.value = res.data.events.data;
        storePaginationInfo(res.data.events.meta, res.data.events.links);
        console.log(events.value);

    })
        .catch((er) => {
            isLoading.value = false;
            console.log(er)
        })
}

function storePaginationInfo(info, links) {
    paginationData.value.current_page = info.current_page;
    paginationData.value.last_page = info.last_page;
    paginationData.value.from = info.from;
    paginationData.value.to = info.to;
    paginationData.value.total = info.total;
    paginationData.value.links = links;
    console.log(paginationData.value);
}
</script>

<style></style>
