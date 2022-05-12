import { createApp } from 'vue'
import CarrinhoQuantidadeItem from './vueComponents/CarrinhoQuantidadeItem.vue'
import Carrinho from './vueComponents/Carrinho.vue'

const app = createApp({
    methods: {
        adicionarErro(mensagem) {
            let container = document.getElementById('erros-container');
            container.insertAdjacentHTML('beforeend', `
                <div class="toast bg-danger text-white border-0" role="alert" aria-live="assertLive" aria-atomic="true">
                    <div class="toast-body">${mensagem}</div>
                </div>`)

            let toast = $('#erros-container .toast:last');
            toast.show();
            setTimeout(() => {
                toast.remove();
            }, 5000);
        }
    },
    provide() {
        return {
            adicionarErro: this.adicionarErro
        }
    }
})

window.vueapp = app;
app.component('CarrinhoQuantidadeItem', CarrinhoQuantidadeItem)
app.component('Carrinho', Carrinho)
app.mount('#vue-app')
