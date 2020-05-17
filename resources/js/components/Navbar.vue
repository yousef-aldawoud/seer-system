<template>
    <div>
        <v-navigation-drawer
            v-model="drawer"
            app
            dark
            >
            <v-list>

                <v-list-item :class="link.index===currentSection?'blue darken-4':''" v-for="link in links" :key="link.index" >
                    <v-list-item-title>{{link.title}}</v-list-item-title>
                </v-list-item>
                <v-divider></v-divider>
                <v-list-item >
                    <v-list-item-title>Logout</v-list-item-title>
                </v-list-item>

            </v-list>
        </v-navigation-drawer>
        <v-card
            flat
            height="100px"
            tile
        >
        <v-app-bar dark app>
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

            <v-toolbar-title>SEER System</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-text-field
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
    data(){
        return{
            drawer:true,
            currentSection:0,
            accountIcon:mdiAccount,
            links:[
                {title:"My posts",index:0,link:""},
                {title:"Profile",index:0,link:""},
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
        }
    },
    props:{
        showSearchField:{default:true},
    }
}
</script>

<style>

</style>