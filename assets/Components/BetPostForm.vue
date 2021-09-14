

<template>
<div>
    <h2>You bet!</h2>
    <div id="betpost-from-holder" ref="form"></div>
</div>
</template>

<script>
import axios from 'axios'

export default {
    name: 'PostForm',
    message: "It worked?",
    async mounted() {
        let {data} = await axios.get('/bet/new')
        console.log({data});
        this.$refs.form.innerHTML = data.form
        console.log(data.form);
    },
}
</script>

<style>

</style>