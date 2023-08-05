<template>
    <form @submit.prevent="submit" class="">
        <div class="mb-4">
            <label class="form-label fw-light">Your Name *</label>
            <input v-model="speakerForm.name" class="form-control" type="text" placeholder="Enter email address" />
        </div>
        <error-field :errors="errors" field="name" />
        <div class="mb-4">
            <label class="form-label fw-light">update Image *</label>
            <input @change="handleFile" class="form-control" type="file" />
            <div class="">
                <div class="form-label fw-light my-3">Current Image *</div>
                <img :src="speaker.image" alt=""
                    class="img-thumbnail rounded shadow border border-1 border-black w-50 h-50">
            </div>
        </div>
        <error-field :errors="errors" field="image" />
        <div class="mb-4">
            <label class="form-label fw-light">Job title *</label>
            <input v-model="speakerForm.job_title" class="form-control" type="text" placeholder="job title" />
        </div>
        <error-field :errors="errors" field="job_title" />
        <div class="mb-4">
            <label class="form-label fw-light">Description * </label>
            <input v-model="speakerForm.description" class="form-control" type="text" placeholder="description" />
        </div>
        <error-field :errors="errors" field="description" />
        <div class="mb-4">
            <label class="form-label fw-light">Company Name * </label>
            <input v-model="speakerForm.company_name" class="form-control" type="text" placeholder="company name" />
        </div>
        <error-field :errors="errors" field="company_name" />
        <div class="mb-4">
            <label class="form-label fw-light">Facebook url</label>
            <input v-model="speakerForm.facebook_url" class="form-control" type="url" placeholder="facebook url" />
        </div>
        <error-field :errors="errors" field="facebook_url" />
        <div class="mb-4">
            <label class="form-label fw-light">Twitter url</label>
            <input v-model="speakerForm.twitter_url" class="form-control" type="url" placeholder="twitter url" />
        </div>
        <error-field :errors="errors" field="twitter_url" />
        <div class="fs-3  text-capitalize">update payment:(optional) check for update:
            <input id="checkPayment" v-model="checkPayment" type="checkbox">
        </div>
        <div class="mb-4">
            <label class="form-label fw-light">Your City: *</label>
            <input v-model="billing_details.address.city" class="form-control" type="text"
                placeholder="confirm your password" />
        </div>
        <error-field :errors="errors" field="city" />
        <div class="mb-4">
            <label class="form-label fw-light">Your Country: *</label>
            <input v-model="billing_details.address.country" class="form-control" type="text" placeholder="country" />
        </div>
        <error-field :errors="errors" field="country" />
        <div class="mb-4">
            <label class="form-label fw-light">First Line Address: *</label>
            <input v-model="billing_details.address.line1" class="form-control" type="text" placeholder="line1" />
        </div>
        <error-field :errors="errors" field="line1" />
        <div class="mb-4">
            <label class="form-label fw-light">Postal Code: *</label>
            <input v-model="billing_details.address.postal_code" class="form-control" type="text"
                placeholder="postal_code" />
        </div>
        <error-field :errors="errors" field="postal_code" />
        <div class="mb-4">
            <label class="form-label fw-light">State: *</label>
            <input v-model="billing_details.address.state" class="form-control" type="text" placeholder="state" />
        </div>
        <error-field :errors="errors" field="state" />
        <div id="card-element" class="p-3 border border-gray-900"></div>
        <div v-if="cardError" class="fs-6 text-danger fw-bold">{{ cardError }}</div>
        <button type="submit" class="btn my-3 btn-primary">update</button>
        <loading v-if="isLoading" />
    </form>
</template>

<script setup>
definePageMeta({
    middleware: ["speaker"],
    layout: "dashboard"
});
const speaker = userStore().user;
const checkPayment = ref(false);
onMounted(() => {
    ComponentLoading.value = true;
    stripe.value = window.Stripe(useRuntimeConfig().public.STRIPE_API_KEY)
    const elements = stripe.value.elements()
    cardElement.value = elements.create('card')
    cardElement.value.mount('#card-element')
    ComponentLoading.value = false;
})

const cardElement = ref(null);
const stripe = ref(null);
const ComponentLoading = ref(false);
const errors = ref('');
const isLoading = ref(false);
const cardError = ref('');

const speakerForm = reactive({
    name: speaker.name,
    email: speaker.email,
    password: speaker.password,
    password_confirmation: speaker.password_confirmation,
    image: '',
    job_title: speaker.job_title,
    description: speaker.description,
    company_name: speaker.company_name,
    facebook_url: speaker.facebook_url,
    twitter_url: speaker.twitter_url,
    type: speaker.type,
    stripe_account_id: '',
})

const billing_details = reactive({
    name: speakerForm.name,
    address: {
        city: 'test',
        country: 'US',
        line1: 'test',
        postal_code: '24242',
        state: 'test'
    },
})
function handleFile(e) {
    speakerForm.image = e.target.files[0]
};
async function verifyCard() {
    isLoading.value = true
    const { paymentMethod, error } = await stripe.value.createPaymentMethod(
        'card',
        cardElement.value,
        {
            billing_details: billing_details
        }
    )
    //   console.log(error);
    if (error) {
        isLoading.value = false
        cardError.value = error.message;
        console.log(error);
        return;
        // errors.value=error;
        // Display "error.message" to the user...
    } else {
        return paymentMethod;
    }
};

async function submit() {
    let paymentMethod;
    let NewForm = new FormData();
    if (checkPayment.value) {
        paymentMethod = await verifyCard();
        if (!paymentMethod)
            return;
        NewForm.set('stripe_account_id', paymentMethod['id'])
    }
    Object.keys(speakerForm).forEach((key) => {
        if(!!speakerForm[key])
            NewForm.set(key, speakerForm[key])
    })
    NewForm.set('_method', 'patch')
    useNuxtApp().$api.post(`/updateSpeakerInfo/${speaker.id}`, NewForm,{
        headers: {
                'Content-Type': 'multiform/form-data'
            },
    })
        .then((res) => {
            userStore().setNotification(res.data.notify);
            isLoading.value = false;
            navigateTo('/speaker/dashboard/profile');
        })
        .catch((er) => {
            isLoading.value = false;
            if (er.response && er.response.data && er.response.data.errors)
                errors.value = er.response.data.errors;
        });
}
</script>

<style></style>