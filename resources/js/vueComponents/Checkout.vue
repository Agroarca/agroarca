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
            checkout: window.checkoutDados,
            erros: {}
        }
    },
    computed: {
        mostrarDataPagamento(){

            if(this.checkout.forma_pagamento_id){
                return this.checkout.formas_pagamento.find(x => x.id == this.checkout.forma_pagamento_id).mostrarData
            }

            return false;
        }
    },
    methods: {
        selecionarEndereco(endereco){
            let _this = this;
            loader.mostrar()

            axios.post(endereco.selecionar).then(function (response){
                loader.esconder()

                if(response.data.checkout){
                    _this.checkout = response.data.checkout
                }

            }).catch(function(error){
                loader.esconder()
                _this.adicionarErro("ocorreu um erro ao selecionar o endereço, tente novamente mais tarde");
                setTimeout(() => {
                    window.location.reload();
                }, 5000);
            })
        },
        excluirEndereco(endereco){
            let _this = this;
            loader.mostrar()

            axios.post(endereco.excluir).then(function (response){
                loader.esconder()

                if(response.data.checkout){
                    _this.checkout = response.data.checkout
                }

            }).catch(function(error){
                loader.esconder()
                _this.adicionarErro("ocorreu um erro ao excluir o endereço, tente novamente mais tarde");
                setTimeout(() => {
                    window.location.reload();
                }, 5000);
            })
        },
        alterarFormaPagamento(){
            let _this = this;
            let formaPagamento = this.checkout.formas_pagamento.find(x => x.id == this.checkout.forma_pagamento_id)

            axios.post(formaPagamento.selecionar).then(function (response){

                if(response.data.checkout){
                    _this.checkout = response.data.checkout
                }

            }).catch(function(error){
                _this.adicionarErro("ocorreu um erro ao alterar a forma de pagamento, tente novamente mais tarde");
                setTimeout(() => {
                    window.location.reload();
                }, 5000);
            })
        },
        alterarDataPagamento(data){
            let _this = this;

            axios.post(this.checkout.alterarDataPagamento, {"data": data}).then(function (response){

                if(response.data.checkout){
                    _this.checkout = response.data.checkout
                }

            }).catch(function(error){
                _this.adicionarErro("ocorreu um erro ao alterar a data de pagamento, tente novamente mais tarde");
                setTimeout(() => {
                    window.location.reload();
                }, 5000);
            })
        },
        alterarDataEntrega(data){
            let _this = this;

            axios.post(this.checkout.alterarDataEntrega, {"data": data}).then(function (response){

                if(response.data.checkout){
                    _this.checkout = response.data.checkout
                }

            }).catch(function(error){
                _this.adicionarErro("ocorreu um erro ao alterar a data de entrega, tente novamente mais tarde");
                setTimeout(() => {
                    window.location.reload();
                }, 5000);
            })
        },
        finalizar(){
            let _this = this;

            axios.post(this.checkout.finalizarPedido).then(function (response){

                if(response.data.redirect){
                    window.location = resposne.data.redirect
                    return
                }

                if(response.data.checkout){
                    _this.checkout = response.data.checkout
                }

                if(response.data.erros){
                    _this.erros = response.data.erros;

                    setTimeout(() => {
                        let alert = document.querySelector('.alert.alert-danger')
                        if(alert){
                            document.body.scrollTop = alert.offsetTop - 100;
                        }
                    }, 100);
                }

            }).catch(function(error){
                _this.adicionarErro("ocorreu um erro ao finalizar o pedido, tente novamente mais tarde");
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
        <div class="d-flex flex-column">
            <h2 class="mt-5">Informações de Entrega:</h2>

            <div class="data-entrega mt-4">
                <label for="data_entrega">Data de Entrega:</label>
                <datepicker name="data_entrega" @alterarData="alterarDataEntrega" :data="checkout.data_entrega ?? new Date()"></datepicker>

                <div class="alert alert-danger mt-3" v-if="erros.data_entrega && erros.data_entrega.length > 0">
                    <span class="d-block" v-for="erro in erros.data_entrega" :key="erro">{{erro}}</span>
                </div>
            </div>

            <div class="endereco-entrega mt-4">
                <span>Endereço de Entrega:</span>

                <div class="alert alert-danger mt-3" v-if="erros.endereco_id && erros.endereco_id.length > 0">
                    <span class="d-block" v-for="erro in erros.endereco_id" :key="erro">{{erro}}</span>
                </div>

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

                <a :href="checkout.adicionar_endereco" class="btn btn-primary">
                    Adicionar Endereço
                </a>
            </div>

            <h2 class="mt-5">Informações de Pagamento:</h2>

            <div class="forma-pagamento mt-4">
                <label for="forma_pagamento_id">Forma de Pagamento:</label>
                <select @change="alterarFormaPagamento()" class="form-select" name="forma_pagamento_id" v-model="checkout.forma_pagamento_id">
                    <option v-for="forma_pagamento in checkout.formas_pagamento" :key="forma_pagamento.id" :value="forma_pagamento.id" >{{ forma_pagamento.nome }}</option>
                </select>

                <div class="alert alert-danger mt-3" v-if="erros.forma_pagamento_id && erros.forma_pagamento_id.length > 0">
                    <span class="d-block" v-for="erro in erros.forma_pagamento_id" :key="erro">{{erro}}</span>
                </div>
            </div>

            <div class="forma-pagamento mt-4" v-if="mostrarDataPagamento">
                <label for="data_pagamento">Data de Pagamento:</label>
                <datepicker name="data_pagamento" @alterarData="alterarDataPagamento" :data="checkout.data_pagamento ?? new Date()"></datepicker>

                <div class="alert alert-danger mt-3" v-if="erros.data_pagamento && erros.data_pagamento.length > 0">
                    <span class="d-block" v-for="erro in erros.data_pagamento" :key="erro">{{erro}}</span>
                </div>
            </div>

            <div class="mt-4">
                <button @click="finalizar()" class="btn btn-primary">
                    Enviar Pedido
                </button>
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
