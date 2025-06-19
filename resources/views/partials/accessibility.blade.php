<!-- Widget de accesibilidad -->
<div x-data="accessibilityWidget()" x-init="init()" x-cloak
    class="fixed right-0 top-[70%] transform -translate-y-1/2 z-50 flex items-center">

    <!-- Panel deslizable -->
    <div x-show="open" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-x-full" x-transition:enter-end="opacity-100 translate-x-0"
        x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 translate-x-full"
        class="bg-white rounded shadow p-4 w-[300px] max-w-lg mx-auto fixed-font"
        style="font-family: 'DynaPuff_Regular', sans-serif;" @click.away="open = false">

        <button @click="increaseFont()"
            class="w-full mb-1 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition flex items-center justify-center">
            <span class="hidden sm:inline">Aumentar tamaño letra</span>
            <span class="inline sm:hidden">
                <i class="fa-solid fa-plus"></i>
                <i class="fa-solid fa-font"></i>
            </span>
        </button>

        <button @click="decreaseFont()"
            class="w-full mb-1 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition flex items-center justify-center">
            <span class="hidden sm:inline">Reducir tamaño letra</span>
            <span class="inline sm:hidden">
                <i class="fa-solid fa-minus"></i>
                <i class="fa-solid fa-font"></i>
            </span>
        </button>

        <button @click="toggleLegibleFont()"
            :class="legibleFontActive ? 'bg-indigo-600 text-white' : 'bg-gray-300 text-gray-900'"
            class="w-full mb-1 py-1 rounded transition">
            Hacer letra legible
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

    <!-- Botón de apertura/cierre separado del panel -->
    <button @click="toggleOpen()" @mouseenter="handleHover(true)" @mouseleave="handleHover(false)"
        :class="largeCursor ? 'large-cursor' : ''"
        class="ml-2 bg-blue-600 text-white p-3 rounded-l shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400"
        aria-label="Abrir opciones de accesibilidad">
        <i class="fas fa-universal-access"></i>
    </button>
</div>





<script>
    function accessibilityWidget() {
        return {
            open: false,
            baseFontSize: 16,
            currentFontSize: 16,
            legibleFontActive: false,
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

                this.legibleFontActive = localStorage.getItem('a11y-legibleFont') === 'true';
                if (this.legibleFontActive) {
                    document.body.style.fontFamily = "'Montserrat', Arial, sans-serif";
                }

            },

            toggleOpen() {
                this.open = !this.open;
            },

            increaseFont() {
                const maxSize = this.baseFontSize + (2 * 3);
                if (this.currentFontSize < maxSize) {
                    this.currentFontSize += 2;
                    document.documentElement.style.fontSize = this.currentFontSize + 'px';
                    localStorage.setItem('a11y-fontSize', this.currentFontSize);
                }
            },

            decreaseFont() {
                const minSize = this.baseFontSize - (2 * 3);
                if (this.currentFontSize > minSize) {
                    this.currentFontSize -= 2;
                    document.documentElement.style.fontSize = this.currentFontSize + 'px';
                    localStorage.setItem('a11y-fontSize', this.currentFontSize);
                }
            },

            toggleLegibleFont() {
                this.legibleFontActive = !this.legibleFontActive;
                if (this.legibleFontActive) {
                    document.body.style.fontFamily = "'Montserrat', Arial, sans-serif";
                } else {
                    document.body.style.fontFamily = "'DynaPuff_Regular', sans-serif";
                }
                localStorage.setItem('a11y-legibleFont', this.legibleFontActive);
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
                localStorage.removeItem('a11y-legibleFont');

                this.currentFontSize = this.baseFontSize;
                this.highContrast = false;
                this.highlightLinks = false;
                this.largeCursor = false;
                this.legibleFontActive = false;

                document.documentElement.style.fontSize = this.baseFontSize + 'px';
                document.documentElement.classList.remove('high-contrast', 'highlight-links', 'large-cursor');
                document.body.style.fontFamily = "'DynaPuff_Regular', sans-serif";
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

    .fixed-font {
    font-size: 16px !important;
}

</style>
