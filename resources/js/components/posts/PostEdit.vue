<template>
    <div>
        <div class="form-group">
            <router-link to="/" class="btn btn-secondary">Back</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading" style="font-size : 30px; text-align : center">Edit post</div>
            <div class="panel-body">
                <form v-on:submit="saveForm()">
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Title</label>
                            <input type="text" v-model="post.title" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">content</label>
                            <input type="text" v-model="post.content" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">description</label>
                            <input type="text" v-model="post.description" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Image</label>
                            <input type="file" id="file" ref="post.image" v-on:change="handleFileUpload()" class="form-control-file"/>
                                <!-- <button v-on:click="submitFile()">Submit</button> -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <button class="btn btn-success">Create</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            let app = this;
            let id = app.$route.params.id;
            app.postId = id;
            axios.get('/api/posts/' + id)
            .then(function (resp) {
                console.log(resp);
                app.post = resp.data;
            })
            .catch(function (error) {
                console.log(error);
                alert("Could not load your post")
            });
        },
        data : function() {
            return {
                postId: null,
                post: {
                    title: '',
                    content: '',
                    description: '',
                    image: '',
                }
            }
        },
        methods: {
            saveForm() {
                event.preventDefault();
                var app = this;
                var newPost = app.post;
                axios.patch('/api/posts/' + app.postId, newPost)
                .then(function(resp){
                    console.log(resp);
                    app.$router.replace('/');
                })
                .catch(function(error){
                    console.log(error);
                    alert("could not save post");
                })
            }
        }
    }
</script>
