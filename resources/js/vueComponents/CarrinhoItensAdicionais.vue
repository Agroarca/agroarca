<script>
import axios from "axios"
export default {
    props: ['pedidoItem'],
    data() {
        return {
            adicionais: []
        }
    },
    methods:{
        carregar(){
            let _this = this
            loader.mostrar()

            axios.get(this.pedidoItem.link_adicionais).then(function(response){
                loader.esconder()
                _this.adicionais = response.data.adicionais

                let modal = new bootstrap.Modal(document.querySelector('.modal-adicionais-' + _this.pedidoItem.id))
                modal.show()
            })
        }
    }
}
</script>

<template>
    <div>
        <button class="adicionais" @click.prevent="carregar()"><i class="fa-solid fa-seedling"></i></button>
        <teleport to="body">
            <div class="modal fade show modal-adicionais" tabindex="-1" :class="['modal fade show modal-adicionais', 'modal-adicionais-' + pedidoItem.id]">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3>Adicionais</h3>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row item-adicional" v-for="adicional in adicionais" :key="adicional.id">
                                <div class="col-4 col-lg-3">
                                    <img :src="adicional.imagem.src" :alt="adicional.imagem.descricao">
                                </div>
                                <div class="col-6 col-lg-7">
                                    <div class="row">
                                        <h3>{{ adicional.nome }}</h3>
                                        <span>{{ adicional.descricao }}</span>
                                        <span><span class="preco">R$ {{ adicional.preco }}</span><span class="unidade"> / Kg</span></span>
                                    </div>
                                </div>
                                <div class="col-lg-2 d-flex align-items-center justify-content-center">
                                    <button class="selecionar">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <slot name="footer"></slot>
                        </div>
                    </div>
                </div>
            </div>
        </teleport>
    </div>
</template>

<style scoped>
.modal-adicionais img{
    width: 100%;
}

.modal-adicionais .item-adicional + .item-adicional{
    margin-top: 15px;
}

.modal-adicionais .selecionar{
    width: 56px;
    height: 56px;
    color: var(--borda);
    border: 1px solid var(--borda);
    background: var(--branco);
    font-size: 24px;
    border-radius: 12px;
}

.modal-adicionais .item-adicional .preco {
    font-family: "Poppins", Arial, Helvetica, sans-serif;
    margin-top: 0.5rem;
    color: var(--verde-claro);
    font-size: 24px;
    font-weight: 600;
}

.modal-adicionais .item-adicional .unidade {
    font-family: "Poppins", Arial, Helvetica, sans-serif;
    color: var(--cinza-escuro);
    font-size: 16px;
    font-weight: 500;
}

</style>
