<template>
  <div class="black--text">
    <h2>Reviews</h2>
    <div>
      <div class="flex" v-if="authenticated">
          <h4>Write a review</h4>
          <v-icon v-for="i in 5" :key="i" :color="rating >= i ? 'blue':'grey'" @click="rating = i">mdi-star</v-icon>
      </div>
      <v-btn v-else color="green" dark small href="/login">Login to write a review</v-btn>
      <v-text-field label="Review" placeholder="What do you think about the article"></v-text-field>
      <v-btn color="purple" dark>Submit review</v-btn>
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
    </div>
  </div>
</template>

<script>
export default {
  data(){
    return{
      authenticated:document.querySelector('meta[name="auth"]').getAttribute('content')==='1',
      rating:0,
      reviews:[
        {id:1,username:"John",rating:4,comment:"It was a good article"},
        {id:2,username:"Smith",rating:1,comment:"Poor writin article"},
        {id:3,username:"Smith",rating:5,comment:null},
      ]
    }
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