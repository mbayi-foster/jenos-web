<x-app-layout>
    <x-slot name="title">
        Tableau de bord
    </x-slot>
    <x-slot name="mot">

        <div class="flex items-center justify-between mb-4">
            <p>Tableau de bord adminstratif</p>
        </div>
    </x-slot>
    <div class="container mx-auto">
        <div class="grid grid-cols-4 grid-cols-4 gap-4 ">
            <div href="#"
                class="flex flex-row justify-between align-center p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <div class="">
                    <i class="fa-solid fa-toggle-off"></i>
                </div>
                <div>
                    <p class="text-center mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">120</p>
                    <p class="text-center font-normal text-xl text-gray-700 dark:text-gray-400">Utilisateurs</p>

                </div>
            </div>
            <a href="#"
                class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

                <p class="text-center mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">120</p>
                <p class="text-center font-normal text-xl text-gray-700 dark:text-gray-400">Plats disponible</p>
            </a>
            <a href="#"
                class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

                <p class="text-center mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">120</p>
                <p class="text-center font-normal text-xl text-gray-700 dark:text-gray-400">Menus disponible</p>
            </a>
            <a href="#"
                class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

                <p class="text-center mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">120</p>
                <p class="text-center font-normal text-xl text-gray-700 dark:text-gray-400">zones sous couvert</p>
            </a>
        </div>
    </div>
</x-app-layout>
