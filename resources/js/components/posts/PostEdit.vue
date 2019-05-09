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
                            <input type="text" v-validate="'required'" v-model="post.title" name="title" class="form-control">
                            <span class="text-danger" v-if="errors.has('title')">{{errors.first('title')}}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">content</label>
                            <input type="text" name="content" v-validate="'required'" v-model="post.content" class="form-control">
                            <span class="text-danger" v-if="errors.has('content')">{{errors.first('content')}}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">description</label>
                            <input type="text" name="description" v-validate="'required'" v-model="post.description" class="form-control">
                            <span class="text-danger" v-if="errors.has('descriptions')">{{errors.first('description')}}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <div class="col-md-3" v-if="post.image">
                                <img :src="image" class="img-responsive" height="70" width="90">
                            </div>
                            <input type="file" v-validate="'required|image|size:100'" v-on:change="onImageChange" class="form-control" name="image" style="height: 30px;">
                            <span class="text-danger" v-if="errors.first('image')">{{errors.first('image')}}</span>
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
    import Vue from 'vue';
    import VeeValidate from 'vee-validate';
    Vue.use(VeeValidate)
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
            onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },

            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.image = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            
            saveForm() {
                event.preventDefault();
                this.$validator.validateAll();
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
