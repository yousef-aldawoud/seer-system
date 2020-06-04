<template>
  <v-content>
      
      <v-container>
        <div class="flex justify-center">
          <img src="/imgs/seer-logo.svg" class="md:w-1/4 w-2/3" />
        </div>
        <v-row
            align="center"
            justify="center"
        >
          
          <v-col class="md:mx-40">
            <form class="flex" method="GET" action="/search">
                <input type="text" name="q" placeholder="search" class="search-input grey lighten-2 pa-2 md:w-11/12 w-10/12" id="">
                <button type="submit" class="search-button pa-2 md:w-1/12  w-2/12 green"><v-icon color="white">{{searchIcon}}</v-icon></button>
            </form>
          </v-col>
        </v-row>
      </v-container>
  </v-content>
</template>

<script>
import { mdiMagnify } from '@mdi/js';
export default {
  data(){
    return{
      searchIcon:mdiMagnify,
      showOptions:false,
      sortBy:["time","reviews"],
      timeRange:["last day","last week","last month"],
      sortType:null,
      timeType:null,
    }
  },methods:{
    toggleOptions(){
      this.showOptions = ! this.showOptions;
      this.sortType=null;
      this.timeType=null

    },
  }
}
</script>

<style>
.search-input{
  border-radius: 5px 0px 0px 5px;
}
.search-button{
  border-radius: 0px 5px 5px 0px;

}
</style>