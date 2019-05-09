<template>
    <div>
        <div class="form-group">
            <router-link to="/" class="btn btn-secondary">Back</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading" style="font-size : 30px; text-align : center">Create new post</div>
            <div class="panel-body">
                <form enctype="multipart/form-data" v-on:submit="saveForm()">
                    <div class="row">
                        <p v-if="errorsValidate.length" class="text-danger">
                            <b>Please correct the following error(s):</b>
                            <ul>
                                <li v-for="(error, index) in errorsValidate" :key="index">{{ error }}</li>
                            </ul>
                        </p>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Title</label>
                            <input type="text" v-model="post.title" v-validate="'required'" name="title" class="form-control">
                            <span class="text-danger" v-if="errors.has('title')" >{{errors.first('title')}}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">content</label>
                            <input type="text" v-model="post.content" v-validate="'required'" name="content" class="form-control">
                            <span class="text-danger" v-if="errors.has('content')">{{ errors.first('content')}}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">description</label>
                            <input type="text" v-model="post.description" v-validate="'required'" name="description" class="form-control">
                            <span class="text-danger" v-if="errors.first('description')">{{errors.first('description')}}</span>
                        </div>
                    </div>
                    <div class="row">
                        <!-- <ImageUpload></ImageUpload> -->
                        <div class="col-xs-12 form-group">
                            <div class="col-md-3" v-if="post.image">
                                <img :src="image" class="img-responsive" height="70" width="90">
                            </div>
                            <input type="file" v-validate="'required|image|size:100'" v-on:change="onImageChange" class="form-control" name="image" style="height: 30px;">
                            <span class="text-danger" v-if="errors.first('image')">{{errors.first('image')}}</span>
                        </div>
                    </div><br>
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
    // import ImageUpload from '../files/Imageupload.vue';
    import Vue from 'vue';
    import VeeValidate from 'vee-validate';
    Vue.use(VeeValidate);
    export default {
        // components :{ImageUpload :ImageUpload},
         data() {
            return {
                errorsValidate: [],
                post: {
                    title: '',
                    content: '',
                    description: '',
                    image: ''
                }
            };
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
                // check validate
                // if (this.title && this.content && this.description && this.image) {
                //     return true;
                // }
                // this.errors = [];
                // if (!this.title) {
                //     this.errors.push('Title required.');
                // }
                // if (!this.content) {
                //     this.errors.push('Content required.');
                // }
                // if (!this.description) {
                //     this.errors.push('Decription required.');
                // }
                // if (!this.image) {
                //     this.errors.push('Image required.');
                // }

                event.preventDefault();
                this.$validator.validateAll();
                var app = this;
                var newPost = app.post;
                newPost.image = this.image;

                axios.post('/api/posts/', newPost, {image: this.image},
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then( (resp) => {
                    // console.log(this.errorsValidate); 
                    this.errorsValidate =[];
                    if (resp.data.status === 400){
                        console.log(app.errorsValidate);
                        resp.data.message.forEach(element => {
                            app.errorsValidate.push(element);
                        });
                    }
                    if (resp.data.status === 401){
                        app.errorsValidate.push(resp.data.message);
                    }
                    if (resp.data.status === 500){
                        var message = 'cannot create';
                        app.errorsValidate.push(message);
                    }
                    if (resp.data.status === 200){
                        console.log(newPost);
                        app.$router.push({path: '/'});
                    }
                })
                .catch((error) => {
                    console.log(error);
                    alert("Could not create your post");
                });
            },
        }
    }
</script>