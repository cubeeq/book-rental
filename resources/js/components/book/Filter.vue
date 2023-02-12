<template>
    <div class="filter">
        <div class="row mb-4">

            <div class="col-md-4">
                <select name="title" class="form-select" aria-label="Default select" @change="changeHandler()">
                    <option value="0">All books</option>
                    <option v-for="book in bookList" :key="book.id">{{ book.title }}</option>
                </select>
            </div>

            <div class="col-md-4">
                <select name="author_id" class="form-select" aria-label="Default select" @change="changeHandler()">
                    <option value="0">All authors</option>
                    <option
                        v-for="author in authors"
                        :key="author.id"
                        :value="author.id"
                    >{{ author.name + ' ' + author.surname }}</option>
                </select>
            </div>

            <div class="col-md-4">
                <select name="is_borrowed" class="form-select" aria-label="Default select" @change="changeHandler()">
                    <option value="0">All statuses</option>
                    <option value="1">Available</option>
                    <option value="2">Borrowed</option>
                </select>
            </div>

        </div>
    </div>
</template>

<script>
import { resetFilter } from '../../utils';
import { api_url as api } from '../../config';

export default {
    name: "BookFilter",

    props: ['books', 'authors'],

    data() {
        return {
            segment: '/book',
            bookList: {},
        };
    },

    mounted() {
        this.bookList = this.books;
    },

    methods: {

        changeHandler() {
            resetFilter(event.target);
            const data = {};
            data[event.target.name] = event.target.value;
            axios.post(api + this.segment, data)
                .then(response => this.$emit('setBooks', response.data));
            }
        },
        
    }
</script>

<style>

</style>