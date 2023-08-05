<template>
    <div class="py-4">
        <div class="container">
            <div class="row justify-content-center ">
                <div class="col-md-10  ">
                    <form @submit.prevent="submit" class="form border border-dark border-2 rounded shadow p-3">
                        <div class="my-1 p-2">
                            <label for="" class="form-label text-capitalize">Name:</label>
                            <input type="text" v-model="data.event.name" class="form-control">
                            <error-field :errors="data.errors" field="name" />
                        </div>
                        <div class="my-1 p-2">
                            <label for="" class="form-label text-capitalize">image(optional):</label>
                            <input type="file" @change="handleFile" class="form-control">
                        </div>
                        <div class="my-1 p-2">
                            <label for="" class="form-label text-capitalize">Description:</label>
                            <textarea type="text" rows="4" v-model="data.event.description" class="form-control"></textarea>
                            <error-field :errors="data.errors" field="decription" />
                        </div>
                        <div class="my-1 p-2">
                            <label for="" class="form-label text-capitalize">address:</label>
                            <textarea rows="4" v-model="data.event.address" class="form-control"></textarea>
                            <error-field :errors="data.errors" field="address" />
                        </div>
                        <div class="my-1 p-2">
                            <label for="" class="form-label text-capitalize">ticket price:</label>
                            <input type="number" rows="4" v-model="data.event.ticket_price" class="form-control" />
                            <error-field :errors="data.errors" field="ticket_count" />
                        </div>
                        <div class="my-1 p-2">
                            <label for="" class="form-label text-capitalize">ticket number:</label>
                            <input type="number" rows="4" v-model="data.event.ticket_number" class="form-control" />
                            <error-field :errors="data.errors" field="ticket_number" />
                        </div>
                        <div class="my-1 p-2">
                            <label for="" class="form-label text-capitalize">categorie:</label>
                            <select v-model="data.event.categorie_name" class="form-select text-dark" >
                                <option class="text-white bg-primary" selected>...</option>
                                <option class="text-white bg-primary" v-for="(categorie,i) in categories" :key="i" :value="categorie.categorie_name">
                                    {{ categorie.categorie_name }}
                                </option>
                              </select>
                            <error-field :errors="data.errors" field="categorie_name" />
                        </div>
                        <div class="my-1 p-2">
                            <label for="" class="form-label text-capitalize">published at:</label>
                            <input type="datetime-local" rows="4" v-model="data.event.published_at" class="form-control" />
                            <error-field :errors="data.errors" field="published_at" />
                        </div>
                        <div class="my-1 p-2">
                            <label for="" class="form-label text-capitalize">date:</label>
                            <input type="datetime-local" rows="4" v-model="data.event.date" class="form-control" />
                            <error-field :errors="data.errors" field="date" />
                        </div>
                        <div class="my-1 p-2">
                            <button type="submit" class="btn btn-primary py-2 px-3">create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
definePageMeta({
    middleware: ["speaker"],
    layout:"dashboard",
})

onMounted(()=>{
 fetchCategories();
})

const categories=ref([]);
const user_id=userStore().user.id;
const data = reactive({
    event: {
        name: '',
        description: '',
        address: '',
        image: '',
        ticket_price: '',
        ticket_number:'',
        published_at: '',
        date: '',
        categorie_name:'',
        speaker_id:user_id,
    },

    errors: {},
})
 function fetchCategories() {
     useNuxtApp().$api.get('categorie').then((res) => {
        console.log(res.data.categories);
        categories.value = res.data.categories;
    })
}
function handleFile(e) {
    data.event.image = e.target.files[0]
};

function submit() {
    const NewForm = new FormData()
    Object.keys(data.event).forEach((key) => {
        NewForm.set(key, data.event[key])
    })
    NewForm.set('ticket_remaining',data.event.ticket_number)
    useNuxtApp().$api
        .post('event', NewForm, {
            headers: {
                'content-type': 'multiform/form-data'
            }
        })
        .then((res) => {
            if(res.data && res.data.notify)
            {
                userStore().setNotification(res.data.notify);
            }
            navigateTo('/speaker/dashboard/event');
        })
        .catch((e) => {
            if(e.response && e.response.data && e.response.data.errors)
                data.errors = e.response.data.errors
        })
}

</script>

<style></style>
