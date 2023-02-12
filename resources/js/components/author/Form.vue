<template>
    <h2 class="text-center mb-4">{{ getPageTitle() }} author</h2>
    <Spinner v-if="loading" />
    <div v-else>
        <form @submit.prevent="submitHandler">

            <div class="row">

                <div class="col-md-6 mb-3">
                    <input
                        type="text"
                        class="form-control"
                        :class="errors.name && 'is-invalid'"
                        name="name"
                        id="name"
                        v-model="author.name"
                        placeholder="Name"
                    >
                    <div v-if="errors.name" class="invalid-feedback" id="nameFeedback">{{ errors.name[0] }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <input
                        type="text"
                        class="form-control"
                        :class="errors.surname && 'is-invalid'"
                        name="surname"
                        id="surname"
                        v-model="author.surname"
                        placeholder="Surname"
                    >
                    <div v-if="errors.surname" class="invalid-feedback" id="surnameFeedback">{{ errors.surname[0] }}</div>
                </div>

            </div>
    
            <div class="text-center mt-3">
                <button type="submit" class="btn btn-primary mb-2">Submit</button>
                <br>
                <router-link to="/authors" class="text-muted">Back</router-link>
            </div>
    
        </form>
    </div>
</template>

<script>
import axios from 'axios';
import { api_url as api } from '../../config';
import Spinner from '../Spinner.vue';

export default {
    name: 'AuthorForm',

    data() {
        return {
            author: {},
            books: [],
            loading: false,
            errors: {},
            form: [],
        }
    },

    async mounted() {
        this.loading = true;
        if (this.$route.name === 'AuthorEdit') await this.fetchAuthor();
        this.loading = false;
    },

    methods: {

        async fetchAuthor() {
            await axios.get(api + '/author/author/' + this.$route.params.id)
                .then(response => this.author = response.data);
        },

        submitHandler() {
            const link = this.getSubmitLink();
            const data = new FormData(event.target);
            this.loading = true;
            axios.post(api + link, data)
                .then(response => this.$router.push({ path: '/authors' }))
                .catch(response => this.errors = response.response.data.errors);
            this.loading = false;
            this.form = data;
        },

        getSubmitLink() {
            return this.$route.name === 'AuthorAdd'
                ? '/author/store/'
                : '/author/update/' + this.author.id;
        },

        getPageTitle() {
            return this.$route.name === 'AuthorAdd' ? 'Create' : 'Edit';
        },

    },

    components: {
        Spinner
    }

}
</script>