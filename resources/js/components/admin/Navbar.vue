<template>
    <div>
        <v-navigation-drawer
            v-model="drawer"
            app
            dark
            >
            <v-list>

                <v-list-item :href="'/admin#'+link.index"  :class="link.index===currentSection?'blue darken-4':''" v-for="link in links" :key="link.index" @click="selectLink(link.index)">
                    <v-list-item-title>{{link.title}}</v-list-item-title>
                </v-list-item>
                <v-divider></v-divider>
                <v-list-item @click="logout()">
                    <v-list-item-title>Logout</v-list-item-title>
                </v-list-item>

            </v-list>
        </v-navigation-drawer>
        <form action="/logout" method="post" ref="logout_form">
            <input type="hidden" name="_token" :value="csrf">
        </form>
        <v-app-bar
        color="deep-purple accent-4"
        dense
        dark
        app
        >
        <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

        <v-toolbar-title><a href="/admin" class="no-underline white--text" >Admin Dashboard</a></v-toolbar-title>

        <v-spacer></v-spacer>


        </v-app-bar>
    </div>
</template>
<script>

export default {
    data(){
        return{
            admin:true,
            drawer:true,
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'), 
            currentSection:0,
            drawer:true,
            links:[
                {title:"Posts",index:0},
                
            ]
        }
    },methods:{
        changeIndex(index){
            this.currentSection = Number(index)
        },
        openNavDrawer(){
            this.drawer = ! this.drawer;
        },
        selectLink(index){
            this.currentSection = index;
            this.$emit("change-page",index)
        },logout(){
            this.$refs.logout_form.submit();
        }
    },mounted(){
        if(this.admin){
            this.links.push({title:"Users",index:1});
        }
    }
}
</script>