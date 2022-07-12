<script>
import AdicionarPedidoItem from './AdicionarPedidoItem.vue'
import EditarPedidoItem from './EditarPedidoItem.vue'
import Datepicker from '../Datepicker.vue'
import axios from "axios"

export default {
    components: {
        AdicionarPedidoItem,
        EditarPedidoItem,
        Datepicker
    },
    data() {
        return{
            pedido: window.pedidoDados
        }
    },
    computed: {
        mostrarDataPagamento(){

            if(this.pedido.forma_pagamento_id){
                return this.pedido.formasPagamento.find(x => x.id == this.pedido.forma_pagamento_id).mostrarData
            }

            return false;
        }
    },
    methods: {
        atualizarPedido(pedido) {
            this.pedido = pedido
        },
        verificarDesabilitado(campo){
            return this.pedido.camposDesabilitados.indexOf(campo) >= 0
        },
        salvarPedido(){
            let _this = this;

            axios.post(this.pedido.atualizar, {
                'usuario_id': this.pedido.usuarioId,
                'forma_pagamento_id': this.pedido.forma_pagamento_id,
                'data_pagamento': this.pedido.data_pagamento,
                'endereco_id': this.pedido.endereco_id,
                'data_entrega': this.pedido.data_entrega,
                'observacao': this.pedido.observacao
            }).then(function (response) {

                if(response.data.pedido){
                    _this.pedido = response.data.pedido
                }

            }).catch(function (error) { console.log(error)})
        },
        submeterPedido(){
            let _this = this;

            axios.get(this.pedido.submeter).then(function (response) {

                if(response.data.pedido){
                    _this.pedido = response.data.pedido
                }

            }).catch(function (error) { console.log(error)})
        },
        aprovarPedido(){
            let _this = this;

            axios.get(this.pedido.aprovar).then(function (response) {

                if(response.data.pedido){
                    _this.pedido = response.data.pedido
                }

            }).catch(function (error) { console.log(error)})
        },
        excluirItem(url){
            let _this = this;

            axios.post(url).then(function (response) {

                if(response.data.pedido){
                    _this.pedido = response.data.pedido
                }

            }).catch(function (error) { console.log(error)})
        }
    }
}
</script>

<template>
    <div class="card card-default">
        <div class="card-body">

            <div class="row">
                <div class="form-group col-6">
                    <label for="tipo-produto">Tipo de Produto:</label>
                    <input type="text" name="tipo-produto" :value="pedido.tipo" class='form-control' disabled />
                </div>

                <div class="form-group col-6">
                    <label for="status">Status do Pedido:</label>
                    <input type="text" name="status" :value="pedido.status" class='form-control' disabled />
                </div>
            </div>

            <div class="form-group">
                <div v-if="pedido.usuarioId == null">
                    <label for="usuario_id">Usuário:</label>
                    <select name='usuario_id' :data-s2-url="pedido.apiUsuarios" placeholder="Selecione um Usuário" class='form-control select2'></select>
                </div>
                <div v-else>
                    <label for="usuario">Usuário:</label>
                    <input type="text" name="usuario" :value="pedido.usuario" class='form-control' disabled/>
                </div>
            </div>

            <div class="form-group">
                <AdicionarPedidoItem :apiProdutos='pedido.apiProdutos' :adicionarItem='pedido.adicionarItem' @atualizarPedido="atualizarPedido" />
            </div>
            <div class="form-group">
                <table class="table table-stripped table-hover table-pedido-itens">
                    <thead>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Subtotal</th>
                        <th>Total</th>
                        <th>Ações</th>
                    </thead>
                    <tbody>
                        <tr v-for="item in pedido.itens" :key="item.id">
                            <td>{{ item.produto }}</td>
                            <td>{{ item.quantidade }}</td>
                            <td>{{ item.subtotal }}</td>
                            <td>{{ item.total }}</td>
                            <td class="botoes">
                                <a :href="item.lotes" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Visualizar Lotes">
                                    <i class="fas fa-archive"></i>
                                </a>
                                <EditarPedidoItem :produto="item" @atualizarPedido="atualizarPedido"></EditarPedidoItem>
                                <button @click="excluirItem(item.excluir)" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Excluir">
                                    <i class="fas fa-times"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="row">
                <div class="form-group col-6">
                    <label for="frete">Frete:</label>
                    <input type="text" name="frete" :value="pedido.frete" class='form-control' disabled />
                </div>
                <div class="form-group col-6">
                    <label for="icms">ICMS:</label>
                    <input type="text" name="icms" :value="pedido.icms" class='form-control' disabled />
                </div>
            </div>

            <div class="row">
                <div class="form-group col-6">
                    <label for="subtotal">Subtotal:</label>
                    <input type="text" name="subtotal" :value="pedido.subtotal" class='form-control' disabled />
                </div>
                <div class="form-group col-6">
                    <label for="total">Total:</label>
                    <input type="text" name="total" :value="pedido.total" class='form-control' disabled />
                </div>
            </div>

            <div class="row">
                <div class="form-group col">
                    <label for="forma_pagamento_id">Forma de Pagamento:</label>
                    <select class="form-control" name="forma_pagamento_id" v-model="pedido.forma_pagamento_id" :disabled="verificarDesabilitado('forma_pagamento_id')">
                        <option v-for="formasPagamento in pedido.formasPagamento" :key="formasPagamento.id" :value="formasPagamento.id" >{{ formasPagamento.nome }}</option>
                    </select>
                </div>
                <div class="form-group col" v-if="mostrarDataPagamento">
                    <label for="data_pagamento">Data de Pagamento:</label>
                    <datepicker name="data_pagamento" :data="pedido.data_pagamento" @alterarData='(data) => pedido.data_pagamento = data' :disabled="verificarDesabilitado('data_pagamento')" />
                </div>
            </div>

            <div class="row">
                <div class="form-group col">
                    <label for="endereco_id">Endereço de Entrega:</label>
                    <select class="form-control" name="endereco_id" v-model="pedido.endereco_id" :disabled="verificarDesabilitado('endereco_id')">
                        <option v-for="enderecoEntrega in pedido.enderecosEntrega" :key="enderecoEntrega.id" :value="enderecoEntrega.id" >{{ enderecoEntrega.nome }}</option>
                    </select>
                </div>
                <div class="form-group col-6">
                    <label for="data_entrega">Data de Entrega:</label>
                    <datepicker name="data_entrega" :data="pedido.data_entrega" @alterarData='(data) => pedido.data_entrega = data' :disabled="verificarDesabilitado('data_entrega')" />
                </div>
            </div>

            <div class="row">
                <div class="form-group col">
                    <label for="observacao">Observação:</label>
                    <textarea name="observacao" :value="pedido.observacao" class='form-control' />
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary" @click.prevent="salvarPedido">Salvar</button>
            <button type="submit" class="btn btn-primary ml-3" v-if="pedido.submeter != null" @click.prevent="submeterPedido">Submeter Pedido</button>
            <button type="submit" class="btn btn-primary ml-3" v-if="pedido.aprovar != null" @click.prevent="aprovarPedido">Aprovar Pedido</button>
            <a type="submit" class="btn btn-primary ml-3" v-if="pedido.cancelar != null" :href="pedido.cancelar">Cancelar Pedido</a>
            <a type="submit" class="btn btn-primary ml-3" v-if="pedido.excluir != null" :href="pedido.excluir">Excluir Pedido</a>
        </div>
    </div>
</template>

<style>
.table-pedido-itens .botoes{
    gap: 3px;
    display: flex;
}

.table-pedido-itens .btn{
    padding: 10px 12px;
}
</style>
