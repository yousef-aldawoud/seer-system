<template>

  <div>
        <h1>Posts</h1>
        <v-simple-table>
                <template v-slot:default>
                <thead>
                    <tr>
                        <th class="text-left black--text">Title</th>
                        <th class="text-left black--text">date</th>
                        <th class="text-left black--text">user name</th>
                        <th class="text-left black--text">status</th>
                        <th class="text-left black--text">#</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="cursor-pointer" @click="showPost" v-for="post in posts" :key="post.id">
                        <td>{{ post.title }}</td>
                        <td>{{ post.created_at }}</td>
                        <td>{{ post.username }}</td>
                        <td>
                            <v-chip class="" small color="blue" text-color="white" v-if="post.status==='validation'">Pending</v-chip>
                            <v-chip class="" small color="red" text-color="white" v-if="post.status==='rejected'">rejected</v-chip>
                            <v-chip class="" small color="green" text-color="white" v-if="post.status==='accepted'">accepted</v-chip>
                        </td>
                        <td>
                            <v-btn class="purple" dark small>Validate</v-btn>
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
            lastPage:1,
            posts:[
                {id:1,title:"Python tutorial",created_at:"2020-02-20",status:"validation",username:"User 1"},
                {id:2,title:"Java tutorial",created_at:"2020-02-20",status:"accepted",username:"John"},
                {id:3,title:"Java tutorial",created_at:"2020-02-20",status:"rejected",username:"Smith"},
            ]
        }
    },methods:{
        getUsers(){

        },
        requestDeletePost(){

        },showPost(){

        }
    }
}
</script>

<style>

</style>