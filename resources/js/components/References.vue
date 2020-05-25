<template>
  <div>
      <reference-dialog @created="attachToArticle" ref="create_dialog"></reference-dialog>
      <references-dialog :attached-refs="articleReferences" @attached="getArticleReferences" ref="refs_dialog"></references-dialog>
      <v-card>
          <v-card-text>
              <v-btn color="green" @click="showCreateDialog" small dark>Create new reference</v-btn>
              <v-btn color="blue" small @click="showReferences" dark>Add existing reference</v-btn>
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
            articleReferences:[],
        }
    },methods:{
        showReferences(){
            this.$refs.refs_dialog.toggle();
        },
        showReference(){

        },
        attachToArticle(reference){
            axios.post("/posts/"+this.post_id+"/refrences/attach",{reference_id:reference.id})
            .then((response)=>{
                if(response.data.status==='success'){
                    this.getArticleReferences();
                }
            }).catch(function(error){

            }).then(function(){

            });
            this.getArticleReferences();
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
        showCreateDialog(){
            this.$refs.create_dialog.toggle();
        }
    },mounted(){
        this.getArticleReferences();
    }
}
</script>

<style>

</style>