<script>
import Datepicker from './Datepicker.vue'
import axios from "axios"

export default {
    inject: ['adicionarErro'],
    components: {
        Datepicker
    },
    data(){
        return{
            checkout: window.checkoutDados
        }
    },
    methods: {
        selecionarEndereco(endereco){
            let _this = this;

            axios.post(endereco.selecionar).then(function (response){

                if(response.data.checkout){
                    _this.checkout = response.data.checkout
                }

            }).catch(function(error){
                _this.adicionarErro("ocorreu um erro ao selecionar o endereço, tente novamente mais tarde");
                setTimeout(() => {
                    window.location.reload();
                }, 5000);
            })
        },
        excluirEndereco(endereco){
            let _this = this;

            axios.post(endereco.excluir).then(function (response){

                if(response.data.checkout){
                    _this.checkout = response.data.checkout
                }

            }).catch(function(error){
                _this.adicionarErro("ocorreu um erro ao excluir o endereço, tente novamente mais tarde");
                setTimeout(() => {
                    window.location.reload();
                }, 5000);
            })
        }
    }
}
</script>

<template>
    <div class="checkout container">
        <div class="row">
            <div class="col-6">
                <div class="row">
                    <h2 class="mb-5">Informações de Entrega:</h2>
                </div>
                <div class="row">
                    <label for="data_entrega">Data de Entrega:</label>
                    <datepicker name="data_entrega"></datepicker>
                </div>
                <div class="row pt-5">
                    <span>Endereço de Entrega:</span>
                </div>
                <div class="row">
                    <div v-for="endereco in checkout.enderecos" class="endereco d-flex flex-row flex-nowrap justify-content-between" :key="endereco.id">
                        <div>
                            <h3>{{ endereco.nome }}</h3>
                            <span>{{ endereco.endereco }}, {{ endereco.numero }}, {{ endereco.bairro }}</span>
                            <span>{{ endereco.cep }}, {{ endereco.cidade }} - {{ endereco.uf }}</span>
                            <span v-if="endereco.complemento">{{ endereco.complemento }}</span>
                        </div>
                        <div class="d-flex align-self-center flex-row align-items-end justify-content-center botoes">
                            <button @click.prevent="excluirEndereco(endereco)" class="btn icone excluir alt">
                                <i class="fa fa-trash"></i>
                            </button>
                            <button @click.prevent="selecionarEndereco(endereco)" class="btn icone selecionar alt" :class="[endereco.id == checkout.endereco_id ? 'ativo' : '']">
                                <i class="fa-solid fa-square-check"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <a :href="checkout.adicionar_endereco" class="btn btn-primary">
                        Adicionar Endereço
                    </a>
                </div>
            </div>
            <div class="col-6">
                <div class="row">
                    <h2 class="mb-5">Informações de Pagamento:</h2>
                </div>
                <div class="row">
                    <h5>Forma de Pagamento</h5>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
.checkout .endereco .icone{
    font-size: 24px;
}

.checkout .endereco .botoes{
    gap: .5rem;
}
</style>
