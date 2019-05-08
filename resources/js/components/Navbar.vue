<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    
        <a class="navbar-brand" href="/">{{ application_name }}</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Dropdown
                    </a>
                    
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a v-for="(link, index) in links" :key="index" class="dropdown-item" :href="link.href">{{link.label}}</a>
                    </div>
                </li>

                <li class="nav-item" v-for="(item,index) in items" :key="index">
                    <a :href="item.href" class="nav-link">{{item.label}}</a>
                </li>
            </ul>

            <p>Welcome, <a href="#">{{this.user.first_name}}</a></p>
        </div>
    </nav>
</template>

<script>
    export default {
        name: "Navbar",

        data() {
            return {
                application_name: window.application_name,

                links: [
                    { label: "Google", href: "https://google.com" },
                    { label: "YouTube", href: "https://youtube.com" },
                ],
                items: [
                    { label: "YouTube", href: "https://youtube.com" },
                    { label: "Google", href: "https://google.com" },
                ],
            }
        },

        methods: {

        },

        props: ['user'],
    }
</script>

<style>
    .navbar {
        border-bottom: 1px solid #e8e8e8;
    }
</style>
