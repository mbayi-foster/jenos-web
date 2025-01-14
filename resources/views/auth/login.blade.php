<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    {{--    <div class="container mx-auto px-12">
        <div class="px-0 py-4 border border-gray-200 flex flex-col md:flex-row justify-center items-center">
            <!-- Détails de l'utilisateur -->
            <div class="border border-dark w-full max-w-sm flex flex-col items-center">
                <img class="h-auto max-w-full shadow-lg" src="assets/img/jp.jpg" alt="Bonnie image" />
            </div>
            <!-- Formulaire de mise à jour -->
            <div class="w-full max-w-sm border border-dark">
                <form class="w-full mx-auto" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-5">
                        <label for="email"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Adresse
                            mail</label>
                        <input type="email" id="email" name="email"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Veillez entrer votre adresse email" required />
                    </div>
                    <div class="mb-5">
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mot
                            de
                            passe</label>
                        <input type="password" id="password" name="password"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Veillez entrer votre mot de passe" required />
                    </div>
                    <div class="flex items-start mb-5">
                        <div class="flex items-center h-5">
                            <input id="remember" type="checkbox" value="" name="remember"
                                class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800"
                                required />
                        </div>
                        <label for="remember" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Rester
                            connecté</label>
                    </div>
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                </form>
            </div>
        </div>
    </div> --}}


    <div class="flex items-center justify-center mx-auto my-5 px-12">
        <div class="flex flex-col md:flex-row w-full max-w-4xl bg-gray-200 overflow-hidden items-center">
            <div class="md:w-1/2 w-full">
                <img class="w-full h-full object-cover" src="assets/img/jp.jpg" alt="Bonnie image" />
            </div>
            <div class="md:w-1/2 p-8 w-full">
                <div>
                    <a href="/">
                        <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                    </a>
                </div>
                <h2 class="text-2xl font-bold mb-6">Connectez vous</h2>
                @error('error')
                    <p class="text-sm text-red-600 dark:text-white">{{ $message }}</p>
                @enderror
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700" for="email">Email</label>
                        <input type="email" id="email" name="email"
                            class="mt-1 block w-full border border-gray-300 rounded-md p-2" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700" for="password">Mot de passe</label>
                        <input type="password" id="password" name="password"
                            class="mt-1 block w-full border border-gray-300 rounded-md p-2" required>
                    </div>
                    <div class="flex items-center mb-4">
                        <input type="checkbox" id="remember" class="mr-2" name="remember">
                        <label for="remember" class="text-sm text-gray-600">Rester connecté</label>
                    </div>
                    <button type="submit" class="w-full bg-orange-500 text-white font-bold py-2 rounded">Se
                        connecter</button>
                    <p class="text-sm mt-4 text-gray-600">Mot de passe oublier ? <a href="#"
                            class="text-blue-500">Contacter l'administrateur</a></p>
                </form>
            </div>

        </div>
    </div>

    </div>
</x-guest-layout>
