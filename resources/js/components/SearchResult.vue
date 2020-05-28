<template>
<v-content>
    <div>
        <div class="flex md:w-1/3 ma-2">
            <input @keypress.enter="getPosts" type="text" name="q" v-model="searchQuery" placeholder="search" class="search-input  pa-2 md:w-11/12 w-10/12" id="">
            <button class="search-button pa-2 md:w-1/12  w-2/12 green"><v-icon color="white">{{searchIcon}}</v-icon></button>
        </div>
        <div class="">
            <v-card class="lg:w-1/3 ma-2" v-for="result in results" :key="result.id">
                <v-card-title>{{result.title}}</v-card-title>
                <v-card-text>
                    <div>
                        {{result.description}}
                        <a :href="'/posts/'+result.id">read more</a>
                    </div>
                    <div class="flex mt-5">
                        <div class="w-1/3">
                            <span class="text-lg aligin"><span class="mt-4">4.2</span> <v-icon class="" color="purple">{{starIcon}}</v-icon></span>
                        </div>
                        <div class="w-1/3">
                            <span class="text-lg aligin"><span class="mt-4">45</span> <v-icon class="" color="blue">{{textIcon}}</v-icon></span>
                        </div>
                    </div>
                </v-card-text>
            </v-card>
        </div>
  </div>
</v-content>
  
</template>

<script>
const axios = require('axios');
import { mdiClockTimeThree } from '@mdi/js'; 
import { mdiStar } from '@mdi/js';
import { mdiMagnify } from '@mdi/js';
import { mdiMessageText } from '@mdi/js'; 
export default {
    props:{q:''},
    data(){
        return{
            page:1,
            lastPage:1,
            searchQuery:this.q,
            timeIcon:mdiClockTimeThree,
            textIcon:mdiMessageText,
            searchIcon:mdiMagnify,
            starIcon:mdiStar,
            results:[
            ]
        }
    },methods:{
        getPosts(){
        axios.get('/api/posts?q='+this.searchQuery+'&page='+this.page).then((response)=>{
            this.results = response.data.data;
            this.page = response.data.current_page;
            this.lastPage = response.data.last_page;
        }).catch(function(error){

        }).then(function(){

        });
    }
    },mounted(){
        this.getPosts();
    }
}
</script>

<style>
.search-input{
    border: 1px grey solid;
  border-radius: 5px 0px 0px 5px;
}
.search-button{
  border-radius: 0px 5px 5px 0px;

}
</style>