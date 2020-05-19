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
                <v-list-item @click="logout" >
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
                append-icon="mdi-magnify"
                dense 
                single-line
                outlined
                placeholder="Placeholder"
            ></v-text-field>
            <v-spacer></v-spacer>
            </v-app-bar>
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
            loc:window.location.pathname,
            drawer:true,
            currentSection:this.passedCurrentSection,
            accountIcon:mdiAccount,
            links:[
                {title:"My posts",index:0,link:"/posts"},
                {title:"Profile",index:1,link:"/profile"},
            ]
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
        },search(){
            window.location.href = "/search"
        }
    },
    props:{
        showSearchField:{default:true},
    }
}
</script>

<style>

</style>