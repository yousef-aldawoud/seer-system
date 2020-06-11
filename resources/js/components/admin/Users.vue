<template>
    <div>
        <h1>Users</h1>
        <v-text-field @input="getUsers" v-model="searchQuery" label='Search' placeholder="User name" class=" w-full lg:w-4/12 mt-4"></v-text-field>
        <v-simple-table>
            <template v-slot:default>
            <thead>
                <tr>
                    <th class="text-left">Name</th>
                    <th class="text-left">E-mail</th>
                    <th class="text-left">active</th>
                    <th class="text-left">registeration date</th>
                    <th class="text-left">#</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in users" :key="user.id">
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.verified ? 'active':'non-active' }}</td>
                    <td>{{ user.created_at }}</td>
                    <td>
                        <v-icon v-if="!user.admin" color="red" @click="requestDeleteUser()">mdi-delete</v-icon>
                        <v-btn v-if="user.disabled" @click="enableUser(user)" small dark class="green">Enable</v-btn>
                        <v-btn v-else-if=" !user.admin" small class="red" @click="disableUser(user)" dark>Disable</v-btn>
                        <v-btn v-if="user.moderator" @click="removeModerator(user)" x-small dark>Remove moderator</v-btn>
                        <v-btn v-else @click="makeModerator(user)" x-small dark>Make moderator</v-btn>
                        <v-btn v-if="user.analyst" @click="removeAnalyst(user)" x-small dark>Remove analyst</v-btn>
                        <v-btn v-else @click="makeAnalyst(user)" x-small dark>Make analyst</v-btn>

                    </td>
                </tr>
            </tbody>
            </template>
        </v-simple-table>
        <v-pagination
            class="mt-4"
            @input="getUsers"
            color="yellow darken-3"
            v-model="page"
            :length="lastPage"
        />
    </div>
</template>
<script>
const axios = require("axios");
export default {
    mounted(){
        this.getUsers();
    },
    data(){
        return{
            page:1,
            lastPage:2,
            users:[

            ],
            searchQuery:"",
        }
    },methods:{
        requestDeleteUser(user){

        },getUsers(){
            axios.get("/users/"+'?page='+this.page+"&q="+this.searchQuery)
            .then((response)=>{
                this.users = response.data.data;
                this.lastPage = response.data.last_page;
                this.page = response.data.current_page;

            }).catch(function(error){

            }).then(function(){

            });
        },makeModerator(user){
            axios.post("/users/"+user.id+"/make-moderator")
            .then((response)=>{
                if(response.data.status==='success'){
                    this.getUsers();
                }
            }).catch(function(error){
                
            }).then(()=>{
            
            });
        },removeModerator(user){
            axios.post("/users/"+user.id+"/remove-moderator")
            .then((response)=>{
                if(response.data.status==='success'){
                    this.getUsers();
                }
            }).catch(function(error){
                
            }).then(()=>{
            
            });
        },makeAnalyst(user){
            axios.post("/users/"+user.id+"/make-analyst")
            .then((response)=>{
                if(response.data.status==='success'){
                    this.getUsers();
                }
            }).catch(function(error){
                
            }).then(()=>{
            
            });
        },removeAnalyst(user){
            axios.post("/users/"+user.id+"/remove-analyst")
            .then((response)=>{
                if(response.data.status==='success'){
                    this.getUsers();
                }
            }).catch(function(error){
                
            }).then(()=>{
            
            });
        },enableUser(user){
            axios.post("/users/"+user.id+"/enable")
            .then((response)=>{
                if(response.data.status==='success'){
                    this.getUsers();
                }
            }).catch(function(error){
                
            }).then(()=>{
            
            });
        },disableUser(user){
            axios.post("/users/"+user.id+"/disable")
            .then((response)=>{
                if(response.data.status==='success'){
                    this.getUsers();
                }
            }).catch(function(error){
                
            }).then(()=>{
            
            });
        }
    }
}
</script>