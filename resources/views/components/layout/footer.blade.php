<footer class="footer w-full p-8 bg-gray-300 text-black mt-12 mx-auto rounded-xl flex flex-col justify-center items-center">
    <!-- Sección de suscripción -->
    <div class="text-center">
        <div>
            <form class="flex justify-center mb-4">
                <h6 class="footer-title mr-2 mt-2"><b>¡Únete a nosotros!</b></h6>
                <input type="email" placeholder="Tu correo electrónico" class="mr-2 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                @if(auth()->check() && auth()->user()->role === 'dueño_restaurante')
                <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">Suscribirse</button>
                @elseif(auth()->check() && auth()->user()->role === 'repartidor')
                <button type="submit" class="bg-green-700 text-white px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">Suscribirse</button>
                @else
                <button type="submit" class="bg-yellow-700 text-white px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">Suscribirse</button>
                @endif
            </form>
            <span>-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</span>
        </div>
    </div>
    <!-- Sección de navegación -->
    <div class="grid grid-cols-1 md:grid-cols-3  w-full">
        <div class="md:w-1/3 mx-auto text-center">
            <h6 class="footer-title mb-4"><b>Explora</b></h6>
            <ul class="footer-links">
                <li style="margin-bottom: 10px;"><a href="#">Términos y condiciones</a></li>
                <li style="margin-bottom: 10px;"><a href="#">Quiénes Somos</a></li>
                <li style="margin-bottom: 10px;"><a href="#">Productos</a></li>
                <li style="margin-bottom: 10px;"><a href="#">Servicios</a></li>
                <li style="margin-bottom: 10px;"><a href="#">Contacto</a></li>
            </ul>
        </div>

        <!-- Sección de información de contacto -->
        <div class="md:w-1/3 mx-auto text-center">
            <h6 class="footer-title mb-4 text-center"><b>Contáctanos</b></h6>
            <ul class="footer-links">
                <li style="margin-bottom: 10px;"><b>Dirección:</b> 123 Calle Principal</li>
                <li style="margin-bottom: 10px;"><b>Teléfono:</b> +1234567890</li>
                <li style="margin-bottom: 10px;"><b>Email: </b>caseats@gmail.com</li>
            </ul>
        </div>

        <!-- Sección de redes sociales -->
        <div class="md:w-1/3 mx-auto" style="margin-bottom: 30px;">
            <h6 class="footer-title text-center"><b>Conéctate</b></h6>
            <div class="footer-social flex justify-center">
                <ul class="footer-links flex justify-center">
                    <li style="margin-right: 20px;">
                        <a href="#" class="text-2xl"><i class="fab fa-facebook-f"></i></a>
                    </li>
                    <li style="margin-right: 20px;">
                        <a href="#" class="text-2xl"><i class="fab fa-twitter"></i></a>
                    </li>
                    <li style="margin-right: 20px;">
                        <a href="#" class="text-2xl"><i class="fab fa-instagram"></i></a>
                    </li>
                    <li>
                        <a href="#" class="text-2xl"><i class="fab fa-linkedin-in"></i></a>
                    </li>
                </ul>
            </div>

        </div>

    </div>

    <!-- Derechos de autor -->
    <div class="text-sm text-center">
        <p>&copy; 2024 Todos los derechos reservados - caseats.com</p>
    </div>
</footer>
