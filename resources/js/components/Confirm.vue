<template>
    <v-dialog :width="width" v-model="dialog">
        <v-card dark>
            <v-card-title>Confirm</v-card-title>
            <v-card-text>
                <slot />
            </v-card-text>
            <v-card-actions>
                <v-btn text @click="toggle" color="red">Cancel</v-btn>
                <v-btn text color="blue" @click="confirm">Confirm</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script>
export default {
    props:{
        width:{default:700}
    },
    data(){
        return{
            dialog:false
        }
    },methods:{
        toggle(){
            this.dialog = !this.dialog;
        },
        confirm(){
            this.$emit("confirmed");
            this.toggle();
        }
    }
}
</script>