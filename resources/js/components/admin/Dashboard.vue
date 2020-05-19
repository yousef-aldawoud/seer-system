<template>
<v-app>
    <admin-navbar v-on:change-page="changePage" ref="navbar"></admin-navbar>
    <v-content class="">
        <v-container>
            <v-card>
                <v-card-text>
                    <slot />
                    <div v-if="!templateLayout">
                        <admin-posts v-if="index==0"></admin-posts>
                        <admin-users v-if="index==1&&admin"></admin-users>
                    </div>
                </v-card-text>
            </v-card>
        </v-container>
    </v-content>
</v-app>
</template>
<script>
export default {
    props:{
        templateLayout:{default:false},
    },
    mounted(){
        if(this.templateLayout){
            this.index = 5;
            this.$refs.navbar.changeIndex(this.index);
            return;
        }
        if(window.location.hash && Number(window.location.hash.substring(1))<4){
            let passedIndex = window.location.hash.substring(1);
            this.index=passedIndex;
            this.$refs.navbar.changeIndex(passedIndex);
        }
    },
    data(){
        return {
            admin:true,
            index:0,
        }
    },methods:{
        changePage(index){
            this.index = index
        }
    }
}
</script>