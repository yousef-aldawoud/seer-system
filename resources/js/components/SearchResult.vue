<template>
<v-content>
    <div>
        <form method="GET" class="flex md:w-1/3 ma-2">
            <input type="text" name="q" v-model="searchQuery" placeholder="search" class="search-input  pa-2 md:w-11/12 w-10/12" id="">
            <button class="search-button pa-2 md:w-1/12  w-2/12 green"><v-icon color="white">{{searchIcon}}</v-icon></button>
        </form>
        <div v-if="this.results.length > 0">
            <div class="p-4 flex flex-wrap">
                <div class="md:w-1/8 w-1/3">
                    <v-select class="m-1" @input="getPosts" v-model="sortBy" :items="columns" label="sortBy"></v-select>
                </div>
                <div class="md:w-1/8 w-1/3">
                    <v-select class="m-1" @input="getPosts" v-model="sortType" :items="sortingTypes" label="sortType"></v-select>
                </div>
                <div>
                    <v-switch label="table view" v-model="tableView"></v-switch>
                </div>
            </div>
            <div v-if="tableView">
                        <v-simple-table>
                            <template v-slot:default>
                            <thead>
                                <tr>
                                    <th class="text-left">Title</th>
                                    <th class="text-left">Description</th>
                                    <th class="text-left">Writer name</th>
                                    <th class="text-left">date</th>
                                    <th class="text-left">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="result in results" :key="result.id">
                                    <td>{{ result.title }}</td>
                                    <td>{{ result.description }}</td>
                                    <td>{{ result.username }}</td>
                                    <td>{{ result.created_at }}</td>
                                    <td>
                                        <a :href="'/posts/'+result.id">View</a>
                                    </td>
                                </tr>
                            </tbody>
                            </template>
                        </v-simple-table>
            </div>
            <div v-else>
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
        <div v-else>
            <p>No results. Try other keywords</p>
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
            tableView:true,
            sortBy:"date",
            sortType:"desc",
            sortingTypes:['desc','asc'],
            columns:['title','description','date'],
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
        axios.get('/api/posts?q='+this.searchQuery+'&page='+this.page+"&"+this.sortBy+'='+this.sortType).then((response)=>{
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