<template>
  <div class="black--text">
    <h2>Reviews</h2>
    <div>
      <div v-if="userReview && ! showEditReview" class="border-solid p-3">
        <h2>Your review</h2>
        <p>{{userReview.comment === null ? '':userReview.comment}}</p>
        <v-icon v-for="i in 5" :key="i" :color="userReview.rating >= i ? 'blue':'grey'" >mdi-star</v-icon>
        <v-btn dark color="purple" @click="showEditReview = true">edit review</v-btn>
      </div>
      <div v-else>
        <div class="flex" v-if="authenticated">
            <h4>Write a review</h4>
            <v-icon v-for="i in 5" :key="i" :color="rating >= i ? 'blue':'grey'" @click="rating = i">mdi-star</v-icon>
        </div>
        <v-btn v-else color="green" dark small href="/login">Login to write a review</v-btn>
        <v-text-field v-model="comment" label="Review" placeholder="What do you think about the article"></v-text-field>
        <v-btn color="purple" @click="submitReview" dark>Submit review</v-btn>
      </div>
      <div v-if="authenticated && !userReview">
      </div>
      <v-card v-for="review in reviews " :key="review.id" class="m-2">
        <v-card-text>

          <h3>{{review.username}}</h3>
          <div class="flex">
            <v-icon v-for="i in 5" :key="i+'-'+review.id" :color="review.rating >= i ? 'blue':'grey'">mdi-star</v-icon>
          </div>
          <p v-if="review.comment!==null">
            {{review.comment}}
          </p>
        </v-card-text>
      </v-card>
          <v-pagination
            class="mt-4"
            @input="getReviews"
            color="yellow darken-3"
            v-model="page"
            :length="lastPage"
        />
    </div>
  </div>
</template>

<script>
const axios = require('axios');
export default {
  props:{post_id:{required:true}},
  data(){
    return{

      showEditReview:false,
      userReview:null,
      comment:'',
      authenticated:document.querySelector('meta[name="auth"]').getAttribute('content')==='1',
      csrf:document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      rating:0,
      page:1,
      lastPage:0,
      reviews:[
      ]
    }
  },methods:{
    showUpdateReview(){

    },
    submitReview(){
      let params = {};
      params._token = this.csrf;
      params.rating = this.rating;
      params.comment = this.comment;
      let route = this.showEditReview ? "/post-reviews/"+this.userReview.id+'/update':"/posts/"+this.post_id+'/review';
      axios.post(route,params)
            .then((response)=>{
                if(response.data.status==='success'){
                  this.getUserReview();
                  this.getReviews();
                  return;
                }
                this.errors = response.data.errors;
        }).catch(function(error){

        }).then(()=>{
          
        });
    },getReviews(){
        axios.get("/posts/"+this.post_id+"/reviews"+'?page='+this.page)
        .then((response)=>{
            this.reviews = response.data.data;
            this.page = response.data.current_page;
            this.lastPage = response.data.last_page;
            
        }).catch(function(error){

        }).then(function(){

        });
    },getUserReview(){
      axios.get("/posts/"+this.post_id+"/user-review")
        .then((response)=>{
            this.userReview = response.data;
            this.showEditReview = false;
        }).catch(function(error){

        }).then(function(){

        });
    }
  },
  mounted(){
    this.getReviews();
    this.getUserReview();
  }
}
</script>

<style>
.start-icon{
    background: grey;
}
.start-icon:hover{
  background: darkgray;
}

.start-icon .active{
  color: purple;
}
</style>