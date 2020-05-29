<template>

  <div>
        <h1>Posts</h1>
        <v-text-field @input="getPosts" v-model="searchQuery" label='Search' placeholder="EX how to become a software engineer in 1 day" class=" w-full lg:w-4/12 mt-4"></v-text-field>
        <v-simple-table>
                <template v-slot:default>
                <thead>
                    <tr>
                        <th class="text-left black--text">Title</th>
                        <th class="text-left black--text">date</th>
                        <th class="text-left black--text">user name</th>
                        <th class="text-left black--text">status</th>
                        <th class="text-left black--text">#</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="cursor-pointer" v-for="post in posts" :key="post.id">
                        <td>{{ post.title }}</td>
                        <td>{{ post.created_at }}</td>
                        <td>{{ post.username }}</td>
                        <td>
                            <v-chip class="" small color="blue" text-color="white" v-if="post.status==='validation'">Pending</v-chip>
                            <v-chip class="" small color="red" text-color="white" v-if="post.status==='rejected'">rejected</v-chip>
                            <v-chip class="" small color="green" text-color="white" v-if="post.status==='accepted'">accepted</v-chip>
                        </td>
                        <td>
                            <v-btn class="purple" v-if="post.status !== 'rejected' " :href="'/posts/'+post.id" dark small>Validate</v-btn>
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
      </div>
</template>

<script>
const axios = require('axios');
export default {
    mounted(){
        this.getPosts();
    },
    data(){
        return{
            searchQuery:'',
            page:1,
            lastPage:1,
            posts:[]
        }
    },methods:{
        requestDeletePost(){

        },
        getPosts(){
            axios.get('/api/posts?q='+this.searchQuery+'&page='+this.page).then((response)=>{
                this.posts = response.data.data;
                this.page = response.data.current_page;
                this.lastPage = response.data.last_page;
            }).catch(function(error){

            }).then(function(){

            });
        }
    }
}
</script>

<style>

</style>