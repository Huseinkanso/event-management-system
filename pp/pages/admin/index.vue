<template>
    <div class="container py-3">
        <div class="d-flex flex-column justify-content-center  container">
            <div
                class="d-flex flex-lg-row flex-column justify-content-lg-between justify-content-center align-items-center p-3">
                <h1 class="p-2 ">All New Events</h1>
                <div class="d-flex flex-md-row flex-column justify-content-md-between justify-content-center ">
                    <div class="dropdown m-auto p-3 ">
                        <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            search by category
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark" data-bs-theme="dark">
                            <li v-for="(categorie, i) in categories" :key="i">
                                <a style="cursor:pointer;" class="dropdown-item"
                                    @click="fetchEvents(0, categorie.categorie_name)">{{ categorie.categorie_name }}</a>
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
                                    @click="fetchEventsByTime()">today</a>
                                <a style="cursor:pointer;" class="dropdown-item text-capitalize"
                                    @click="fetchEventsByTime()">tomorrow</a>
                                <a style="cursor:pointer;" class="dropdown-item text-capitalize"
                                    @click="fetchEventsByTime()">next week</a>
                                <a style="cursor:pointer;" class="dropdown-item text-capitalize"
                                    @click="fetchEventsByTime()">next month</a>
                            </li>

                        </ul>
                    </div>
                    <form @submit.prevent="searchEvent" class="p-3">
                        <input type="text" placeholder="Event Name " class="form-controll p-1 rounded shadow border border-1 border-primary  mx-2"
                            v-model="form.searchValue">
                        <button type="submit" class="btn btn-primary mx-2">search</button>
                    </form>
                </div>
            </div>
            <div class="d-flex justify-content-end p-3">
                <pagination :isTherePrev="isTherePrev" :paginationData="paginationData" :isThereNext="isThereNext"
                    :fetchEvents="runPaginationRequestForTheGivenData" />
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
            <LazyEventComponent :event="event" />
        </section>
    </div>
</template>

<script setup>
const events = ref({});
const isLoading = ref(false);
const paginationData = reactive({
    current_page: '',
    from: '',
    to: '',
    last_page: '',
    total: '',
    current_categorie: '',
    'links':''
})
const current_time=ref('');

const status = ref('');
const categories = ref([]);
const form = reactive({ searchValue: '' })
const functionName = ref('');
const isThereNext = computed(() => {
    return paginationData.current_page === paginationData.last_page
})

const isTherePrev = computed(() => {
    return paginationData.current_page === 1;
})
onMounted(() => {
    console.log(userStore().user.is_admin);
    fetchCategories()
    fetchEvents()
})
function fetchCategories() {
    useNuxtApp().$api.get('categorie').then((res) => {
        categories.value = res.data.categories;
    })
}
function fetchEvents(url='') {
    isLoading.value = true;
    if(url!='')
    {
    useNuxtApp().$api.get(url).then((res) => {
        isLoading.value = false;
        events.value = res.data.events.data;
        storePaginationInfo(res.data.events);

        console.log(res);
        console.log(events.value);
    })
        .catch((er) => {
            isLoading.value = false;
            console.log(er)
        })
}
}
function fetchEventsByCategories(categorie)
{

}
function searchEvent(url='') {
    functionName.value = 'searchEvent';
    isLoading.value = true;
    if (form.searchValue == '') {
        return;
    }
    let fetchUrl= url==''? `event/search/${form.searchValue}` : url
    useNuxtApp().$api.get(fetchUrl).then((res) => {
        isLoading.value = false;
        events.value = res.data.events.data;
        storePaginationInfo(res.data.events);
        if (events.value.length == 0) {
            status.value = 'there is no event with this name';
        }
        // form.searchValue = '';
    }).catch((er) => {
        isLoading.value = false;
    })
}

function ByTime(time)
{
    current_time.value=time;
    fetchEventsByTime();
}
function fetchEventsByTime(url='') {
    functionName.value = 'fetchEventsByTime';
    isLoading.value = true;
    let fetchUrl= url==''? `event/time/${current_time.value}` : url
    useNuxtApp().$api.get(fetchUrl).then((res) => {
        console.log(res);
        isLoading.value = false;
        events.value = res.data.events.data;
        storePaginationInfo(res.data.events);
    }).catch((er) => {
        isLoading.value = false;
        console.log(er);
    })
}

function runPaginationRequestForTheGivenData(url) {
    if (functionName.value == 'searchEvent') {
        searchEvent(url);
    } else if (functionName.value == 'fetchEvents') {
        fetchEvents(url);
    } else if (functionName.value == 'fetchEventsByTime') {
        fetchEventsByTime(url);
    }
}
function storePaginationInfo(info) {
    paginationData.current_page = info.current_page;
    paginationData.last_page = info.last_page;
    paginationData.from = info.from;
    paginationData.to = info.to;
    paginationData.total = info.total;
    paginationData.links = info.links;
}

</script>

<style></style>
