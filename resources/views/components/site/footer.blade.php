@include('site.adicionais.newsletter')

<footer>
    <div class="container">
        <div class="grid-items">
            <div class="footer-item logo-section">
                <a href="{{ url('/') }}">
                    <img class="logo" src="{{ asset('img/logo.png') }}">
                </a>
                <ul class="social-media-items">
                    <li><i class="fab fa-youtube" aria-hidden="true"></i></li>
                    <li><i class="fab fa-linkedin" aria-hidden="true"></i></li>
                    <li><i class="fab fa-twitter" aria-hidden="true"></i></li>
                    <li><i class="fab fa-facebook-f" aria-hidden="true"></i></li>
                    <li><i class="fab fa-instagram" aria-hidden="true"></i></li>
                </ul>
            </div>
            <div class="footer-item">
                <span class="footer-subtitle">Outros Links</span>
                <ul class="actions">
                    <li>Sobre nos</li>
                    <li>Contato</li>
                    <li>Produtos</li>
                    <li>Entrar</li>
                </ul>
            </div>
            <div class="footer-item">
                <span class="footer-subtitle">Área de Customização</span>
                <ul class="actions">
                    <li>Minha</li>
                    <li>Meus produtos</li>
                    <li>Termos</li>
                    <li>Politica de privacidade</li>
                    <li>Meu carrinho</li>
                </ul>
            </div>
            <div class="footer-item contact-section">
                <span class="footer-subtitle">Contato</span>
                <p>Entre em contato já, tire todas as suas dúvidas e adquira seus produtos.</p>
                <div class="contact-details">
                    <i class="fas fa-headset" aria-hidden="true"></i>
                    <div class="contact-placeholder">
                        <span>Tem alguma dúvida?</span>
                        <a href="#">+ 123 456 789</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<section class="sub-footer">
    <div class="container">
        <span>AGRO - © {{ \Carbon\Carbon::now()->format('Y') }} Todos os Direitos Reservados</span>
    </div>
</section>
