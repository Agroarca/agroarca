import { createApp } from 'vue'
import AdminPedido from './vueComponents/admin/Pedido.vue'

const app = createApp({
    components: {
        AdminPedido
    }
})

window.vueapp = app;
app.mount('#vue-app')
