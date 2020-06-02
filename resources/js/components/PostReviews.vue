<template>
  <div class="black--text">
    <h2>Reviews</h2>
    <div>
      <div class="flex" v-if="authenticated">
          <h4>Write a review</h4>
          <v-icon v-for="i in 5" :key="i" :color="rating >= i ? 'blue':'grey'" @click="rating = i">mdi-star</v-icon>
      </div>
      <v-btn v-else color="green" dark small href="/login">Login to write a review</v-btn>
      <v-text-field v-model="comment" label="Review" placeholder="What do you think about the article"></v-text-field>
      <v-btn color="purple" @click="submitReview" dark>Submit review</v-btn>
      <v-card v-for="review in reviews " :key="review.id" class="m-2">
        <v-card-text>

          <h3>{{review.username}}</h3>
          <div class="flex">
            <v-icon v-for="i in 5" :key="i+'-'+review.id" :color="review.rating >= i ? 'blue':'grey'" @click="rating = i">mdi-star</v-icon>
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
    submitReview(){
      let params = {};
      params._token = this.csrf;
      params.rating = this.rating;
      params.comment = this.comment;
      axios.post("/posts/"+this.post_id+'/review',params)
            .then((response)=>{
                if(response.data.status==='success'){
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
    }
  },
  mounted(){
    this.getReviews();
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