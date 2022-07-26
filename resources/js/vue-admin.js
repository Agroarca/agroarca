import { createApp } from 'vue'
import AdminPedido from './vueComponents/admin/Pedido.vue'
import PedidoItemLote from './vueComponents/admin/PedidoItemLote.vue'

const app = createApp({
    components: {
        AdminPedido,
        PedidoItemLote
    }
})

window.vueapp = app;
app.mount('#vue-app')
