<!-- ══════════════════════════════════════════════════════════
     SECCIÓN PROMOCIONES
     ══════════════════════════════════════════════════════════ -->
<section id="promociones" class="py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
    <div class="container">

        <div class="text-center mb-4">
            <h2 class="fw-bold"><i class="fas fa-gift me-2 text-primary"></i>Promociones</h2>
            <p class="text-muted">Aprovechá nuestras ofertas especiales y ahorrá en tu próximo alquiler</p>
        </div>

        <div class="row g-4">

            <!-- Banner 1: Semana completa -->
            <div class="col-md-4">
                <div class="card border-0 shadow h-100 overflow-hidden">
                    <div class="card-header text-white text-center py-3 fw-bold fs-5"
                         style="background: linear-gradient(135deg, #1a73e8, #0d47a1);">
                        <i class="fas fa-calendar-week me-2"></i>Semana Completa
                    </div>
                    <div class="card-body text-center py-4">
                        <div class="display-4 fw-bold text-primary mb-2">20%</div>
                        <p class="fs-5 fw-semibold mb-1">OFF en alquileres de 7 días</p>
                        <p class="text-muted small mb-3">Reservá por 7 días o más y obtené un descuento automático en tu reserva.</p>
                        <span class="badge bg-success px-3 py-2">
                            <i class="fas fa-check-circle me-1"></i> Activa todo el mes
                        </span>
                    </div>
                    <div class="card-footer text-center bg-white border-0 pb-4">
                        <a href="<?= base_url('vehiculos') ?>" class="btn btn-primary px-4">
                            <i class="fas fa-car me-1"></i> Ver vehículos
                        </a>
                    </div>
                </div>
            </div>

            <!-- Banner 2: Primera reserva -->
            <div class="col-md-4">
                <div class="card border-0 shadow h-100 overflow-hidden" style="transform: scale(1.03);">
                    <div class="card-header text-white text-center py-3 fw-bold fs-5"
                         style="background: linear-gradient(135deg, #ff6f00, #e65100);">
                        <i class="fas fa-star me-2"></i>¡Primera Reserva!
                        <span class="badge bg-white text-warning ms-2 small">DESTACADO</span>
                    </div>
                    <div class="card-body text-center py-4">
                        <div class="display-4 fw-bold text-warning mb-2">15%</div>
                        <p class="fs-5 fw-semibold mb-1">OFF en tu primer alquiler</p>
                        <p class="text-muted small mb-3">Clientes nuevos que reservan por primera vez obtienen un descuento especial de bienvenida.</p>
                        <span class="badge bg-warning text-dark px-3 py-2">
                            <i class="fas fa-user-plus me-1"></i> Solo nuevos clientes
                        </span>
                    </div>
                    <div class="card-footer text-center bg-white border-0 pb-4">
                        <a href="<?= base_url('register') ?>" class="btn btn-warning px-4">
                            <i class="fas fa-user-plus me-1"></i> Registrarse
                        </a>
                    </div>
                </div>
            </div>

            <!-- Banner 3: Fin de semana -->
            <div class="col-md-4">
                <div class="card border-0 shadow h-100 overflow-hidden">
                    <div class="card-header text-white text-center py-3 fw-bold fs-5"
                         style="background: linear-gradient(135deg, #2e7d32, #1b5e20);">
                        <i class="fas fa-sun me-2"></i>Fin de Semana
                    </div>
                    <div class="card-body text-center py-4">
                        <div class="display-4 fw-bold text-success mb-2">3x2</div>
                        <p class="fs-5 fw-semibold mb-1">Pagá 2 días, llevá 3</p>
                        <p class="text-muted small mb-3">Alquilá de viernes a domingo y pagá solo 2 días. Válido para categorías Auto y Camioneta.</p>
                        <span class="badge bg-info px-3 py-2">
                            <i class="fas fa-clock me-1"></i> Vie–Dom solamente
                        </span>
                    </div>
                    <div class="card-footer text-center bg-white border-0 pb-4">
                        <a href="<?= base_url('vehiculos/categoria/Auto') ?>" class="btn btn-success px-4">
                            <i class="fas fa-car-side me-1"></i> Ver Autos
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <!-- Banner largo: Referidos -->
        <div class="mt-4">
            <div class="card border-0 shadow overflow-hidden">
                <div class="row g-0 align-items-center"
                     style="background: linear-gradient(135deg, #1a73e8 0%, #6a1b9a 100%);">
                    <div class="col-md-2 text-center py-4">
                        <i class="fas fa-users" style="font-size:4rem; color:rgba(255,255,255,0.8);"></i>
                    </div>
                    <div class="col-md-7 text-white py-4 px-3">
                        <h4 class="fw-bold mb-1">Programa de Referidos</h4>
                        <p class="mb-0 opacity-75">
                            Invitá a un amigo a registrarse. Cuando haga su primer alquiler,
                            <strong>los dos reciben $2.000 de crédito</strong> para su próxima reserva.
                        </p>
                    </div>
                    <div class="col-md-3 text-center py-4">
                        <a href="<?= base_url('register') ?>" class="btn btn-light btn-lg fw-bold px-4">
                            <i class="fas fa-share-alt me-2"></i>Compartir
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- FOOTER MY CAR -->
<footer class="footer-mycar">
    <div class="container">
        <div class="row">
            <!-- Columna 1: Información de la empresa -->
            <div class="col-lg-4 mb-4">
                <h5><i class="fas fa-car"></i> My Car</h5>
                <p class="text-white-50 small mb-3">Ser la empresa líder en movilidad sostenible y flexible, transformando la experiencia de alquiler de autos por día.</p>
                <ul class="contact-info small">
                    <li><i class="fas fa-map-marker-alt me-2"></i> Av. Sucre 1394, San Luis</li>
                </ul>
                <iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d199.48066749667328!2d-66.32882022288493!3d-33.29289640552615!3m2!1i1024!2i768!4f13.1!5e1!3m2!1ses-419!2sar!4v1781645279792!5m2!1ses-419!2sar" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                <div class="social-icons mt-3">
                    <a href="https://www.facebook.com/?locale=es_LA"><i class="fab fa-facebook"></i></a>
                    <a href="https://www.instagram.com/?hl=es"><i class="fab fa-instagram"></i></a>
                    <a href="https://x.com/MyCarTPI"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>

            <!-- Columna 2: Contacto -->
            <div class="col-md-2 mb-4">
                <h6>Contacto</h6>
                <ul class="contact-info small">
                    <li><i class="fas fa-phone me-2"></i> +54 11 1234-50678</li>
                    <li><i class="fab fa-whatsapp me-2"></i> +54 9 266 476-40032</li>
                    <li><i class="fas fa-envelope me-2"></i> mycartpi@.com</li>
                    <li><i class="fas fa-clock me-2"></i> Lun-Sab: 8:00 - 18:00</li>
                    <li><i class="fas fa-headset me-2"></i> Asistencia 24/7</li>
                </ul>
            </div>

            <!-- Columna 3: Enlaces del sistema -->
            <div class="col-md-3 mb-4">
                <h6>Enlaces del sistema</h6>
                <ul class="small">
                    <li><a href="<?= base_url('vehiculos') ?>"><i class="fas fa-search me-2"></i> Buscar autos</a></li>
                    <li><a href="<?= base_url('mis-reservas') ?>"><i class="fas fa-calendar-alt me-2"></i> Mis reservas</a></li>
                    <li><a href="<?= base_url('historial') ?>"><i class="fas fa-history me-2"></i> Historial de alquileres</a></li>
                    <li><a href="#promociones"><i class="fas fa-gift me-2"></i> Promociones activas</a></li>
                </ul>
            </div>

            <!-- Columna 4: Medios de pago + App -->
            <div class="col-md-3 mb-4">
                <h6>Medios de pago</h6>
                <div class="payment-icons mb-4">
                    <i class="fab fa-cc-visa"></i>
                    <i class="fab fa-cc-mastercard"></i>
                    <i class="fab fa-cc-amex"></i>
                    <i class="fab fa-cc-paypal"></i>
                </div>
                <h6 class="mt-3">Nuestra App</h6>
                <div class="app-badge">
                    <a href="https://github.com/JonathanRMF/My-Car-app">
                        <i class="fab fa-android"></i>
                        <div class="mt-1">
                            <small>Disponible en</small><br>
                            <strong>Android</strong>
                        </div>
                        <small class="text-white-50 d-block mt-1">Versión 1.0</small>
                    </a>
                </div>
                <p class="text-white-50 small mt-2">¡Gestiona tus alquileres desde tu móvil!</p>
            </div>

        </div>

        <hr>

        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <small>&copy; 2024 My Car - Todos los derechos reservados |
                <a href="#">Términos y condiciones</a> |
                <a href="#">Política de privacidad</a> |
                <a href="#">Política de cancelación</a></small>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <span class="stats-badge me-2"><i class="fas fa-users"></i> 2,345+ clientes</span>
                <span class="stats-badge me-2"><i class="fas fa-car"></i> 45+ vehículos</span>
                <span class="stats-badge"><i class="fas fa-star text-warning"></i> 4.8/5 estrellas</span>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12 text-center">
                <small class="text-white-50">
                    <i class="fas fa-shield-alt me-1"></i> Sistema seguro |
                    <i class="fas fa-lock me-1"></i> Datos protegidos |
                    <i class="fab fa-android me-1"></i> App Android disponible
                </small>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>