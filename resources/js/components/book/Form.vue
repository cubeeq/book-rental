<template>
    <div v-if="!authors || authors.length < 1" class="alert alert-warning d-flex mb-4">
        <div>You must have at least one author created.</div>
        <div class="ms-auto">
            <router-link to="/author/add">Create author</router-link>
        </div>
    </div>
    <h2 class="text-center mb-4">{{ getPageTitle() }} book</h2>
    <Spinner v-if="loading" />
    <div v-else>
        <form @submit.prevent="submitHandler">
    
            <div class="mb-3">
                <input
                    type="text"
                    class="form-control"
                    :class="errors.title && 'is-invalid'"
                    name="title"
                    id="title"
                    v-model="book.title"
                    placeholder="Title"
                >
                <div v-if="errors.title" class="invalid-feedback" id="titleFeedback">{{ errors.title[0] }}</div>
            </div>
    
            <div class="row">

                <div class="col-md-6 mb-3">
                    <select name="is_borrowed" class="form-select" aria-label="Default select">
                        <option value="0" :selected="!book.is_borrowed">Available</option>
                        <option value="1" :selected="book.is_borrowed">Borrowed</option>
                    </select>
                </div>
    
                <div class="col-md-6 mb-3">
                    <select name="author_id" class="form-select" :class="errors.author_id && 'is-invalid'" aria-label="Default select">
                        <option selected>Open this select menu</option>
                        <option
                            v-for="author in authors"
                            :key="author.id"
                            :value="author.id"
                            :selected="author.id === book.author_id"
                        >{{ author.name + ' ' + author.surname }}</option>
                    </select>
                    <div v-if="errors.author_id" class="invalid-feedback" id="titleFeedback">{{ errors.author_id[0] }}</div>
                </div>

            </div>
    
            <div class="text-center mt-3">
                <button type="submit" class="btn btn-primary mb-2">Submit</button>
                <br>
                <router-link to="/" class="text-muted">Back</router-link>
            </div>
    
        </form>
    </div>
</template>

<script>
import axios from 'axios';
import { api_url as api } from '../../config';
import Spinner from '../Spinner.vue';

export default {
    name: 'BookForm',

    data() {
        return {
            book: {},
            authors: [],
            loading: false,
            errors: {},
            form: [],
        }
    },

    async mounted() {
        this.loading = true;
        if (this.$route.name === 'BookEdit') await this.fetchBook();
        await this.fetchAuthors();
        this.loading = false;
    },

    methods: {

        async fetchBook() {
            await axios.get(api + '/book/book/' + this.$route.params.id)
                .then(response => this.book = response.data);
        },

        async fetchAuthors() {
            await axios.get(api + '/author')
                .then(response => this.authors = response.data);
        },

        submitHandler() {
            const link = this.getSubmitLink();
            const data = new FormData(event.target);
            this.loading = true;
            axios.post(api + link, data)
                .then(response => this.$router.push({ path: '/' }))
                .catch(response => this.errors = response.response.data.errors);
            this.loading = false;
            this.form = data;
        },

        getSubmitLink() {
            return this.$route.name === 'BookAdd'
                ? '/book/store/'
                : '/book/update/' + this.book.id;
        },

        getPageTitle() {
            return this.$route.name === 'BookAdd' ? 'Create' : 'Edit';
        },

    },

    components: {
        Spinner
    }

}
</script>