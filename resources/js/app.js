/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

import App from './components/App.vue';
import AuthorList from './components/author/List.vue';
import AuthorForm from './components/author/Form.vue';
import BookList from './components/book/List.vue';
import BookForm from './components/book/Form.vue';

const app = createApp(App);

const routes = [
    { path: '/', component: BookList },
    { path: '/book/add', component: BookForm, name: 'BookAdd' },
    { path: '/book/edit/:id', component: BookForm, name: 'BookEdit' },
    { path: '/authors', component: AuthorList, children: [] },
    { path: '/author/add', component: AuthorForm, name: 'AuthorAdd' },
    { path: '/author/edit/:id', component: AuthorForm, name: 'AuthorEdit' },
];

import { createRouter, createWebHashHistory } from 'vue-router'
const router = createRouter({
    history: createWebHashHistory(),
    routes,
});

app.use(router);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.mount('#app');
