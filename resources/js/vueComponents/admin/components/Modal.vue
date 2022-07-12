<script>

export default {
    props: ['show', 'class', 'onAfterEnter'],
    methods: {
        fechar(){
            this.$emit("fechar");
        },
    },
}
</script>

<template>
    <div>
        <teleport to="body">
            <transition name="modal" @after-enter="onAfterEnter">
                <div v-if="show">
                    <div class="modal fade show" :class="class" tabindex="-1" @click="fechar" >
                        <div class="modal-dialog" @click.stop="">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <slot name="header"></slot>
                                    <button type="button" class="close" @click="fechar" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <slot></slot>
                                </div>
                                <div class="modal-footer">
                                    <slot name="footer"></slot>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="backdrop"></div>
                </div>
            </transition>
        </teleport>
    </div>
</template>

<style scoped>
.modal-enter-active,
.modal-leave-active {
    transition: opacity .5s;
}

.modal-enter-from,
.modal-leave-to {
    opacity: 0;
}

.modal{
    display: block;
}

.backdrop{
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: black;
    z-index: 1045;
    opacity: .5;
    cursor: pointer;
}
</style>
