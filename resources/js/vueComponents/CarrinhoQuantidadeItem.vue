<script>
export default {
    props: ['value', 'name'],
    data(){
        return {
            quantidade: this.value
        }
    },
    methods: {
        minus(){
            if(this.quantidade > 1){
                this.quantidade--
            }
        }
    },
    watch: {
        quantidade(newValue, oldValue){
            this.$emit('changeQuantidade', newValue);
        }
    }
};
</script>

<template>
    <div>
        <button class="minus" @click.prevent="minus()"><i class="fa fa-minus"></i></button>
        <input type="text" class="quantidade" :name="name" :value="quantidade"/>
        <button class="plus" @click.prevent="quantidade++"><i class="fa fa-plus"></i></button>
    </div>
</template>
