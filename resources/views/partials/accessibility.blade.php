<!-- Botón para abrir/cerrar el widget -->
<div x-data="accessibilityWidget()" x-init="init()"
    class="fixed right-0 top-[80%] transform -translate-y-1/2 z-50 flex flex-col items-end">
    <!-- Botón flotante -->
    <button @click="toggleOpen()" @mouseenter="handleHover(true)" @mouseleave="handleHover(false)"
        :class="largeCursor ? 'large-cursor' : ''"
        class="bg-blue-600 text-white p-3 rounded-l shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400"
        aria-label="Abrir opciones de accesibilidad">
        <i class="fas fa-universal-access"></i>
    </button>

    <!-- Panel deslizable -->
    <div x-show="open" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-x-full" x-transition:enter-end="opacity-100 translate-x-0"
        x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 translate-x-full"
        class="bg-white shadow-lg rounded-l p-4 w-48 mt-2 flex flex-col font-sans"
        style="font-family: 'DynaPuff_Regular', sans-serif;" @click.away="open = false">

        <button @click="increaseFont()"
            class="w-full mb-1 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
            Aumentar letra
        </button>

        <button @click="decreaseFont()"
            class="w-full mb-1 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
            Disminuir letra
        </button>

        <button @click="toggleContrast()"
            :class="highContrast ? 'bg-yellow-600 text-white' : 'bg-gray-300 text-gray-900'"
            class="w-full mb-1 py-1 rounded transition">
            Contraste alto
        </button>

        <button @click="toggleHighlightLinks()"
            :class="highlightLinks ? 'bg-green-600 text-white' : 'bg-gray-300 text-gray-900'"
            class="w-full mb-1 py-1 rounded transition">
            Resaltar enlaces
        </button>

        <button @click="toggleLargeCursor()"
            :class="largeCursor ? 'bg-purple-600 text-white' : 'bg-gray-300 text-gray-900'"
            class="w-full mb-1 py-1 rounded transition">
            Cursor grande
        </button>

        <button @click="resetDefaults()" class="w-full py-1 bg-red-600 text-white rounded hover:bg-red-700 transition">
            Restablecer valores
        </button>

    </div>
</div>

<script>
    function accessibilityWidget() {
        return {
            open: false,
            baseFontSize: 16,
            currentFontSize: 16,
            highContrast: false,
            highlightLinks: false,
            largeCursor: false,
            hoverOnToggleButton: false, // para controlar hover

            init() {
                // Recuperar fontSize
                this.currentFontSize = parseInt(localStorage.getItem('a11y-fontSize')) || this.baseFontSize;
                document.documentElement.style.fontSize = this.currentFontSize + 'px';

                // Recuperar highContrast
                this.highContrast = localStorage.getItem('a11y-highContrast') === 'true';
                if (this.highContrast) {
                    document.documentElement.classList.add('high-contrast');
                }

                // Recuperar highlightLinks
                this.highlightLinks = localStorage.getItem('a11y-highlightLinks') === 'true';
                if (this.highlightLinks) {
                    document.documentElement.classList.add('highlight-links');
                }

                // Recuperar largeCursor
                this.largeCursor = localStorage.getItem('a11y-largeCursor') === 'true';
                if (this.largeCursor) {
                    document.documentElement.classList.add('large-cursor');
                }
            },

            toggleOpen() {
                this.open = !this.open;
            },

            increaseFont() {
                this.currentFontSize += 2;
                document.documentElement.style.fontSize = this.currentFontSize + 'px';
                localStorage.setItem('a11y-fontSize', this.currentFontSize);
            },

            decreaseFont() {
                if (this.currentFontSize > 10) {
                    this.currentFontSize -= 2;
                    document.documentElement.style.fontSize = this.currentFontSize + 'px';
                    localStorage.setItem('a11y-fontSize', this.currentFontSize);
                }
            },

            toggleContrast() {
                this.highContrast = !this.highContrast;
                if (this.highContrast) {
                    document.documentElement.classList.add('high-contrast');
                } else {
                    document.documentElement.classList.remove('high-contrast');
                }
                localStorage.setItem('a11y-highContrast', this.highContrast);
            },

            toggleHighlightLinks() {
                this.highlightLinks = !this.highlightLinks;
                if (this.highlightLinks) {
                    document.documentElement.classList.add('highlight-links');
                } else {
                    document.documentElement.classList.remove('highlight-links');
                }
                localStorage.setItem('a11y-highlightLinks', this.highlightLinks);
            },

            toggleLargeCursor() {
                this.largeCursor = !this.largeCursor;
                if (this.largeCursor) {
                    document.documentElement.classList.add('large-cursor');
                } else {
                    document.documentElement.classList.remove('large-cursor');
                }
                localStorage.setItem('a11y-largeCursor', this.largeCursor);
            },

            resetDefaults() {
                localStorage.removeItem('a11y-fontSize');
                localStorage.removeItem('a11y-highContrast');
                localStorage.removeItem('a11y-highlightLinks');
                localStorage.removeItem('a11y-largeCursor');

                this.currentFontSize = this.baseFontSize;
                this.highContrast = false;
                this.highlightLinks = false;
                this.largeCursor = false;

                document.documentElement.style.fontSize = this.baseFontSize + 'px';
                document.documentElement.classList.remove('high-contrast', 'highlight-links', 'large-cursor');
            },

            handleHover(hovering) {
                this.hoverOnToggleButton = hovering;
                if (this.largeCursor) {
                    // Al hacer hover sobre el botón flotante, mantenemos cursor grande en todo el documento
                    document.documentElement.classList.add('large-cursor');
                }
            }
        }
    }
</script>

<style>
    /* Para body: min-height un poco mayor */
    body {
        min-height: 110vh;
    }

    /* Contraste alto */
    .high-contrast {
        background-color: black !important;
        color: yellow !important;
    }

    .high-contrast a {
        color: cyan !important;
    }

    /* Resaltar enlaces */
    .highlight-links a {
        outline: 3px solid orange;
        background-color: #fff5cc;
        color: #cc6600 !important;
        font-weight: bold;
    }

    /* Cursor grande */
    .large-cursor,
    .large-cursor * {
        cursor: url('static/img/puntero.accesible.svg') 0 0, auto !important;
    }
</style>
