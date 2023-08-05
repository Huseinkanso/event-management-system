<template>
    <div class="py-4">
        <div class="container">
            <div class="row justify-content-center ">
                <div class="col-md-10  ">
                    <form @submit.prevent="submit" class="form border border-dark border-2 rounded shadow p-3">
                        <div class="my-2 p-2">
                            <label for="" class="form-label text-capitalize">Name:</label>
                            <input type="text" v-model="data.event.name" class="form-control">
                            <error-field :errors="data.errors" field="name" />
                        </div>
                        <div class="my-2 p-2">
                            <label for="" class="form-label text-capitalize">current image:</label><br>
                            <img :src="data.event.image" style="width:150px;height:150px" alt="">
                        </div>
                        <div class="my-2 p-2">
                            <label for="" class="form-label text-capitalize">new image(optional):</label>
                            <input type="file" @change="handleFile" class="form-control">
                        </div>
                        <div class="my-2 p-2">
                            <label for="" class="form-label text-capitalize">Description:</label>
                            <textarea type="text" rows="4" v-model="data.event.description" class="form-control"></textarea>
                            <error-field :errors="data.errors" field="decription" />
                        </div>
                        <div class="my-2 p-2">
                            <label for="" class="form-label text-capitalize">address:</label>
                            <textarea rows="4" v-model="data.event.address" class="form-control"></textarea>
                            <error-field :errors="data.errors" field="address" />
                        </div>
                        <div class="my-2 p-2">
                            <label for="" class="form-label text-capitalize">ticket price:</label>
                            <input type="number" rows="4" v-model="data.event.ticket_price" class="form-control" />
                            <error-field :errors="data.errors" field="ticket_count" />
                        </div>
                        <div class="my-2 p-2">
                            <label for="" class="form-label text-capitalize">ticket remaining:</label>
                            <input type="number" rows="4" v-model="data.event.ticket_remaining" class="form-control" />
                            <error-field :errors="data.errors" field="ticket_remaining" />
                        </div>
                        <div class="my-2 p-2">
                            <label for="" class="form-label text-capitalize">categorie:</label>
                            <select v-model="data.event.categorie_name" class="form-select">
                                <option selected></option>
                                <option v-for="(categorie, i) in data.categories" :key="i" :value="categorie.categorie_name">
                                    {{ categorie.categorie_name }}
                                </option>
                            </select>

                            <error-field :errors="data.errors" field="categorie_name" />
                        </div>
                        <div class="my-2 p-2">
                            <label for="" class="form-label text-capitalize">published at:</label>
                            <input type="datetime-local" rows="4" v-model="data.event.published_at" class="form-control" />
                            <error-field :errors="data.errors" field="published_at" />
                        </div>
                        <div class="my-2 p-2">
                            <label for="" class="form-label text-capitalize">date:</label>
                            <input type="datetime-local" rows="4" v-model="data.event.date" class="form-control" />
                            <error-field :errors="data.errors" field="date" />
                        </div>
                        <div class="my-2 p-2">
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

onMounted(() => {
    // console.log(useNuxtApp().$router.currentRoute._value.params.show);
    // console.log(useRoute().params.show);
    useNuxtApp().$api.get(`event/${useRoute().params.show}`).then((res)=>{
        console.log(res);
        data.event=res.data.event;
    })
    fetchCategories();
})
function fetchCategories() {
    useNuxtApp().$api.get('categorie').then((res) => {
        // console.log(res);
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
        categorie_name: '',
    },
    categories: '',
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
    // in axios patch we cant send 'content-type': 'multiform/form-data' so we use post and add manually
    // event with patchform it will not work we need to add manually the method and put content type
    NewForm.set('_method', 'patch')
    console.log(this.$api.defaults.headers.common.Authorization);
    useNuxtApp().$api
        .post(`event/${useRoute().params.show}`, NewForm, {
            // method:'PATCH',
            headers: {
                // 'Authorization': `Bearer ${this.$cookie.get('token')} `,
                'Content-Type': 'multiform/form-data'
            },
        })
        .then((res) => {
            navigateTo('/event');
        })
        .catch((e) => {
            if (e.response.data.errors)
                this.errors = e.response.data.errors
        })
}

</script>

<style></style>




