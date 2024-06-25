
<x-app-layout>
    <x-slot name="header">
        <main class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-10" style="background-image: url('{{ asset('Recursos/fondodorado.jpg') }}'); height:100%; weight:100%;">
            <div class="bg-white overflow-hidden shadow sm:rounded-lg flex">
                <div class="p-6 w-2/3 bg-white bg-opacity-75">
                    <h4 class="text-2xl font-semibold text-gray-800 mb-4">Tutorial uso Wall Inventary</h4>
                    <p class="text-lg text-gray-700 leading-relaxed mb-4">
                        ¡Aqui vas a encontrar de manera detallada el cómo funciona nuestra plataforma!
                    </p>
                    
                    <h4 class="text-2xl font-semibold text-gray-800 mb-4">¡Acciones que podrá hacer el Administrador!</h4>
                    <p class="text-lg text-gray-700 leading-relaxed mb-4">
                        Este no tendrá que hacer su respectivo registro en la plataforma ya que su usuario debe estar registrado en la base de datos de manera predeterminada.
                    </p>
                    <p class="text-lg text-gray-700 leading-relaxed mb-4">
                        Este a la hora de loguearse podrá visualizar el panel del administrador. En este se podrán visualizar las pestañas de Inicio, Productos, Proveedores, Categorías, Ventas y Compras.
                    </p>
                    <p class="text-lg text-gray-700 leading-relaxed mb-4">
                        El administrador podrá ingresar categorías, proveedores y productos, seguido de que puede realizar las compras y ventas.
                    </p>
                    <p class="text-lg text-gray-700 leading-relaxed mb-4">
                       !RECUERDA¡ Primero debes ingresar una categoria, luego un proveedor y por ultimo un producto para que no tengas ningun inconveniente.
                    </p>
                    <p class="text-lg text-gray-700 leading-relaxed mb-4">
                        El administrador tendrá una vista en la cual va a tener una lista de los encargados que estén registrados en la plataforma y podrá desactivarlos o activarlos si llegase a haber algún inconveniente.
                    </p>
                    
                    <h4 class="text-2xl font-semibold text-gray-800 mb-4">¡Acciones que podrá hacer el Encargado!</h4>
                    <p class="text-lg text-gray-700 leading-relaxed mb-4">
                        Este podrá registrarse ingresando unos datos básicos.
                    </p>
                    <p class="text-lg text-gray-700 leading-relaxed mb-4">
                        A la hora de completar el registro automáticamente ingresará al panel del Encargado. En este se podrán visualizar las pestañas de Inicio, Productos, Proveedores, Categorías, Ventas y Compras.
                    </p>
                    <p class="text-lg text-gray-700 leading-relaxed mb-4">
                        El encargado tendrá dos opciones habilitadas las cuales son las Ventas y Compras, el únicamente podrá visualizar los productos, proveedores y categorías que haya agregado el administrador.
                    </p>
                    
                </div>
                <div class="w-1/3 p-6">
                    <img src="{{ asset('Recursos/logonegro.png') }}" class="w-full h-auto">
                </div>
            </div>
        </main>
    </x-slot>
</x-app-layout>
