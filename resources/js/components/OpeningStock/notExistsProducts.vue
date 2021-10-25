<template>
    <div>
        <h1>Not Exists Products Template</h1>
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