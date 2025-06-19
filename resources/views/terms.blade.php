<x-guest-layout>
    <!-- Encabezado en toda la anchura -->
    <div class="w-full bg-[#fdfdfd] border-b border-gray-200">
        <div class="max-w-4xl mx-auto px-6 py-6 text-center">
            <a href="{{ route('home') }}">
                <img src="{{ asset('static/img/iconFresa.svg') }}" alt="Logo" class="w-20 h-20 mx-auto mb-4" />
            </a>
            <h1 class="text-3xl font-bold">Términos de Uso</h1>
            <p class="mt-1 text-sm text-gray-600">Última actualización: 19 de junio de 2025</p>
        </div>
    </div>

    <!-- Fondo general del cuerpo -->
    <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0 bg-[#f0f0f0]">
        <div class="w-full sm:max-w-4xl mt-6 p-6 bg-[#f0f0f0] overflow-hidden sm:rounded-lg">

            {{-- Sección 1: Introducción y Aceptación --}}
            
            <section class="border border-[#080303] bg-white shadow-sm rounded-lg p-4 mb-6">
                <h2 class="text-lg font-semibold mb-2">1. Introducción y Aceptación</h2>
                <div class="pl-6">
                Bienvenido a Bancal, plataforma con el objetivo de conectar productores, agricultores y
                comerciantes de frutas y verduras frescas con consumidores que buscan productos de calidad directamente
                del campo.

                Al acceder y utilizar nuestros servicios, ya sea como comprador o vendedor, aceptas automáticamente
                estas Políticas de Uso. Si no estás de acuerdo con alguna de estas condiciones, te pedimos que no
                utilices la plataforma y busques otra alternativa que cumpla con tus necesidades.
                </div>
            </section>

            {{-- Sección 2: Definiciones Específicas --}}
            <section class="border border-[#080303] bg-white shadow-sm rounded-lg p-4 mb-6">
                <h2 class="text-lg font-semibold mb-2">2. Definiciones Específicas</h2>
                <div class="pl-6">
                <ul class="list-disc list-inside space-y-1">
                    <li><strong>Plataforma:</strong> El sitio web y aplicación Bancal.</li>
                    <li><strong>Vendedor:</strong> Agricultor, comerciante o particular que ofrece productos.</li>
                    <li><strong>Comprador:</strong> Usuario que adquiere productos.</li>
                    <li><strong>Bancal:</strong> Espacio virtual para exponer productos.</li>
                </ul>
                </div>
            </section>

            {{-- Sección 3: Registro y Verificación de Usuarios --}}
            <section class="border border-[#080303] bg-white shadow-sm rounded-lg p-4 mb-6">
                <h2 class="text-lg font-semibold mb-4">3. Registro y Verificación de Usuarios</h2>

                <!-- Subapartado 3.1 Requisitos Generales-->
                <div class="pl-6">
                    <h3 class="text-base font-semibold mb-2">3.1 Requisitos Generales</h3>
                    <ul class="list-disc list-inside space-y-1 mb-4">
                        <li>Ser mayor de 18 años.</li>
                        <li>Proporcionar información personal veraz y actualizada.</li>
                        <li>Aceptar recibir comunicaciones relacionadas con transacciones.</li>
                        <li>Mantener un comportamiento ético y respetuoso en la plataforma.</li>
                    </ul>
                </div>

                <!-- Subapartado 3.2 Verificación de Vendedores -->
                <div class="pl-6">
                    <h3 class="text-base font-semibold mb-2">3.2 Verificación de Vendedores</h3>
                    <p class="mb-2">Los vendedores deben presentar:</p>
                    <ul class="list-disc list-inside space-y-1 mb-4">
                        <li>Documentación que acredite su actividad agrícola o comercial en caso de ser agricultor.</li>
                        <li>Certificados de calidad o producción orgánica (cuando aplique).</li>
                        <li>Información sobre ubicación y métodos de cultivo.</li>
                        <li>Referencias comerciales o testimonios de calidad.</li>
                    </ul>
                </div>

                <!-- Subapartado 3.3 Verificación de Compradores Mayoristas -->
                <div class="pl-6">
                    <h3 class="text-base font-semibold mb-2">3.3 Verificación de Compradores Mayoristas</h3>
                    <p class="mb-2">Para compras al por mayor se requiere:</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Registro mercantil o licencia comercial.</li>
                        <li>Información sobre el destino de los productos.</li>
                        <li>Capacidad de almacenamiento y distribución adecuada.</li>
                    </ul>
                </div>
            </section>

            {{-- Sección 4: Normas de Publicación y Venta --}}
            <section class="border border-[#080303] bg-white shadow-sm rounded-lg p-4 mb-6">
                <h2 class="text-lg font-semibold mb-2">4. Normas de Publicación y Venta</h2>
                <p class="mb-2">La plataforma Bancal se debe utilizar con el fin exclusivo de facilitar el contacto y
                    las transacciones entre compradores y vendedores de productos frescos. Está prohibido cualquier uso
                    que atente contra la legalidad vigente o la finalidad de este espacio.</p>

                <div class="pl-6">
                    <p class="font-medium">Usos Permitidos:</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Ofrecer productos agrícolas reales y disponibles.</li>
                        <li>Buscar y contactar vendedores o compradores de forma honesta.</li>
                        <li>Publicar información clara sobre los productos.</li>
                        <li>Frutas y verduras frescas, de temporada y fuera de ella.</li>
                        <li>Publicar semillas y plantas vivas.</li>
                    </ul>
                </div>

                <div class="pl-6">
                    <p class="font-medium mt-2">Usos Prohibidos:</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Falsificar identidad o información del producto.</li>
                        <li>Publicar contenido ofensivo o discriminatorio.</li>
                        <li>Publicar productos procesados.</li>
                        <li>Realizar transacciones fuera del sistema Bancal sin autorización.</li>
                    </ul>
                </div>
            </section>

            {{-- Sección 5: Transacciones y Pagos --}}
            <section class="border border-[#080303] bg-white shadow-sm rounded-lg p-4 mb-6">
                <h2 class="text-lg font-semibold mb-2">5. Transacciones, Pagos y Transparencia Comercial</h2>

                <div class="pl-6">
                    <p class="font-medium">5.1 Política de Precios</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Los precios deben ser justos y competitivos con el mercado local.</li>
                        <li>Prohibida la especulación o manipulación artificial de precios</li>
                        <li>Los precios incluyen IVA cuando sea aplicable</li>
                    </ul>
                </div>

                <div class="pl-6">
                    <p class="font-medium mt-4">5.2 Información Obligatoria</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Precio por kilogramo o unidad.</li>
                        <li>Cantidad mínima de compra
                        <li>Disponibilidad en tiempo real.</li>
                        <li>Costos adicionales, como el transporte o el embalaje.</li>
                        <li>Formas de pago aceptadas</li>
                    </ul>
                </div>
                <p class="mt-2">Bancal retiene un pequeño porcentaje por cada transacción completada, destinado al
                    mantenimiento y mejora de la plataforma.</p>
            </section>

            {{-- Sección 6: Proceso de Compraventa --}}
            <section class="border border-[#080303] bg-white shadow-sm rounded-lg p-4 mb-6">
                <h2 class="text-lg font-semibold mb-2">6. Proceso de Compraventa</h2>

                <div class="pl-6">
                    <p class="font-medium">6.1 Reserva y Confirmación</p>
                    <ol class="list-decimal list-inside space-y-1">
                        <li>El comprador selecciona el producto y cantidades.</li>
                        <li>El sistema verifica disponibilidad en tiempo real.</li>
                        <li>El vendedor confirma la reserva en un máximo de 2 horas.</li>
                        <li>Se confirma la transacción en la plataforma.</li>
                    </ol>
                </div>

                <div class="pl-6">
                    <p class="font-medium mt-4">6.2 Métodos de Pago Seguros</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Tarjetas de crédito y débito.</li>
                        <li>Transferencias bancarias.</li>
                        <li>Pagos móviles (Bizum, PayPal).</li>
                    </ul>
                </div>

                {{-- <div class="pl-6">
                <p class="font-medium mt-4">6.3 Comisiones de la Plataforma</p>
                <ul class="list-disc list-inside space-y-1">
                    <li>Tarjetas de crédito y débito.</li>

                </ul>
                </div> --}}

            </section>

            {{-- Sección 7: Logística y Entrega --}}
            <section class="border border-[#080303] bg-white shadow-sm rounded-lg p-4 mb-6">
                <h2 class="text-lg font-semibold mb-2">7. Logística y Entrega</h2>

                <div class="pl-6">
                    <p class="font-medium mt-4">7.1 Opciones de Entrega</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li><strong>Recogiga en origen:</strong> Directamente en la finca o almacén del productor.</li>
                        <li><strong>Puntos de recogida:</strong> Mercados locales y centros de distribución, como
                            centros comerciales y locales.</li>
                        <li><strong>Entrega a domicilio:</strong> Según disponibilidad y cobertura geográfica del
                            vendedor.</li>
                        <li><strong>Transporte especializado:</strong> Para grandes volúmenes con regrigeración.</li>
                    </ul>
                </div>

                <div class="pl-6">
                    <p class="font-medium mt-4">7.2 Tiempos de Entrega</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li><strong>Productos locales:</strong> De 24 a 48 horas.</li>
                        <li><strong>Productos de temporada:</strong> Según disponibilidad de la cosecha.</li>
                        <li><strong>Pedidos especiales:</strong> Hasta 7 días laborables.</li>
                        <li><strong>Entregas urgentes:</strong> Servicio premium disponible con un costo adicional.</li>
                    </ul>
                </div>

                <div class="pl-6">
                    <p class="font-medium mt-4">7.3 Embalaje y Conservación</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Embalaje ecológico y biodegradable preferente.</li>
                        <li>Mantenimiento de la cadena de frío cuando sea necesario.</li>
                        <li>Etiquetado claro con información del producto (en caso de ser agricultor).</li>
                        <li>Instrucciones de conservación incluidas.</li>
                    </ul>
                </div>
            </section>

            {{-- Sección 8: Logística y Entrega --}}
            <section class="border border-[#080303] bg-white shadow-sm rounded-lg p-4 mb-6">
                <h2 class="text-lg font-semibold mb-2">8. Garantías de Calidad y Satisfacción</h2>

                <div class="pl-6">
                    <p class="font-medium mt-4">8.1 Garantía de fescura</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>72 horas mínimas de vida útil garantizada desde la entrega.</li>
                        <li>Productos en perfecto estado de conservación.</li>
                        <li>Cumplimienton de estándadares sanitatios vigentes.</li>
                        <li>Trazabilidad completa des producto.</li>
                    </ul>
                </div>

                <div class="pl-6">
                    <p class="font-medium mt-4">8.2 Política de Devoluciones</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>24 horas para reportar problemas de calidad.</li>
                        <li>Reembolso completo por productos defectuosos.</li>
                        <li>Reposición gratuita cuando sea posible.</li>
                        <li>Crédito en la plataforma como alternativa al reembolso.</li>
                    </ul>
                </div>

                <div class="pl-6">
                    <p class="font-medium mt-4">8.3 Proceso de Reclamación</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Documentación fotográfica del problema.</li>
                        <li>Evaluación por el equipo especializado en 24 horas.</li>
                        <li>Resolución y compensación en 48 horas como máximo.</li>

                    </ul>
                </div>
            </section>

            {{-- Sección 9: Sistema de Calificiaciones y Reseñas --}}
            <section class="border border-[#080303] bg-white shadow-sm rounded-lg p-4 mb-6">
                <h2 class="text-lg font-semibold mb-2">9. Sistema de Calificiaciones y Reseñas</h2>

                <div class="pl-6">
                    <p class="font-medium mt-4">9.1 Evaluación de Vendedores</p>
                    <ul class="list-disc list-inside space-y-1">
                        Los usuarios de Bancal podrán evaluar y calificar a sus vendedores con los siguientes criterios:
                        <li>Calidad del producto (1-5 estrellas).</li>
                        <li>Puntualidad en la entrega.</li>
                        <li>Relación calidad-precio.</li>
                        <li>Cumplimiento de descripciones de productos.</li>
                        <li>Calidad de la información.</li>
                    </ul>
                </div>

                <div class="pl-6">
                    <p class="font-medium mt-4">9.2 Evaluación de Compradores</p>
                    Los usuarios de Bancal que ofrezcan sus productos podrán evaluar y calificar a sus compradores con
                    los siguientes criterios:
                    <ul class="list-disc list-inside space-y-1">
                        <li>Profesionalidad en transacciones.</li>
                        <li>Comunicación efectiva.</li>
                        <li>Cumplimiento de acuerdos.</li>
                    </ul>
                </div>

                <div class="pl-6">
                    <p class="font-medium mt-4">9.3 Consecuencias de Calificaciones</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Revisión de cuenta ante calificaicoes negativas persistentes.</li>
                        <li>Suspensión de la cuenta de manera temporal o permanente si el comportamiento es inadecuado.
                        </li>
                        <li>Sello de calidad premium a los vendedores con más de 4,5 estrellas.</li>
                    </ul>
                </div>
            </section>

            {{-- Sección 10: Sostenibilidad y Responsabilidad Ambiental --}}
            <section class="border border-[#080303] bg-white shadow-sm rounded-lg p-4 mb-6">
                <h2 class="text-lg font-semibold mb-2">10. Sostenibilidad y Responsabilidad Ambiental</h2>

                <div class="pl-6">
                    <p class="font-medium mt-4">10.1 Comportamiento Ecológico</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Promoción de agricultura sostenible y orgánica.</li>
                        <li>Fomento del consumo de productos locales y de temporada.</li>
                        <li>Minimización de desperdicios alimentarios.</li>
                    </ul>
                </div>

                <div class="pl-6">
                    <p class="font-medium mt-4">10.2 Certificaciones Reconocidas</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Agricultura Ecológica Europea (AEE).</li>
                        <li>Comercio Justo.</li>
                        <li>Producción Integrada.</li>
                        <li>Denominaciones de Origen Protegidas (DOP).</li>
                    </ul>
                </div>

                <div class="pl-6">
                    <p class="font-medium mt-4">10.3 Iniciativas Verdes</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Programa de compensación de emisiones de CO₂</li>
                        <li>Descuentos para productos con certificación ecológica.</li>
                        <li>Apoyo a pequeños productores locales</li>
                    </ul>
                </div>
            </section>

            {{-- Sección 11: Protección de Datos y Privacidad --}}
            <section class="border border-[#080303] bg-white shadow-sm rounded-lg p-4 mb-6">
                <h2 class="text-lg font-semibold mb-2">11. Protección de Datos y Privacidad</h2>

                <div class="pl-6">
                    <p class="font-medium mt-4">11.1 Información Recopilada</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Datos personales básicos para registro.</li>
                        <li>Información de contacto y facturación.</li>
                        <li>Historial de compras y preferencias.</li>
                        <li>Datos de geolocalización para entregas.</li>

                    </ul>
                </div>

                <div class="pl-6">
                    <p class="font-medium mt-4">11.2 Uso de la Información</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Facilitación de transacciones comerciales.</li>
                        <li>Mejora de la experiencia del usuario.</li>
                        <li>Comunicaciones comerciales (con consentimiento).</li>
                        <li>Análisis estadísticos agregados y anónimos.</li>

                    </ul>
                </div>

                <div class="pl-6">
                    <p class="font-medium mt-4">11.3 Derechos de Usuario</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Acceso a información personal almacenada.</li>
                        <li>Rectificación de datos incorrectos.</li>
                        <li>Eliminación de cuenta y datos asociados.</li>
                    </ul>
                </div>
            </section>

            {{-- Sección 12: Resolución de Conflictos --}}
            <section class="border border-[#080303] bg-white shadow-sm rounded-lg p-4 mb-6">
                <h2 class="text-lg font-semibold mb-2">12. Resolución de Conflictos</h2>

                <div class="pl-6">
                    <p class="font-medium mt-4">12.1 Mediación Interna</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Soluciones basadas en evidencias y buena fe.</li>
                        <li>Equipo especializado en resolución de disputas.</li>
                        <li>Proceso de mediación gratuito para usuarios.</li>
                        <li>Tiempo máximo de resolución: 7 días laborables.</li>

                    </ul>
                </div>

                <div class="pl-6">
                    <p class="font-medium mt-4">12.2 Arbitraje Externo</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Recurso a arbitraje comercial cuando sea necesario.</li>
                        <li>Costos compartidos entre las partes en conflicto.</li>
                        <li>Decisiones vinculantes para ambas partes.</li>
                        <li>Procedimiento según normativa comercial vigente.</li>
                    </ul>
                </div>
            </section>

            {{-- Sección 13: Responsabilidades y Limitaciones --}}
            <section class="border border-[#080303] bg-white shadow-sm rounded-lg p-4 mb-6">
                <h2 class="text-lg font-semibold mb-2">13. Responsabilidades y Limitaciones</h2>

                <div class="pl-6">
                    <p class="font-medium mt-4">13.1 Responsabilidades de Bancal</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Mantener la plataforma operativa y segura.</li>
                        <li>Facilitar comunicación entre compradores y vendedores con Bancal como parte intermediaria.
                        </li>
                        <li>Procesar pagos de forma segura.</li>
                        <li>Mediar en conflictos de buena fe.</li>

                    </ul>
                </div>

                <div class="pl-6">
                    <p class="font-medium mt-4">13.2 Limitaciones de Responsabilidad</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>No somos responsables de la calidad final de productos perecederos.</li>
                        <li>Limitación de responsabilidad por daños indirectos.</li>
                        <li>Exclusión de garantías implícitas más allá de las expresamente establecidas.</li>
                        <li>Responsabilidad máxima limitada al valor de la transacción.</li>
                    </ul>
                </div>

                <div class="pl-6">
                    <p class="font-medium mt-4">13.3 Responsabilidades del Usuario</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Proporcionar información veraz y actualizada.</li>
                        <li>Cumplir con las normativas sanitarias y comerciales aplicables.</li>
                        <li>Mantener la confidencialidad de credenciales de accesos.</li>
                        <li>Usar la plataforma de forma ética y legaln.</li>
                    </ul>
                </div>
            </section>
        

            {{-- Sección 14: Modificaciones y Actualizaciones --}}
            <section class="border border-[#080303] bg-white shadow-sm rounded-lg p-4 mb-6">
                <h2 class="text-lg font-semibold mb-2">14. Modificaciones y Actualizaciones</h2>

                <div class="pl-6">
                    <p class="font-medium mt-4">14.1 Cambios en las Políticas</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Derecho a modificar estas políticas con notificación previa.</li>
                        <li>Período de gracia de 30 días para adaptación.</li>
                        <li>Notificación por email y mensaje en la plataforma.</li>
                        <li>Historial de versiones disponible para consulta.</li>
                    </ul>
                </div>

                <div class="pl-6">
                    <p class="font-medium mt-4">14.2 Mejoras en la Plataforma</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Actualizaciones regulares de funcionalidades.</li>
                        <li>Incorporación de feedback de usuarios.</li>
                        <li>Adaptación a nuevas normativas legales.</li>
                        <li>Mejoras en seguridad y experiencia de usuario.</li>
                    </ul>
                </div>
            </section>
          
            {{-- Sección 15: Contacto y Soporte --}}
            <section class="border border-[#080303] bg-white shadow-sm rounded-lg p-4 mb-6">
                <h2 class="text-lg font-semibold mb-2">15. Contacto y Soporte</h2>

                <div class="pl-6">
                    <p class="font-medium mt-4">15.1 Atención al Cliente</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li><strong>Correo electrónico:</strong> <a href="mailto:soporte@bancal.es" class="text-blue-600 underline">soporte@bancal.es</a></li>
                        <li><strong>Teléfono:</strong> +34 123 456 789</li>
                    </ul>
                </div>
                
                <div class="pl-6">
                    <p class="font-medium mt-4">15.2 Soporte Técnico</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li><strong>Correo electrónico:</strong> <a href="mailto:soporte@bancal.es" class="text-blue-600 underline">tec@bancal.es</a></li>
                        <li>Futuros vídeotutoriales y otros vídeos de soporte.</li>
                        <li>Horario interrumpido (24/7) para incidencias críticas.</li>
                    </ul>
                </div>

    
            </section>

            {{-- Sección 16: Jurisdicción y Ley Aplicable --}}
            <section class="border border-[#080303] bg-white shadow-sm rounded-lg p-4 mb-6">
                <h2 class="text-lg font-semibold mb-2">16. Jurisdicción y Ley Aplicable</h2>

                <div class="pl-6">
                    Estas Políticas de Uso se rigen por la legislación española y europea aplicable. Cualquier disputa
                    será sometida a los tribunales competentes de Madrid, España, sin perjuicio del derecho de los
                    consumidores a acudir a los tribunales de su domicilio.
                </div>
            </section>
        </div>

        <div class="w-full bg-[#fdfdfd] border-b border-gray-200">
        <div class="max-w-4xl mx-auto px-6 py-6 text-center">
           <a href="{{ route('home') }}">
                <img src="{{ asset('static/img/iconFresa.svg') }}" alt="Logo" class="w-20 h-20 mx-auto mb-4" />
            </a>
            
            <p class="mt-1 text-sm text-gray-600">Al utilizar Bancal, confirmas que has leído, entendido y aceptado estos Términos de Uso.</p>
        </div>
    </div>
    </div>
</x-guest-layout>
