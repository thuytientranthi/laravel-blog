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
                        <!-- <ImageUpload></ImageUpload> -->
                        <div class="col-md-3" v-if="post.image">
                            <img :src="image" class="img-responsive" height="70" width="90">
                        </div>
                        <div class="col-md-12">
                            <input type="file" v-on:change="onImageChange" class="form-control">
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
    import ImageUpload from '../files/Imageupload.vue'
    export default {
        // components :{ImageUpload :ImageUpload},
         data() {
            return {
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
            // uploadImage(){
            //     axios.post('/image/store',{image: this.image}).then(response => {
            //        console.log(response);
            //     });
            // }
            saveForm() {
                event.preventDefault();
                var app = this;
                var newPost = app.post;
                newPost.image = this.image;

                axios.post('/api/posts/', newPost, {image: this.image},
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(function (resp) {
                    app.$router.push({path: '/'});   
                })
                .catch(function (error) {
                    if (error.response.status == 400){
                        this.validationErrors = error.response.data.errors;
                    }
                    console.log(error);
                    alert("Could not create your post");
                });
            },
        }
    }
</script>