<template>
    <div>
        <div class="form-group">
            <router-link to= "/create" class="btn btn-success">Create new post kiểu path</router-link>
            <router-link :to="{name: 'createPost'}" class="btn btn-success">Create new Post kiểu :to {name: ''}</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Post list</div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Content</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th width="100">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="post, index in posts">
                        <td>{{ index+1 }}</td>
                        <td>{{ post.title }}</td>
                        <td>{{ post.content }}</td>
                        <td>{{ post.description }}</td>
                        <td v-if="post.image"><img v-bind:src = pathImage(post.image) class="avatar" alt="avatar"></td>
                        <td v-else="post.image">Not set</td>
                        <td>
                            <router-link :to="{name: 'editPost', params: {id: post.id}}" class="btn btn-xs btn-warning"> Edit </router-link>
                            <a href="#" class="btn btn-danger" v-on:click="deletePost(post.id, index)">Delete</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            posts: []
        }
    },
    mounted() {
        var app = this;
        // get là method ('url' xử lý)
        axios.get('http://localhost:8000/api/posts')
            .then(function (resp) {
                app.posts = resp.data;
            })
            .catch(function (resp) {
                console.log(resp);
                alert("Could not load posts");
            });
    },
    methods: {
        deletePost(id, index){
            if (confirm("Are you sure delete post?")) {
                var app = this;
                axios.delete('/api/posts/' +id)
                .then(function(resp){
                    console.log(resp);
                    app.posts.splice(index, 1);
                })
                .catch(function(error){
                    console.log(error);
                    alert('could not delete');
                })
            }
        },
        pathImage(filename) { 
            var image = new Image();
            var url_image = '/images/' + filename;
            image.src = url_image;
            return image.src;
        }
    },
}
</script>
<style>
.avatar {
    vertical-align: middle;
    width: 60px;
    height: 60px;
    border-radius: 50%;
}
table td, table th {
   text-align: center;   
}
</style>

