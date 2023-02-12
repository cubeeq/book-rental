<template>

        <header class="main-header">
            <div class="container">
                <nav class="fs-5 d-flex justify-content-center align-items-center border-bottom pt-5 pb-3 mb-5">
                    <router-link to="/">Books</router-link>
                    <router-link to="/authors">Authors</router-link>
                </nav>
            </div>
        </header>

        <main class="mx-auto">
            <div class="container">
                <router-view/>
            </div>
        </main>

</template>