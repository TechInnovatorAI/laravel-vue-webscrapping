<template lang="">
    <small class="text-danger">{{ message ? message[0] : '' }}</small>
</template>
<script>
export default {
    props:{
        message: String
    }
}
</script>
<style lang="">
    
</style>