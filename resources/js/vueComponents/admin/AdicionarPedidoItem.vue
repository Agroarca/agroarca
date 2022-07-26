<script>
import axios from "axios"
import Modal from "./components/Modal.vue"

export default {
    props: ['apiProdutos', 'adicionarItem'],
    components: {Modal},
    data() {
        return {
            produto: {
                quantidade: 0,
                preco_quilo: 0,
                frete: 0,
                icms: 0,
                produto_id: null,
            },
            showModal: false,
            erros: []
        }
    },
    computed: {
        total(){
            return (Number(this.produto.quantidade) * Number(this.produto.preco_quilo)) + Number(this.produto.frete)
        },
        subtotal(){
            return Number(this.produto.quantidade) * Number(this.produto.preco_quilo)
        }
    },
    methods: {
        salvar() {
            let _this = this;
            this.produto.produto_id = $('.modal.adicionar-item .produto_id').val()
            loader.mostrar()

            axios.post(this.adicionarItem, this.produto).then(function(response){
                loader.esconder();

                if(response.data.pedido){
                    _this.$emit('atualizarPedido', response.data.pedido);
                }

                _this.fechar();
            }).catch(function (error) {
                loader.esconder()

                if(error.response.data.hasOwnProperty('errors')){
                    _this.erros = Object.values(error.response.data.errors).flat()
                }else if(error.response.data.hasOwnProperty('message')){
                    _this.erros = [error.response.data.message]
                }else{
                    _this.erros = ["Ocorreu um erro, tente novamente mais tarde"]
                }
            })
        },
        adicionar(){
            this.produto.quantidade = 0
            this.produto.preco_quilo = 0
            this.produto.frete = 0
            this.produto.icms = 0
            this.produto.produto_id = null
            this.showModal = true
            this.erros = []
        },
        fechar(){
            this.showModal = false
        },
        setupSelect2(){
            window.select2(document.querySelector(".select2.produto_id"))
        }
    }
}
</script>

<template>
    <div>
        <button class="btn btn-primary" @click="adicionar">Adicionar Item
        </button>
        <Modal :show="showModal" class="adicionar-item" @fechar="fechar" :onAfterEnter="setupSelect2">
            <template #header>
                <h5 class="modal-title">Adicionar Item</h5>
            </template>

            <div class="form-group" v-if="erros.length > 0">
                <div class="alert alert-danger" role="alert">
                    <span class="d-block" v-for="(erro, index) in erros" :key="index">{{erro}}</span>
                </div>
            </div>

            <div class="form-group">
                <label for="produto_id">Produto:</label>
                <select name='produto_id' @change="event => produto.produto_id = event.target.value" :data-s2-url="apiProdutos" placeholder="Selecione um Produto" class='form-control select2 produto_id'></select>
            </div>
            <div class="form-group">
                <label for="quantidade">Quantidade:</label>
                <input type="text" v-model="produto.quantidade" class="form-control" name="quantidade">
            </div>
            <div class="form-group">
                <label for="preco_quilo">Preço Kg.:</label>
                <input type="text" v-model="produto.preco_quilo" class="form-control" name="preco_quilo">
            </div>
            <div class="form-group">
                <label for="frete">Frete:</label>
                <input type="text" v-model="produto.frete" class="form-control" name="frete">
            </div>
            <div class="form-group">
                <label for="icms">ICMS:</label>
                <input type="text" v-model="produto.icms" class="form-control" name="icms">
            </div>
            <div class="form-group">
                <label for="subtotal">Subtotal:</label>
                <input type="text" v-model="subtotal" class="form-control" name="subtotal" disabled>
            </div>
            <div class="form-group">
                <label for="total">Total:</label>
                <input type="text" v-model="total" class="form-control" name="total" disabled>
            </div>

            <template #footer>
                <button type="button" class="btn btn-secondary" @click="fechar">Fechar</button>
                <button type="button" @click="salvar" class="btn btn-primary">Salvar</button>
            </template>
        </Modal>
    </div>
</template>
