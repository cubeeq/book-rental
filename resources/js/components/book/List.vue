<template>

    <Spinner v-if="loading" />

    <Error v-else-if="error" :data="error" />

    <div v-else>

        <h2 class="text-center mb-4">Book list</h2>

        <Filter :books="books" :authors="authors" @set-books="filter" />

        <div v-if="books && books.length > 0">

            <ul class="list-group">
                <li v-for="book in books" :key="book.id" class="list-group-item d-flex">
                    <div>
                        <strong>{{ book.title }}</strong>
                        <small v-if="book.is_borrowed" class="text-danger ms-1">Borrowed</small>
                        <small v-else class="text-success ms-1">Available</small>
                    </div>
                    <div class="ms-auto">
                        <a href="#" class="text-decoration-none text-muted mx-1" @click.prevent="this.changeStatus(book.id)">Change status</a>
                        <span class="text-muted">&middot;</span>
                        <router-link :to="'/book/edit/' + book.id" class="text-decoration-none text-muted mx-1">Edit</router-link>
                        <span class="text-danger">&middot;</span>
                        <a href="#" class="text-decoration-none text-muted mx-1" @click.prevent="this.delete(book.id)">Delete</a>
                    </div>
                </li>
            </ul>

        </div>

        <div v-else class="text-muted text-center my-4">No items</div>

        <div class="text-center mt-3">
            <router-link to="/book/add" class="btn btn-primary">Add book</router-link>
        </div>

    </div>

</template>

<script>
import { api_url as api } from '../../config';
import Spinner from '../Spinner.vue';
import Error from '../Error.vue';
import Filter from './Filter.vue';

export default {
    name: "BookList",

    data() {
        return {
            segment: '/book',
            books: {},
            authors: {},
            loading: false,
            error: '',
        };
    },

    async mounted() {
        this.loading = true;
        await this.fetchBooks();
        await this.fetchAuthors();
        this.loading = false;
    },

    methods: {

        async fetchBooks() {
            await axios.get(api + this.segment)
                .then((response) => this.books = response.data)
                .catch(response => {
                    this.error = response.response;
                    this.loading = false;
                });
        },

        async fetchAuthors() {
            await axios.get(api + '/author')
                .then((response) => this.authors = response.data);
        },

        changeStatus(id) {
            axios.get(api + this.segment + '/status/' + id)
                .then(response => {
                    this.books.forEach(element => {
                        if (element.id === id)
                            element.is_borrowed = !element.is_borrowed;
                    });
                });
        },

        delete(id) {
            if (!confirm('really?')) return;
            axios.get(api + this.segment + '/destroy/' + id)
                .then(response => this.books = this.books.filter((el) => el.id !== id));
        },

        filter(data) {
            this.books = data;
        }

    },

    components: { Spinner, Error, Filter }

}
</script>