<script>
import debounce from "lodash.debounce";
import { computed } from '@vue/runtime-core';
export default {
    props: ['value', 'name'],
    data(){
        return {
            quantidade: this.value,
            debouncedQuantidade: (() => {
                 return debounce(() =>{
                     this.$emit('alterarquantidade', this.quantidade)
                }, 1000)
            })()
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
            this.quantidade = newValue;
            this.debouncedQuantidade();
        },
        value(newValue, oldValue){
            this.quantidade = newValue;
        }
    }
};
</script>

<template>
    <div>
        <button class="minus diminuir" @click.prevent="minus()"><i class="fa fa-minus"></i></button>
        <input type="text" class="quantidade" :name="name" :value="quantidade"/>
        <button class="plus aumentar" @click.prevent="quantidade++"><i class="fa fa-plus"></i></button>
    </div>
</template>

<style scoped>
.quantidade {
    width: 80px;
    text-align: center;
    border: 1px solid var(--cinza-claro);
    border-left: unset;
    border-right: unset;
    color: var(--verde-claro);
    font-weight: bold;
    font-size: 20px;
}

.quantidade:focus-visible {
    outline: unset;
}

button {
    background-color: var(--branco);
    color: var(--cinza-claro);
    border: 1px solid var(--cinza-claro);
    height: auto;
    width: 56px;
    border-radius: 12px;
}

.aumentar {
    border-left: unset;
    border-top-left-radius: unset;
    border-bottom-left-radius: unset;
}

.diminuir {
    border-right: unset;
    border-top-right-radius: unset;
    border-bottom-right-radius: unset;
}
</style>
