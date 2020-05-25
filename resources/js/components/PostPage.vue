<template>
<v-container>
  <v-card>
      <v-card-text>
          <h1 class="black--text">{{post.title}}</h1>
          <h4>By {{authorName}}</h4>
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
      </v-card-text>
  </v-card>
</v-container>
</template>

<script>
export default {
    props:{
        post:{required:true,type:Object},
        authorName:{required:true,type:String},
    },
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