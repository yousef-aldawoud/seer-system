<template>
    <v-container>
        <h1>{{ postInfo.title === "" ? "Edit post" : postInfo.title }}</h1>
        <div>
            <v-btn @click="savePost" small color="green" :loading="saveLoading" dark>save</v-btn>
            <v-btn @click="submitForValidation" small color="purple" dark>Submit for evaluation</v-btn>
        </div>
        <div id="errors">
            <div class="text-red-500" v-for="error in errors" :key="error">
                {{error}}
            </div>
        </div>
        <v-text-field label="Title" class="w-1/2" v-model="postInfo.title" placeholder="my awsome article" ></v-text-field>
        <v-textarea
            class="mt-2 md:w-1/2"
            name="input-7-4"
            label="Description"
            v-model="postInfo.description"
        ></v-textarea>
        <ckeditor :editor="editor" v-model="postInfo.content"></ckeditor>
        <div>
            <v-btn @click="savePost" small color="green" :loading="saveLoading" dark>save</v-btn>
            <v-btn @click="submitForValidation" small color="purple" dark>Submit for evaluation</v-btn>
        </div>
        <references :post_id="post.id" />
        <v-snackbar
            v-model="snackbar"
            >
            {{ snackbarText }}
            <v-btn
                color="yellow"
                text
                @click="snackbar = false"
            >
                Close
            </v-btn>
        </v-snackbar>
    </v-container>
</template>

<script>
import axios from 'axios'
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
export default {
    props:{
        post:{
            type:Object,
            default:()=>{
                return{
                    id:0,
                    title:'',
                    description:'',
                    content:'',
                }
            }
        }
    },
    data(){
        return{
            csrf:document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            snackbar:false,
            errors:[],
            saveLoading:false,
            editor:ClassicEditor,
            postInfo:this.post,
            snackbarText:"",
        }
    },methods:{

        submitForValidation(){
            this.savePost();
            axios.post("/posts/"+this.postInfo.id+"/validation",{_token:this.csrf})
            .then((response)=>{
                if(response.data.status==='success'){
                    this.snackbarText = "article submited for validation";
                    this.snackbar = true;
                    window.location.href = '/posts';
                }
                this.errors = response.data.errors;
            }).catch(function(error){

            }).then(()=>{
            });
        },

        savePost(){
            this.postInfo.csrf = this.csrf;
            this.saveLoading = true;
            axios.post("/posts/"+this.postInfo.id+"/update",this.postInfo)
            .then((response)=>{
                if(response.data.status==='success'){
                    this.snackbarText = "article saved";
                    this.snackbar = true;
                }
                this.errors = response.data.errors;
            }).catch(function(error){

            }).then(()=>{
                this.saveLoading = false;
            });
        }
    }
}
</script>

<style>
.ck-content {
    color: black !important;
    padding: .15em;
    min-height: 300px;
    border-radius: 2px;
}
</style>