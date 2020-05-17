<template>
  <div>
        <div class="flex md:w-1/3 ma-2">
            <input type="text" name="q" placeholder="search" class="search-input  pa-2 md:w-11/12 w-10/12" id="">
            <button class="search-button pa-2 md:w-1/12  w-2/12 green"><v-icon color="white">{{searchIcon}}</v-icon></button>
        </div>
        <div class="">
            <v-card class="lg:w-1/3 ma-2" v-for="result in results" :key="result.id">
                <v-card-title>{{result.title}}</v-card-title>
                <v-card-text>
                    <div>
                        {{result.description}}
                    </div>
                    <div class="flex mt-5">
                        <div class="w-1/3">
                            <span class="text-lg aligin"><span class="mt-4">4.2</span> <v-icon class="" color="purple">{{starIcon}}</v-icon></span>
                        </div>
                        <div class="w-1/3">
                            <span class="text-lg aligin"><span class="mt-4">45</span> <v-icon class="" color="blue">{{textIcon}}</v-icon></span>
                        </div>
                        <div class="w-1/3">
                            <span class="text-lg aligin">
                                <v-icon class="" color="red">{{timeIcon}}</v-icon>
                                <span class="mt-4">45 minute</span> 
                            </span>
                        </div>
                    </div>
                </v-card-text>
            </v-card>
        </div>
  </div>
</template>

<script>
import { mdiClockTimeThree } from '@mdi/js'; 
import { mdiStar } from '@mdi/js';
import { mdiMagnify } from '@mdi/js';
import { mdiMessageText } from '@mdi/js'; 
export default {
    data(){
        return{
            timeIcon:mdiClockTimeThree,
            textIcon:mdiMessageText,
            searchIcon:mdiMagnify,
            starIcon:mdiStar,
            results:[
                {id:1,title:"Java tutorial",description:"Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptate esse dicta molestias culpa laborum nulla quis hic porro perspiciatis recusandae, sapiente neque doloribus blanditiis nisi ut accusamus iure necessitatibus vero."},
                {id:2,title:"Python3 tutorial",description:"Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptate esse dicta molestias culpa laborum nulla quis hic porro perspiciatis recusandae, sapiente neque doloribus blanditiis nisi ut accusamus iure necessitatibus vero."},
            ]
        }
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