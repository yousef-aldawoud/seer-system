<template>
  <div>
      <reference-dialog @created="attachToArticle" ref="create_dialog"></reference-dialog>
      <v-card>
          <v-card-text>
              <v-btn color="green" @click="showCreateDialog" small dark>Create new reference</v-btn>
              <v-btn color="blue" small @click="showReferences = ! showReferences" dark>Add existing reference</v-btn>
            <div v-if="showReferences">
                <v-text-field v-model="searchQuery" placeholder="search for references"></v-text-field>
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
                        <tr class="cursor-pointer" @click="showReference" v-for="reference in references" :key="reference.id">
                            <td>{{ reference.title }}</td>
                            <td>{{ reference.created_at }}</td>
                            <td>
                                <v-chip class="" small color="blue" text-color="white" v-if="reference.status==='validation'">Pending</v-chip>
                                <v-chip class="" small color="green" text-color="white" v-if="reference.status==='accepted'">accepted</v-chip>
                            </td>
                            <td>
                                <v-btn small class="green" dark>Add to this article</v-btn>
                            </td>
                        </tr>
                    </tbody>
                    </template>
                </v-simple-table>
            </div>
            
            <h2>Article references</h2>
            <v-simple-table class="mt-3">
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
                    <tr class="cursor-pointer" @click="showReference" v-for="reference in articleReferences" :key="reference.id+'-x'">
                        <td>{{ reference.title }}</td>
                        <td>{{ reference.created_at }}</td>
                        <td>
                            <v-chip class="" small color="blue" text-color="white" v-if="reference.status==='validation'">Pending</v-chip>
                            <v-chip class="" small color="green" text-color="white" v-if="reference.status==='accepted'">accepted</v-chip>
                        </td>
                        <td>
                            <v-icon color="red" @click="dettachFromArticle(reference)" >mdi-delete</v-icon>
                        </td>
                    </tr>
                </tbody>
                </template>
            </v-simple-table>
          </v-card-text>
      </v-card>
  </div>
</template>

<script>
const axios = require('axios');
export default {
    props:{post_id:{required:true}},
    data(){
        return{
            showReferences:false,
            articleReferences:[],
            references:[],
            page:1,
            lastPage:1,
            searchQuery:"",
        }
    },methods:{
        attachToArticle(reference){
            axios.post("/posts/"+this.post_id+"/refrences/attach",{reference_id:reference.id})
            .then((response)=>{
                if(response.data.status==='success'){
                    this.getArticleReferences();
                }
            }).catch(function(error){

            }).then(function(){

            });
        },
        dettachFromArticle(reference){
            axios.post("/posts/"+this.post_id+"/refrences/dettach",{reference_id:reference.id})
            .then((response)=>{
                if(response.data.status==='success'){
                    this.getArticleReferences();
                }
            }).catch(function(error){

            }).then(function(){

            });
        },
        getArticleReferences(){
            axios.get("/posts/"+this.post_id+"/references"+'?page='+this.page)
            .then((response)=>{
                this.articleReferences = response.data

            }).catch(function(error){

            }).then(function(){

            });
        },
        getReferences(){
            axios.get("/references"+'?page='+this.page+'&q='+this.searchQuery)
            .then((response)=>{
                this.references = response.data.data
                this.page = response.data.current_page
                this.lastPage = response.data.last_page
            }).catch(function(error){

            }).then(function(){

            });
        },showCreateDialog(){
            this.$refs.create_dialog.toggle();
        }
    },mounted(){
        this.getArticleReferences();
    }
}
</script>

<style>

</style>