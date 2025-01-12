<x-app-layout>
    <x-slot name="title">
        Profile
    </x-slot>
    <x-slot name="mot">

        <div class="flex items-center justify-between mb-4">
            Mon profile
        </div>
    </x-slot>
    <div class="container mx-auto p-6">
        <div class="rounded-lg p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Détails de l'utilisateur -->
            <div
                class="w-full max-w-sm bg-white border border-orange-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <div class="flex flex-col items-center pb-10">
                    <img class="w-48 h-48 mb-3 rounded-full shadow-lg" src="assets/img/index.png" alt="Bonnie image" />
                    <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">Bonnie Green</h5>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Visual Designer</span>
                    <div class="flex mt-4 md:mt-6">
                        <a href="#"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add
                            friend</a>
                        <a href="#"
                            class="py-2 px-4 ms-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Message</a>
                    </div>
                </div>
            </div>
            <!-- Formulaire de mise à jour -->
            <div class="p-4">
                <h2 class="text-xl font-bold mb-4">Modifier le Profil</h2>
                <form action="#" method="POST">
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700">Nom</label>
                        <input type="text" id="name" name="name"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded" required>
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700">Email</label>
                        <input type="email" id="email" name="email"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded" required>
                    </div>
                    <div class="mb-4">
                        <label for="phone" class="block text-gray-700">Téléphone</label>
                        <input type="tel" id="phone" name="phone"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded" required>
                    </div>
                    <div class="mb-6">
                        <label for="address" class="block text-gray-700">Adresse</label>
                        <input type="text" id="address" name="address"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded">
                    </div>
                    <button type="submit"
                        class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">Sauvegarder</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
