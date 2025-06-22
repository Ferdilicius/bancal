<x-guest-layout>
    <!-- Encabezado -->
    <div class="w-full bg-[#fdfdfd] border-b border-gray-200">
        <div class="max-w-4xl mx-auto px-6 py-6 text-center">
            <a href="{{ route('home') }}">
                <img src="{{ asset('static/img/iconFresa.svg') }}" alt="Logo" class="w-20 h-20 mx-auto mb-4" />
            </a>
            <h1 class="text-3xl font-bold">Política de Privacidad</h1>
            <p class="mt-1 text-sm text-gray-600">Última actualización: 19 de junio de 2025</p>
        </div>
    </div>

    <!-- Cuerpo -->
    <div class="min-h-screen flex flex-col items-center sm:pt-0 bg-[#eaeaea73]">
        <div class="w-full sm:max-w-4xl mt-6 p-6 bg-[#ffffff00] overflow-hidden sm:rounded-lg">

            {{-- Sección 1: Introducción --}}
            <section class="border border-[#080303] bg-white shadow-sm rounded-lg p-4 mb-6">
                <h2 class="text-lg font-semibold mb-2">1. Introducción</h2>
                <div class="pl-6">
                    En Bancal, nos tomamos muy en serio la protección de tus datos personales. Esta Política de
                    Privacidad
                    describe qué información recopilamos, cómo la utilizamos y qué derechos tienes sobre ella.
                </div>
            </section>

            {{-- Sección 2: Datos Recopilados --}}
            <section class="border border-[#080303] bg-white shadow-sm rounded-lg p-4 mb-6">
                <h2 class="text-lg font-semibold mb-2">2. Datos Recopilados</h2>
                <div class="pl-6">
                    <ul class="list-disc list-inside space-y-1">
                        <li><strong>Datos de contacto:</strong> nombre, dirección, teléfono, correo electrónico.</li>
                        <li><strong>Datos de acceso:</strong> nombre de usuario, contraseña, dirección IP.</li>
                        <li><strong>Datos de actividad:</strong> productos publicados, compras realizadas, mensajes
                            enviados.</li>
                        <li><strong>Datos financieros:</strong> información relacionada con pagos y facturación.</li>
                    </ul>
                </div>
            </section>

            {{-- Sección 3: Finalidad del Tratamiento --}}
            <section class="border border-[#080303] bg-white shadow-sm rounded-lg p-4 mb-6">
                <h2 class="text-lg font-semibold mb-2">3. Finalidad del Tratamiento</h2>
                <div class="pl-6">
                    <p class="mb-2">Utilizamos tus datos personales para los siguientes fines:</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Prestar y gestionar los servicios ofrecidos en la plataforma.</li>
                        <li>Verificar identidad y prevenir fraudes.</li>
                        <li>Comunicar información relevante sobre transacciones.</li>
                        <li>Ofrecer soporte técnico y atención al cliente.</li>
                        <li>Enviar promociones, actualizaciones o encuestas (previo consentimiento).</li>
                    </ul>
                </div>
            </section>

            {{-- Sección 4: Base Legal --}}
            <section class="border border-[#080303] bg-white shadow-sm rounded-lg p-4 mb-6">
                <h2 class="text-lg font-semibold mb-2">4. Base Legal para el Tratamiento</h2>
                <div class="pl-6">
                    <p class="pl-6">El tratamiento de tus datos se basa en la ejecución de un contrato, tu
                        consentimiento,
                        el cumplimiento de obligaciones legales y el interés legítimo de mejorar nuestros servicios.</p>
                </div>
            </section>

            {{-- Sección 5: Compartición de Datos --}}
            <section class="border border-[#080303] bg-white shadow-sm rounded-lg p-4 mb-6">
                <h2 class="text-lg font-semibold mb-2">5. Compartición de Datos</h2>
                <div class="pl-6">
                    <p class="mb-2">Podemos compartir tus datos con:</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Proveedores de servicios (pagos, alojamiento, soporte técnico).</li>
                        <li>Autoridades legales si así lo requiere la ley.</li>
                        <li>Otros usuarios, únicamente en el contexto de una transacción.</li>
                </div>

                </ul>
            </section>

            {{-- Sección 6: Seguridad de los Datos --}}
            <section class="border border-[#080303] bg-white shadow-sm rounded-lg p-4 mb-6">
                <h2 class="text-lg font-semibold mb-2">6. Seguridad de los Datos</h2>
                <p class="pl-6">Implementamos medidas técnicas y organizativas adecuadas para proteger tus datos
                    contra
                    pérdida, acceso no autorizado o uso indebido.</p>
            </section>

            {{-- Sección 7: Conservación de los Datos --}}
            <section class="border border-[#080303] bg-white shadow-sm rounded-lg p-4 mb-6">
                <h2 class="text-lg font-semibold mb-2">7. Conservación de los Datos</h2>
                <p class="pl-6">Tus datos se conservarán mientras tengas una cuenta activa y durante el tiempo
                    necesario
                    para cumplir con obligaciones legales o resolver disputas.</p>
            </section>

            {{-- Sección 8: Derechos del Usuario --}}
            <section class="border border-[#080303] bg-white shadow-sm rounded-lg p-4 mb-6">
                <h2 class="text-lg font-semibold mb-2">8. Derechos del Usuario</h2>
                <div class="pl-6">
                    <p class="mb-2">Puedes ejercer tus derechos de:</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Acceso, rectificación o supresión de tus datos.</li>
                        <li>Limitación u oposición al tratamiento.</li>
                        <li>Portabilidad de datos.</li>
                        <li>Retiro de consentimiento en cualquier momento.</li>
                    </ul>
                    <p class="mt-2">Para ejercer estos derechos, puedes contactar con nosotros a través de:
                        <a href="mailto:soporte@bancal.es" class="text-blue-600 underline">soporte@bancal.es</a>
                    </p>
                </div>
            </section>

            {{-- Sección 9: Cambios en la Política de Privacidad --}}
            <section class="border border-[#080303] bg-white shadow-sm rounded-lg p-4 mb-6">
                <h2 class="text-lg font-semibold mb-2">9. Cambios en la Política de Privacidad</h2>
                <p class="pl-6">Nos reservamos el derecho a modificar esta política en cualquier momento. Te
                    notificaremos
                    mediante correo electrónico o aviso en la plataforma cuando se realicen cambios significativos.</p>
            </section>

            {{-- Sección 10: Legislación Aplicable --}}
            <section class="border border-[#080303] bg-white shadow-sm rounded-lg p-4 mb-6">
                <h2 class="text-lg font-semibold mb-2">10. Legislación Aplicable</h2>
                <p class="pl-6">Esta Política de Privacidad se rige por la normativa vigente en materia de protección
                    de
                    datos, incluyendo el Reglamento General de Protección de Datos (UE) 2016/679 (RGPD) y la Ley
                    Orgánica 3/2018
                    de Protección de Datos Personales y garantía de los derechos digitales (LOPDGDD).</p>
            </section>
        </div>

        <div class="w-full bg-[#fdfdfd] border-t border-gray-200">
            <div class="max-w-4xl mx-auto px-6 py-6 text-center">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('static/img/iconFresa.svg') }}" alt="Logo" class="w-20 h-20 mx-auto mb-4" />
                </a>
                <p class="mt-1 text-sm text-gray-600">Al utilizar Bancal, confirmas que has leído, entendido y aceptado
                    esta Política de Privacidad.</p>
            </div>
        </div>
    </div>
</x-guest-layout>
