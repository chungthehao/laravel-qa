<template>
    <div class="container">
        <div class="jumbotron text-center">
            <h1 class="display-4">404, Page not found.</h1>
            <p class="lead">Sorry, the page you're looking for is not found.</p>
            <hr class="my-4">
            <router-link class="btn btn-primary btn-lg" :to="{ name: 'home' }" role="button">
                Back to home page
            </router-link>
        </div>
    </div>
</template>