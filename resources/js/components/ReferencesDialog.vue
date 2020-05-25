<template>
    <v-dialog v-model="dialog">
        <v-card>
            <v-card-title>References</v-card-title>
            <v-card-text>
                <div >
                    <v-text-field @input="getReferences" v-model="searchQuery" placeholder="search for references"></v-text-field>
                    <v-simple-table>
                        <template v-slot:default>
                        <thead>
                            <tr>
                                <th class="text-left black--text">Title</th>
                                <th class="text-left black--text">date</th>
                                <th class="text-left black--text">status</th>
                                <th class="text-left black--text">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="cursor-pointer" v-for="reference in references" :key="reference.id">
                                <td>{{ reference.title }}</td>
                                <td>{{ reference.created_at }}</td>
                                <td>
                                    <v-chip class="" small color="blue" text-color="white" v-if="reference.status==='validation'">Pending</v-chip>
                                    <v-chip class="" small color="green" text-color="white" v-if="reference.status==='accepted'">accepted</v-chip>
                                </td>
                                <td>
                                    <v-btn v-if="!attachedRef(reference)" small class="green" @click="attach" dark>Add to this article</v-btn>
                                    <v-btn v-else small class="red" @click="deatach" dark>Detach from this article</v-btn>
                                </td>
                            </tr>
                        </tbody>
                        </template>
                    </v-simple-table>
                    <v-pagination
                        class="mt-4"
                        @input="getReferences"
                        color="yellow darken-3"
                        v-model="page"
                        :length="lastPage"
                    />
                </div>
            </v-card-text>
            <v-card-actions>
                <v-btn dark @click="toggle" color="red" block>Close</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
const axios = require("axios");
export default {
    props:{
        attachedRefs:{type:Array,default:()=>{return[]}}
    },
    data(){
        return{
            attached:false,
            dialog:false,
            references:[],
            page:1,
            lastPage:1,
            searchQuery:"",
        }
    },methods:{
        attach(){

        },deatach(){},
        getReferences(){
            axios.get("/references"+'?page='+this.page+'&q='+this.searchQuery)
            .then((response)=>{
                this.references = response.data.data
                this.page = response.data.current_page
                this.lastPage = response.data.last_page
            }).catch(function(error){

            }).then(function(){

            });
        },
        toggle(){
            if(this.dialog && this.attached){
                this.$emit('attached');
                this.attached = false;
            }
            this.dialog = !this.dialog;
            this.dialog ? this.getReferences():null;
            this.searchQuery = "";
        },
        attachedRef(ref){
            for (let i=0;i<this.attachedRefs.length;i++){
                if(this.attachedRefs[i].id===ref.id){
                    console.log(this.attachedRefs[i].title)
                    return true;

                }
            }
            return false;
        }
    }
}
</script>

<style>

</style>