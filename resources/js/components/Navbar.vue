<template>
    <v-card
        flat
        height="100px"
        tile
    >
    <v-app-bar dark app>
        <v-app-bar-nav-icon></v-app-bar-nav-icon>

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
        <v-icon></v-icon>
        </v-app-bar>
    </v-card>
</template>

<script>
export default {
    props:{
        showSearchField:{default:true},
    }
}
</script>

<style>

</style>