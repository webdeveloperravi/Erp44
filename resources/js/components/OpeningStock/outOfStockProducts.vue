<template>
    <div>
        <h1>Out of Stock Products Template</h1>
    <div v-for="(product,index) in validProducts" :key="index">
            <h1>{{ product }}</h1>
        </div> 
    </div>
</template>
<script>
export default {
    props:['validProducts'],

}
</script>    