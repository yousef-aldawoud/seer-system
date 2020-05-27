<template>
    <v-container>
        <v-card >
            <v-card-title>Reset Password</v-card-title>
            <v-card-text>
                <form :action="'/password-reset/'+token" method="post">
                    <v-text-field 
                        :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                        :rules="[rules.required,rules.min]"
                        @click:append="showPassword = !showPassword"
                        :type="showPassword ? 'text' : 'password'"
                        label="password" name="password" v-model="password"></v-text-field>
                    <v-text-field
                        :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                        :rules="[rules.required,rules.confimred]"
                        @click:append="showPassword = !showPassword"
                        :type="showPassword ? 'text' : 'password'"
                        label='confirm password' name="password_confirm" v-model="confirmPassword"></v-text-field>
                    <input type="hidden" name="_token" :value="csrf">
                    <v-btn type="submit" :disabled="!validate()" color="green" class="text--white">Submit</v-btn>
                </form>
                <slot />
            </v-card-text>
        </v-card>
    </v-container>
</template>
<script>
export default {
    props:{
        token:{required:true},
    },
    data(){
        return{
            showPassword:false,
            csrf:document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            password:'',
            confirmPassword:'',
            rules: {
                required: value => !!value || 'Required.',
                min: v => v.length >= 8 || 'Min 8 characters',
                confimred:value => this.password === this.confirmPassword|| 'Passwords do not match' ,
            }
        }
    },methods:{
        validate(){
            if(!this.confirmPassword || !this.password){
                return false;
            }
            return this.confirmPassword === this.password;
        }
    }
}
</script>