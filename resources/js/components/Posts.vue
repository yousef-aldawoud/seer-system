<template>

  <v-content>
      <v-container>
        <h1>Posts</h1>
        <form action="/posts/create" method="post">
        <input type="hidden" name="_token" :value="csrf">
            <v-btn type="submit" color="green" dark>Create new article</v-btn>
        </form>
        <confirm @confirmed="deletePost" ref="confirm_delete">
                <div class="text-white">
                    Are you sure you want to delete this article "<strong>{{selectedPost.title}}</strong>" ?
                </div>
        </confirm>
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
        <v-simple-table>
                <template v-slot:default>
                <thead>
                    <tr>
                        <th class="text-left black--text">Title</th>
                        <th class="text-left black--text">date</th>
                        <th class="text-left black--text">status</th>
                        <th class="text-left black--text">#</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="cursor-pointer" @click="showPost" v-for="post in posts" :key="post.id">
                        <td>{{ post.title }}</td>
                        <td>{{ post.created_at }}</td>
                        <td>
                            <v-chip class="" small color="yellow darken-2" text-color="white" v-if="post.status==='draft'">draft</v-chip>
                            <v-chip class="" small color="blue" text-color="white" v-if="post.status==='validation'">Pending</v-chip>
                            <v-chip class="" small color="red" text-color="white" v-if="post.status==='rejected'">rejected</v-chip>
                            <v-chip class="" small color="green" text-color="white" v-if="post.status==='accepted'">accepted</v-chip>
                        </td>
                        <td>
                            <v-icon color="red" @click="requestDeletePost(post)">mdi-delete</v-icon>
                        </td>
                    </tr>
                </tbody>
                </template>
            </v-simple-table>
            <v-pagination
                class="mt-4"
                @input="getPosts"
                color="yellow darken-3"
                v-model="page"
                :length="lastPage"
            />
        </v-container>
      </v-content>
</template>

<script>
const axios = require("axios");
export default {
    data(){
        return{
            snackbarText:"",
            snackbar:false,
            selectedPost:0,
            searchQuery:"",
            csrf:document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            page:1,
            lastPage:1,
            posts:[
            ]
        }
    },methods:{
        getPosts(){
            axios.get("/api/user/posts"+'?page='+this.page+'&q='+this.searchQuery)
            .then((response)=>{
                this.posts = response.data.data
                this.page = response.data.current_page
                this.lastPage = response.data.last_page
            }).catch(function(error){

            }).then(function(){

            });
        },deletePost(){
            axios.delete("/posts/"+this.selectedPost.id)
            .then((response)=>{
                if(response.data.status==='success'){
                    this.$emit('post-deleted');
                    this.snackbarText = "Snackbar deleted successfully"
                    this.snackbar = true;
                    this.getPosts();
                }
            }).catch(function(error){

            }).then(function(){

            });
        },
        requestDeletePost(post){
            this.selectedPost = post; 
            this.$refs.confirm_delete.toggle();
        },showPost(){

        }
    },mounted(){
        this.getPosts();
    }
}
</script>

<style>

</style>