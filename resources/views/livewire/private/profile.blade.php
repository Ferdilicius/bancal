@section('title', 'Mi perfil')

<div class="max-w-6xl mx-auto px-2 sm:px-6 mb-10" x-cloak>
    <div class="bg-white shadow-xl rounded-3xl p-4 sm:p-10">
        <h1 class="text-2xl sm:text-3xl font-extrabold mb-8 sm:mb-10 text-gray-900 flex items-center justify-between">
            Mi perfil
            <a href="{{ route('public.profile', ['user' => Auth::user()->id]) }}"
                class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded-lg shadow hover:bg-green-700 transition ml-4">
                Ver perfil público
            </a>
        </h1>

        <!-- Tabs -->
        <div x-data="{
            tab: localStorage.getItem('perfilTab') || 'productos',
            setTab(value) {
                this.tab = value;
                localStorage.setItem('perfilTab', value);
            }
        }">
            <!-- Tab Navigation -->
            <div class="flex flex-wrap border-b mb-6 sm:mb-8 gap-2 sm:gap-0">
                <template
                    x-for="tabItem in [
                            { key: 'productos', label: 'Productos' },
                            { key: 'bancales', label: 'Bancales' },
                            { key: 'metodos_pago', label: 'Métodos de pago' },
                            { key: 'direccion_envio', label: 'Dirección de envío' },
                            { key: 'ventas', label: 'Ventas' },
                            { key: 'compras', label: 'Compras' }
                        ]"
                    :key="tabItem.key">
                    <button
                        class="flex-1 min-w-[120px] px-3 sm:px-6 py-2 sm:py-3 -mb-px font-semibold text-sm sm:text-base focus:outline-none transition border-b-2"
                        :class="tab === tabItem.key ? 'border-green-600 text-green-700' :
                            'border-transparent text-gray-500 hover:text-green-600'"
                        @click="setTab(tabItem.key)" x-text="tabItem.label">
                    </button>
                </template>
            </div>

            <div x-show="tab === 'productos'" x-cloak>
                <livewire:private.tabs.products />
            </div>
            <div x-show="tab === 'bancales'" x-cloak>
                <livewire:private.tabs.addresses />
            </div>
            <div x-show="tab === 'metodos_pago'" x-cloak>
                <livewire:private.tabs.payment-methods />
            </div>
            <div x-show="tab === 'direccion_envio'" x-cloak>
                <livewire:private.tabs.shipping-addresses />
            </div>

            <div x-show="tab === 'compras'" x-cloak>
                <livewire:private.tabs.purchases />
            </div>
            <div x-show="tab === 'ventas'" x-cloak>
                <livewire:private.tabs.sales />
            </div>
        </div>
    </div>
</div>
