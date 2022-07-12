//
class Loader {
    ativo = false;

    mostrar() {
        if (!this.ativo) {
            $('.loader').fadeIn('fast');
            this.ativo = true;
        }
    }

    esconder() {
        if (this.ativo) {
            $('.loader').fadeOut('fast');
            this.ativo = false;
        }
    }
}

window.loader = new Loader();
