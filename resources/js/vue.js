import { createApp } from 'vue'
import CarrinhoQuantidadeItem from './vueComponents/CarrinhoQuantidadeItem.vue'


const app = createApp({})
window.vueapp = app;
app.component('CarrinhoQuantidadeItem', CarrinhoQuantidadeItem)

app.mount('#vue-app')
