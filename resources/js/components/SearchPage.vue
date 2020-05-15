<template>
  <div>
      
      <v-container>
        <v-row
            align="center"
            justify="center"
        >
          <v-col class="md:mx-40">
            <div class="flex">
                <input type="text" name="q" placeholder="search" class="search-input grey lighten-2 pa-2 md:w-11/12 w-10/12" id="">
                <button class="search-button pa-2 md:w-1/12  w-2/12 green"><v-icon color="white">{{searchIcon}}</v-icon></button>
            </div>
                <v-btn  color="blue darken-4 m-0" small dark @click="toggleOptions">{{showOptions ? "Less options":"More options"}}</v-btn>
                <div v-if="showOptions" class="flex">
                  <div  class="md:w-1/4 pa-1">
                    <v-select dense v-model="sortType" placeholder="Sort by" title="Sort by" :items="sortBy"></v-select>
                  </div>
                  <div  class="md:w-1/4 pa-1">
                    <v-select dense v-model="timeType" placeholder="Time" :items="timeRange"></v-select>
                  </div>
                </div>
          </v-col>
        </v-row>
      </v-container>
  </div>
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

    }
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