<template>
  <v-dialog width="500px" v-model="dialog">
      <v-card>
          <v-card-title>Validate Article</v-card-title>
          <v-card-text>
              <v-select label="Status" v-model="status" :items="statusItems"></v-select>
              <v-textarea v-model="message" label="Message" :placeholder="status !== 'rejected' ? 'Optional':'Required'"></v-textarea>
            <div id="errors">
                <div class="text-red-500" v-for="error in errors" :key="error">
                    {{error}}
                </div>
            </div>
          </v-card-text>
          <v-card-actions>
              <v-btn text color="red" @click="toggle">Cancel</v-btn>
              <v-btn text color="green" @click="submit">Submit</v-btn>
          </v-card-actions>
      </v-card>
  </v-dialog>
</template>

<script>
const axios = require('axios');
export default {
    props:{
        post_id:{required:true}
    },
    data(){
        return{
            status:'rejected',
            statusItems:['rejected','accepted','analysis'],
            csrf:document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            dialog:false,
            errors:[],
            message:"",
        }
    },methods:{
        changeState(){
            this.accepted = !this.accepted;
        },
        toggle(){
            this.dialog = !this.dialog;
        },
        validateForm(){
            this.errors = [];
            if(this.status === 'rejected' && this.message === ""){
                this.errors.push("If the article is rejected there must be a message stating the reason");
                return false;
            }
            return true;
        },submit(){
            if(this.validateForm()){
                let params = {};
                params._token = this.csrf;
                params.message = this.message;
                params.status = this.status;
                axios.post("/posts/"+this.post_id+"/validate",params).then((response)=>{
                    if(response.data.status==='success'){
                        this.toggle();
                    }
                    this.errors = response.data.errors;
                }).catch(function(error){

                }).then(()=>{
                });
            }
        }
    }
}
</script>

<style>

</style>