<x-app-layout>
    <x-slot name="header">
        <main class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-10" style="background-image: url('{{ asset('Recursos/fondoazul.jpg') }}'); height:100%; weight:100%;">
            <div class="bg-white overflow-hidden shadow sm:rounded-lg flex">
                <div class="p-6 w-2/3 bg-white bg-opacity-75">
                    <h4 class="text-2xl font-semibold text-gray-800 mb-4">Bienvenido a Wall Inventary</h4>
                    <p class="text-lg text-gray-700 leading-relaxed mb-4">
                        Nuestro sistema de inventario está diseñado para ayudarle a gestionar eficientemente sus productos y recursos. Con una interfaz amigable e intuitiva, podrá llevar un control detallado de todas sus compras/ventas.
                    </p>
                    <p class="text-lg text-gray-700 leading-relaxed mb-4">
                        En Wall_Inventary, facilitamos la gestión de su inventario mediante procesos bien definidos que aseguran la eficiencia y la precisión. A continuación, describimos los principales procesos que forman parte de nuestro sistema de gestión de inventario.
                    </p>
                    <h4 class="text-2xl font-semibold text-gray-800 mb-4">Configuración Inicial</h4>
                    <p class="text-lg text-gray-700 leading-relaxed mb-4">
                        Configurar la información básica del sistema de gestión de inventario, como los detalles del almacén o bodega, los productos y las ubicaciones de almacenamiento.
                    </p>
                    <h4 class="text-2xl font-semibold text-gray-800 mb-4">Ingreso de productos</h4>
                    <p class="text-lg text-gray-700 leading-relaxed mb-4">
                        Ingresar los productos al sistema de gestión de inventario con información detallada como nombre del producto, descripción, categoría, unidad de medida y precios.
                    </p>
                    <h4 class="text-2xl font-semibold text-gray-800 mb-4">Actualización de inventario</h4>
                    <p class="text-lg text-gray-700 leading-relaxed mb-4">
                        Actualizar el inventario mediante el registro de entradas y salidas de productos del almacén. Esto puede incluir la entrada de facturas de compra, devoluciones de clientes, transferencias entre ubicaciones y ajustes de inventario.
                    </p>
                    <h4 class="text-2xl font-semibold text-gray-800 mb-4">Monitoreo del inventario</h4>
                    <p class="text-lg text-gray-700 leading-relaxed mb-4">
                        Monitorear continuamente el inventario para asegurarse de que los niveles de stock se mantengan dentro de los límites preestablecidos y evitar la escasez de productos.
                    </p>
                    <h4 class="text-2xl font-semibold text-gray-800 mb-4">Análisis de inventario</h4>
                    <p class="text-lg text-gray-700 leading-relaxed mb-4">
                        Realizar un análisis periódico del inventario para identificar productos con baja rotación, productos con alta demanda y productos con exceso de inventario. Esto ayudará a tomar decisiones informadas sobre compras, promociones y descuentos.
                    </p>
                    <h4 class="text-2xl font-semibold text-gray-800 mb-4">Generación de informes</h4>
                    <p class="text-lg text-gray-700 leading-relaxed mb-4">
                        Generar informes de inventario en tiempo real, como informes de existencias, informes de movimiento de productos, informes de pedidos pendientes y otros informes que sean relevantes para la gestión del inventario.
                    </p>
                    <h4 class="text-2xl font-semibold text-gray-800 mb-4">Mejora continua</h4>
                    <p class="text-lg text-gray-700 leading-relaxed mb-4">
                        Continuar mejorando el sistema de gestión de inventario a través de la incorporación de tecnología avanzada, la capacitación del personal, la optimización de procesos y la implementación de prácticas de gestión del inventario basadas en las mejores prácticas de la industria.
                    </p>
                    <p class="text-lg text-gray-700 leading-relaxed">
                        Con estos procesos, Wall_Inventary asegura una gestión eficiente y efectiva de su inventario, permitiéndole centrarse en hacer crecer su negocio.
                    </p>
                </div>
                <div class="w-1/3 p-6">
                    <img src="{{ asset('Recursos/logonegro.png') }}" class="w-full h-auto">
                </div>
            </div>
        </main>
    </x-slot>
</x-app-layout>
