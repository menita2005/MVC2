<x-app-layout>
    <x-slot name="header">  
        <main class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8" style="background-image: url('{{ asset('Recursos/fondodorado.jpg') }}'); background-size: cover; background-position: center;">
            <div class="bg-white overflow-hidden shadow sm:rounded-lg flex">
                <div class="p-6 w-2/3 bg-white bg-opacity-75">
                    <h4 class="text-2xl font-semibold text-gray-800 mb-4">Bienvenido Admin ⭐</h4>
                    
                    <!-- Información del administrador y funciones -->
                    <p class="text-lg text-gray-600">Como administrador, tienes acceso a todas las funciones avanzadas del sistema. Puedes gestionar usuarios, configurar permisos, y supervisar el contenido del sitio.</p>
                    
                    <h5 class="text-xl font-semibold text-gray-700 mt-6">Funciones principales:</h5>
                    <ul class="list-disc list-inside text-gray-600">
                        <li>Gestión de usuarios y roles.</li>
                        <li>Configuración de permisos y accesos.</li>
                        <li>Supervisión de actividades y registros.</li>
                        <li>Personalización y ajustes del sitio.</li>
                        </ul>
                        <br>
                    <ul class="list-disc list-inside text-red-200">
                    <li><a href="https://expo.dev/accounts/nicolleee07/projects/myappmovil/builds/7ed45a80-5819-4d9e-94dc-4530831b7b37">--> Aplicacion Movil para Supervisar registros <--</a></li>
                    <br>
                        <li><img src="{{ asset('Recursos/qrapp.png') }}"  class="w-1/2 h-auto" alt="Logo"></li>
                </ul>
                </div>
                <div class="w-1/3 pl-6">
                    <img src="{{ asset('Recursos/logonegro.png') }}"  class="w-full h-auto pl-6" alt="Logo">
                </div>
                
            </div>
        </main>
        </x-slot>
    </x-admin-layout>
