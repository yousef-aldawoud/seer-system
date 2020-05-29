<template>
    <div>
        <v-navigation-drawer
            v-model="drawer"
            color="blue darken-3"
            app
            dark
            >
            <v-list>

                <v-list-item @click="selectLink(link)" :class="link.link===loc  ?'blue darken-4':''" v-for="link in links" :key="link.index" >
                    <v-list-item-title>{{link.title}}</v-list-item-title>
                </v-list-item>
                <v-divider></v-divider>
                <v-list-item @click="logout" v-if="authenticated" >
                    <v-list-item-title>Logout</v-list-item-title>
                </v-list-item>

            </v-list>
        </v-navigation-drawer>
        <v-card
            flat
            height="100px"
            tile
        >
        <v-app-bar dark color="blue" app>
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

            <v-toolbar-title>SEER System</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-text-field
                @click:append="search"
                v-on:keyup.enter="search"
                v-if="showSearchField"
                v-model="searchQuery"
                append-icon="mdi-magnify"
                dense 
                single-line
                outlined
                placeholder="Placeholder"
            ></v-text-field>
            <v-spacer></v-spacer>
            </v-app-bar>
            <form action="/logout" method="post" ref="logout_form">
                <input type="hidden" name="_token" :value="csrf">
            </form>
        </v-card>
    </div>
</template>

<script>
import { mdiAccount } from '@mdi/js';
export default {
    props:{
        passedCurrentSection:{default:1000}
    },
    data(){
        return{
            searchQuery:"",
            csrf:document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            authenticated:document.querySelector('meta[name="auth"]').getAttribute('content')==='1',
            loc:window.location.pathname,
            drawer:true,
            currentSection:this.passedCurrentSection,
            accountIcon:mdiAccount,
            links:[{title:"Login",index:0,link:"/login"},],
        }
    },methods:{
        changeIndex(index){
            this.currentSection = Number(index)
        },
        openNavDrawer(){
            this.drawer = ! this.drawer;
        },
        selectLink(link){
            window.location.href = link.link
        },logout(){
            this.$refs.logout_form.submit();
        },search(){
            window.location.href = "/search?q="+this.searchQuery
        }
    },
    props:{
        showSearchField:{default:true},
    },mounted(){
        if(this.authenticated){
            this.links = [
                {title:"My posts",index:0,link:"/posts"},
            ]
        }
    }
}
</script>

<style>

</style>