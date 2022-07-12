<script>
import axios from "axios"
import Modal from "./components/Modal.vue"

export default {
    props: ['produto'],
    components: { Modal },
    data() {
        return {
            showModal: false,
            component_produto: {}
        }
    },
    computed: {
        total(){
            let total = (Number(this.component_produto.quantidade) * Number(this.component_produto.preco_quilo)) + Number(this.component_produto.frete)
            return isNaN(total) ? 0 : total
        },
        subtotal(){
            let subtotal = Number(this.component_produto.quantidade) * Number(this.component_produto.preco_quilo)
            return isNaN(subtotal) ? 0 : subtotal
        }
    },
    methods: {
        salvar() {
            let _this = this;
            this.component_produto.produto_id = $('.modal.adicionar-item .produto_id').val()
            loader.mostrar()

            axios.post(this.produto.atualizar, this.component_produto).then(function(response){

                if(response.data.pedido){
                    _this.$emit('atualizarPedido', response.data.pedido);
                }

                loader.esconder();
                _this.fechar();
            }).catch(function (error) {
                loader.esconder()
                console.log('catch')
            })
        },
        mostrar(){
            this.component_produto.quantidade = this.produto.quantidade
            this.component_produto.preco_quilo = this.produto.preco_quilo
            this.component_produto.frete = this.produto.frete ?? 0
            this.component_produto.icms = this.produto.icms ?? 0
            this.component_produto.produto = this.produto.produto
            this.component_produto.id = this.produto.id
            this.showModal = true
        },
        fechar(){
            this.showModal = false
        }
    }
}
</script>

<template>
    <div>
        <button @click="mostrar()" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Editar">
            <i class="fas fa-pen"></i>
        </button>
        <Modal :show="showModal" @fechar="fechar()" >
            <template #header>
                <h5 class="modal-title">Adicionar Item</h5>
            </template>

            <div class="form-group">
                <label for="produto">Produto:</label>
                <input type="text" name='produto' class='form-control' :value="component_produto.produto" disabled>
            </div>
            <div class="form-group">
                <label for="quantidade">Quantidade:</label>
                <input type="text" v-model="component_produto.quantidade" class="form-control" name="quantidade">
            </div>
            <div class="form-group">
                <label for="preco_quilo">Preço Kg.:</label>
                <input type="text" v-model="component_produto.preco_quilo" class="form-control" name="preco_quilo">
            </div>
            <div class="form-group">
                <label for="frete">Frete:</label>
                <input type="text" v-model="component_produto.frete" class="form-control" name="frete">
            </div>
            <div class="form-group">
                <label for="icms">ICMS:</label>
                <input type="text" v-model="component_produto.icms" class="form-control" name="icms">
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
