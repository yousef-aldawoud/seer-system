<template>
  <v-dialog width="500px" v-model="dialog">
      <v-card>
          <v-card-title>Create a new reference</v-card-title>
        <v-card-text>
            <v-text-field label="title" v-model="reference.title"></v-text-field>
            <v-select v-model="reference.type" label="Reference type" :items="types"></v-select>
            <div v-if="reference.type === 'book'">
              <v-text-field label="Book title" v-model="reference.details.title"></v-text-field>
              <v-text-field label="Book author" v-model="reference.details.author"></v-text-field>
              <v-text-field label="Book link (optional)" v-model="reference.details.link"></v-text-field>
            </div>
            <div v-if="reference.type === 'online article'">
              <v-text-field label="Title" v-model="reference.details.title"></v-text-field>
              <v-text-field label="Author (optional)" v-model="reference.details.author"></v-text-field>
              <v-text-field label="Book link" v-model="reference.details.link"></v-text-field>
            </div>
            <div>
              <div class="text-red-500" v-for="error in errors" :key="error">{{error}}</div>
            </div>
        </v-card-text>
        <v-card-actions>
            <v-btn text @click="toggle" color="red">Cancel</v-btn>
            <v-btn text color="blue" @click="create">Create</v-btn>
        </v-card-actions>
      </v-card>
  </v-dialog>
</template>

<script>
const axios = require('axios');
export default {
  data(){
    return{
      errors:[],
      reference:{
        title:"",
        type:null,
        details:{
          title:"",author:"",link:""
        }
      },
      dialog:false,
      types:["book","online article"],
      csrf:document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    }
  },methods:{
    validate(){
      this.errors = [];
      let valid = true;
      if(this.reference.title===""){
        this.errors.push("reference title is required");
        valid = false;
      }
      if(this.reference.type===null){
        this.errors.push("Select the type first");
        valid = false;
      }
      if(this.reference.type === "book"){
        if(this.reference.details.author === ""){
          this.errors.push("Book author is required");
          valid = false;
        }
        
        if(this.reference.details.title === ""){
          this.errors.push("Book title is required");
          valid = false;
        }
      }
      if(this.reference.type === "online article"){
        if(this.reference.details.link === ""){
          this.errors.push("Article link is required");
          valid = false;
        }
        
        if(this.reference.details.title === ""){
          this.errors.push("Article title is required");
          valid = false;
        }
      }
      return valid;

      
    },
    create(){
      if(this.validate()){
        this.reference._token = this.csrf;
        axios.post("/references/",this.reference)
            .then((response)=>{
                if(response.data.status==='success'){
                  this.$emit("created",response.data.reference);
                  this.toggle();
                  return;
                }
                this.errors = response.data.errors;
        }).catch(function(error){

        }).then(()=>{
          
        });
      }
    },
    toggle(){
      this.dialog = !this.dialog;
    },
  }
}
</script>

<style>

</style>