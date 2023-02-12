<template>
    <div class="filter">
        <div class="row mb-4">

            <div class="col-md-6">
                <select name="author_name" class="form-select" aria-label="Default select" @change="changeHandler()">
                    <option value="0">All names</option>
                    <option
                        v-for="author in authorNames"
                        :key="author.id"
                        :value="author.name"
                    >{{ author.name }}</option>
                </select>
            </div>

            <div class="col-md-6">
                <select name="author_surname" class="form-select" aria-label="Default select" @change="changeHandler()">
                    <option value="0">All surnames</option>
                    <option
                        v-for="author in authorSurnames"
                        :key="author.id"
                        :value="author.surname"
                    >{{ author.surname }}</option>
                </select>
            </div>

        </div>
    </div>
</template>

<script>
import { api_url as api } from '../../config';
import { removeDuplicates, resetFilter } from '../../utils';

export default {
    name: "AuthorFilter",

    props: ['authors'],

    data() {
        return {
            segment: '/author',
            authorNames: {},
            authorSurnames: {},
        };
    },

    mounted() {
        this.authorNames = removeDuplicates(this.authors, 'name');
        this.authorSurnames = removeDuplicates(this.authors, 'surname');
    },

    methods: {

        changeHandler() {
            resetFilter(event.target);
            const data = {};
            data[event.target.name] = event.target.value;
            axios.post(api + this.segment, data)
                .then(response => this.$emit('setAuthors', response.data));
            }
        }
        
    }
</script>

<style>

</style>