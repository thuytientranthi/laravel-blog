<template>
    <div>
        <div class="form-group">
            <router-link to="/" class="btn btn-default">Back</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Create new post</div>
            <div class="panel-body">
                <!-- <form v-on:submit="saveForm()"> -->
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
                <!-- </form> -->
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                post: {
                    title: '',
                    content: '',
                    description: '',
                }
            }
        },
        methods: {
            previewFiles(event) {
                console.log(event.target.files);
            }
        }
        // methods: {
        //     saveForm() {
        //         event.preventDefault();
        //         var app = this;
        //         var newPost = app.post;
        //         axios.post('/api/v1/companies', newPost)
        //             .then(function (resp) {
        //                 app.$router.push({path: '/'});
        //             })
        //             .catch(function (resp) {
        //                 console.log(resp);
        //                 alert("Could not create your post");
        //             });
        //     }
        // }
    }
</script>