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
                    <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white"> {{ Auth::user()->prenom }}
                        {{ Auth::user()->nom }}</h5>
                    <span class="text-sm text-gray-500 dark:text-gray-400"> {{ Auth::user()->email }}</span>
                    <span class="text-sm text-gray-500 dark:text-gray-400"> 0{{ Auth::user()->phone }}</span>
                    <ul class="space-y-4 text-left text-gray-500 dark:text-gray-400">
                        @foreach (Auth::user()->roles as $role)
                            <li class="flex items-center space-x-3 rtl:space-x-reverse">
                                <svg class="flex-shrink-0 w-3.5 h-3.5 text-green-500 dark:text-green-400"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 16 12">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5" />
                                </svg>
                                <span> {{ $role->nom }}</span>
                            </li>
                        @endforeach

                    </ul>

                    {{--      <div class="flex mt-4 md:mt-6">
                        <a href="#"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add
                            friend</a>
                        <a href="#"
                            class="py-2 px-4 ms-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Message</a>
                    </div> --}}
                </div>
            </div>
            <!-- Formulaire de mise à jour -->
            <div class="p-4">
                <h2 class="text-xl font-bold mb-4">Modifier le Profil</h2>
                <form action="#" method="POST">
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700">Nom</label>
                        <input type="text" id="name" name="name"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded" required
                            value="{{ Auth::user()->nom }}">
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700">Email</label>
                        <input type="email" id="email" name="email"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded" required
                            value="{{ Auth::user()->email }}">
                    </div>
                    <div class="mb-4">
                        <label for="phone" class="block text-gray-700">Téléphone</label>
                        <input type="tel" id="phone" name="phone"
                            class="mt-1 block w-full p-2 border border-gray-300 rounded" required
                            value="{{ Auth::user()->phone }}">
                    </div>
                    <button type="submit"
                        class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">Sauvegarder</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
