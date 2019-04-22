
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';

window.Vue.use(VueRouter);

import Vue from 'vue';

import PostIndex from './components/posts/PostIndex.vue';
import PostCreate from './components/posts/PostCreate.vue';
import PostEdit from './components/posts/PostEdit.vue';

const routes =  [
    {
        path : '/',
        name : 'post.index',
        components: {
            postIndex : PostIndex,
        }
    },
    {
        path : '/create',
        name : 'createPost',
        component : PostCreate
        
    },
    {
        path : '/edit',
        name : 'editPost',
        component: PostEdit,
    }
]

const router = new VueRouter({ routes })
const app = new Vue({ router }).$mount('#app')
