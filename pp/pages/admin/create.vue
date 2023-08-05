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
                            <label for="" class="form-label text-capitalize">ticket remaining:</label>
                            <input type="number" rows="4" v-model="data.event.ticket_remaining" class="form-control" />
                            <error-field :errors="data.errors" field="ticket_remaining" />
                        </div>
                        <div class="my-1 p-2">
                            <label for="" class="form-label text-capitalize">categorie:</label>
                            <select v-model="data.event.categorie_name" class="form-select" >
                                <option selected></option>
                                <option v-for="(categorie,i) in data.categories" :key="i" :value="categorie.categorie_name">
                                </option>
                              </select>
                              {{ data.event.categorie_name }}
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
    middleware: ["admin"],
})

onMounted(()=>{
fetchCategories();
})
function fetchCategories() {
    useNuxtApp().$api.get('categorie').then((res) => {
        data.categories = res.data.categories;
    })
}

const data = reactive({
    event: {
        name: '',
        description: '',
        address: '',
        image: '',
        ticket_price: '',
        ticket_remaining: '',
        published_at: '',
        date: '',
        categorie_name:'',
    },
    categories:'',
    errors: {},
})

function handleFile(e) {
    data.event.image = e.target.files[0]
};

function submit() {
    const NewForm = new FormData()
    Object.keys(data.event).forEach((key) => {
        NewForm.set(key, data.event[key])
    })
    useNuxtApp().$api
        .post('event', NewForm, {
            headers: {
                'content-type': 'multiform/form-data'
            }
        })
        .then((res) => {
            navigateTo('/event');
        })
        .catch((e) => {
            console.log(e.response);
            // data.errors = e.response.data.errors
        })
}

</script>

<style></style>
