<template>
    <div>
        <h1>Users</h1>
        <v-text-field label='Search' placeholder="DIO" class=" w-full lg:w-4/12 mt-4"></v-text-field>
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
                    <td>{{ user.active ? 'active':'non-active' }}</td>
                    <td>{{ user.created_at }}</td>
                    <td>
                        <v-icon v-if="!user.admin" color="red" @click="requestDeleteUser()">mdi-delete</v-icon>
                        <v-btn v-if="user.disabled || !user.admin" small class="green">Enable</v-btn>
                        <v-btn v-else-if=" !user.admin" small class="red">Disable</v-btn>
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
export default {
    data(){
        return{
            page:1,
            lastPage:2,
            users:[
                {id:1,name:"Joesph Jostar",email:"joseph@example.com",created_at:"2020/11/20",admin:false,disabled:false,},
                {id:2,name:"DIO Brando",email:"kono-dio@example.com",created_at:"2020/11/20",admin:true,disabled:false,},
            ]
        }
    },methods:{
        requestDeleteUser(user){

        },getUsers(){

        }
    }
}
</script>