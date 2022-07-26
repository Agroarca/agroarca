<script>
import axios from "axios"
import Modal from "./components/Modal.vue"

export default {
    components: {Modal},
    data() {
        return {
            lotes: window.lotesDados,
            modal: {
                quantidade: 0,
                show: false,
                operacao: 0,
                id: 0,
                erros: []
            }
        }
    },
    methods:{
        adicionarMovimento(lote){
            this.modal.operacao = 0 //OperacaoMovimentoLote::Soma
            this.modal.quantidade = this.lotes.quantidadeRestante
            this.modal.id = lote.id
            this.modal.erros =  []
            this.modal.show = true
        },
        removerMovimento(lote){
            this.modal.operacao = 1 //OperacaoMovimentoLote::Diminui
            this.modal.quantidade = this.getQuantidade(lote.id)
            this.modal.id = lote.id
            this.modal.erros = []
            this.modal.show = true
        },
        fechar(){
            this.modal.show = false
        },
        salvar(){
            let _this = this
            loader.mostrar()

            axios.post(this.lotes.salvarMovimento, {
                lote_id: this.modal.id,
                quantidade: this.modal.quantidade,
                operacao: this.modal.operacao
            }).then(function(response) {
                loader.esconder()
                this.modal.erros = []

                if(response.data.lotes){
                    _this.lotes = response.data
                }

                _this.fechar()
            }).catch(function (error){
                loader.esconder()

                if(error.response.data.hasOwnProperty('errors')){
                    _this.modal.erros = Object.values(error.response.data.errors).flat()
                }else if(error.response.data.hasOwnProperty('message')){
                    _this.modal.erros = [error.response.data.message]
                }else{
                    _this.modal.erros = ["Ocorreu um erro, tente novamente mais tarde"]
                }

            })
        },
        getQuantidade(loteId){
            let lote = this.lotes.lotes.find(x => x.id == loteId);
            if(lote){
                return lote.quantidade_movimentos
            }

            return 0
        }
    }
}
</script>

<template>
    <div class="card card-default">
        <div class="card-body table-responsive p-0">
            <table class="table table-stripped table-hover">
                <thead>
                    <th>Nome</th>
                    <th>Quantidade Disponível</th>
                    <th>Quantidade</th>
                    <th>Ações</th>
                </thead>
                <tbody>
                    <tr v-for="lote in lotes.lotes" :key="lote.id">
                        <td>{{ lote.nome }}</td>
                        <td>{{ lote.quantidade_disponivel }}</td>
                        <td>{{ lote.quantidade_movimentos }}</td>
                        <td v-if="lote.id != 0">
                            <button @click="adicionarMovimento(lote)" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Adicionar Quantidade">
                                <i class="fas fa-plus"></i>
                            </button>
                            <button @click="removerMovimento(lote)" class="btn btn-primary ml-2" data-toggle="tooltip" data-placement="top" title="Remover Quantidade">
                                <i class="fas fa-minus"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <Modal :show="modal.show" @fechar="fechar">
            <template #header>
                <h5 class="modal-title">{{ operacao == 0 ? 'Adicionar Quantidade' : 'Diminuir Quantidade' }}</h5>
            </template>

            <div class="form-group" v-if="modal.erros.length > 0">
                <div class="alert alert-danger" role="alert">
                    <span class="d-block" v-for="(erro, index) in modal.erros" :key="index">{{erro}}</span>
                </div>
            </div>

            <div class="form-group">
                <label for="quantidade">Quantidade:</label>
                <input type="text" v-model="modal.quantidade" class="form-control" name="quantidade">
            </div>

            <template #footer>
                <button type="button" class="btn btn-secondary" @click="fechar">Fechar</button>
                <button type="button" @click="salvar" class="btn btn-primary">Salvar</button>
            </template>
        </Modal>
    </div>
</template>
