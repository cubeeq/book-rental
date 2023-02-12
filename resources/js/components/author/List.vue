<template>
    <Spinner v-if="loading" />
    <div v-else>

        <h2 class="text-center mb-4">Author list</h2>

        <Filter :authors="authors" @set-authors="filter" />

        <ul v-if="authors && authors.length > 0" class="list-group">
            <li v-for="author in authors" :key="author.id" class="list-group-item d-flex">
                <div>
                    <strong>{{ author.surname }}</strong>&nbsp;<span>{{ author.name }}</span>&nbsp;<small class="text-muted">({{ author.books_count }})</small>
                </div>
                <div class="ms-auto">
                    <router-link :to="'/author/edit/' + author.id" class="text-decoration-none text-muted mx-1">Edit</router-link>
                    <span class="text-danger">&middot;</span>
                    <a href="#" class="text-decoration-none text-muted mx-1" @click.prevent="this.delete(author.id)">Delete</a>
                </div>
            </li>
        </ul>

        <div v-else class="text-muted text-center my-4">No items</div>

        <div class="text-center mt-3">
            <router-link to="/author/add/" class="btn btn-primary">Add author</router-link>
        </div>

    </div>
</template>

<script>
import { api_url as api } from '../../config';
import Spinner from '../Spinner.vue';
import Filter from './Filter.vue';

export default {
    name: "Authors",

    data() {
        return {
            segment: '/author',
            authors: [],
            loading: false,
        };
    },

    mounted() {
        this.fetchUsers();
    },

    methods: {

        fetchUsers() {
            this.loading = true;
            this.authors = [];
            axios.get(api + this.segment)
                .then((response) => {
                    this.authors = response.data;
                    this.loading = false;
                });
        },

        delete(id) {
            if (!confirm('really?')) return;
            axios.get(api + this.segment + '/destroy/' + id)
                .then(response => this.authors = this.authors.filter((el) => el.id !== id));
        },

        filter(data) {
            this.authors = data;
        }

    },

    components: { Spinner, Filter }

}
</script>