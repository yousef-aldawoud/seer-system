<template>
<v-container>
  <v-card>
      <v-card-text>
          <h1 class="black--text">{{post.title}}</h1>
          <h4>By {{authorName}}</h4>
            <div v-if="userIsAdmin || userIsModerator || userIsAnalyst">
              <v-btn small dark color="purple" @click="validatePost">Validate</v-btn>
              <post-validation-dialog :post_id="post.id" ref="validation_dialog"></post-validation-dialog>
            </div>
            <div class="p-2 text-white bg-red-400 rounded" v-if="post.status === 'draft'">
                This article is a draft. It is not visible to anyone other than you.
            </div>
            <div class="p-2 text-white bg-red-400 rounded" v-if="post.status === 'validation' || post.status === 'analysis'">
                This article is still in validation. It is not visisble to the public.
            </div>
            <div class="p-2 text-white bg-red-400 rounded" v-if="post.status === 'rejected'">
                This article has been rejected. It is not visisble to the public.
            </div>
            <div></div>
          <div class="divider"></div>
            <div class="black--text content">
                <div v-html="post.content"></div>
            </div>
            <references :edit='post.status === "draft" || post.status === "rejected" || userIsAdmin || userIsModerator || userIsAnalyst' :table-view="false" :post_id='post.id'/>
            <post-reviews :user-review='postReview' :post_id='post.id' class="mt-4" v-if="post.status==='accepted'">

            </post-reviews>
      </v-card-text>
  </v-card>
</v-container>
</template>

<script>
const axios = require('axios');
export default {
    mounted(){
        this.getReferences();
    },
    props:{
        post:{required:true,type:Object},
        authorName:{required:true,type:String},
        postReview:{required:false,type:Object},
    },
    data(){
        return{
            references:[],
            userIsAnalyst:document.querySelector('meta[name="analyst"]').getAttribute('content')==='1',
            userIsAdmin:document.querySelector('meta[name="admin"]').getAttribute('content')==='1',
            userIsModerator:document.querySelector('meta[name="moderator"]').getAttribute('content')==='1',
        }
    },methods:{
        validatePost(){
            this.$refs.validation_dialog.toggle();
        },getReferences(){
            axios.get("/posts/"+this.post.id+"/references"+'?page='+this.page)
            .then((response)=>{
                this.references = response.data

            }).catch(function(error){

            }).then(function(){

            });
        }
    }
}
</script>

<style>
.divider{
    margin: 10px;
    margin-left: 0px;
    min-width: 300px;
    min-height: 2px;
    height: 2px;
    background: rgb(36, 55, 161);
    width: 300px;
}
.content table{
    width:100%;

    border: 1px solid #ddd;

}
.content th, td {
    text-align: left;
    padding: 8px;
    border: 1px solid #ddd;
}
</style>