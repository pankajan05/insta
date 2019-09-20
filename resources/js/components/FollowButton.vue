<template>
    <div>
        <button class="btn btn-primary ml-4" @click="followUser">Follow</button>
    </div>
</template>

<script>
    export default {
        props: ['userId'],

        mounted() {
            console.log('Component mounted.')
        },

        methods:{
            followUser(){
              axios.post('/follow/'.userId).
                  then(response =>{
                      alert(response);
              });
            }
        }
    }
</script>
