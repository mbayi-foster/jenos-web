<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="flex items-center justify-center mx-auto my-5 px-12">
            <div class="flex flex-col md:flex-row w-full max-w-4xl bg-gray-200 overflow-hidden items-center">
                <div class="md:w-1/2 w-full">

                    <figure class="relative max-w-sm transition-all duration-300 cursor-pointer filter ">
                        <a href="#">
                            <img class="w-full h-full object-cover" src="@/assets/img/jp.jpg" alt="Bonnie image" />
                        </a>
                        <figcaption class="absolute px-4 text-lg text-white left-4 top-40">
                            <h1
                                class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-white md:text-5xl lg:text-6xl dark:text-white">Welcom Back !</h1>
                        </figcaption>
                    </figure>


                </div>
                <div class="md:w-1/2 p-8 w-full">
                    <div>
                        <!--     <a href="/">
                            <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                        </a> -->
                    </div>
                    <h2 class="text-2xl font-bold mb-6">Connectez vous</h2>
                    <form method="POST">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700" for="email">Email</label>
                            <input type="email" id="email" name="email"
                                class="mt-1 block w-full border border-gray-300 rounded-md p-2 rounded-full" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700" for="password">Mot de passe</label>
                            <input type="password" id="password" name="password"
                                class="mt-1 block w-full border border-gray-300 rounded-md p-2 rounded-full" required>
                        </div>
                        <div class="flex items-center mb-4">
                            <input type="checkbox" id="remember" class="mr-2 rounded-full" name="remember">
                            <label for="remember" class="text-sm text-gray-600">Rester connecté</label>
                        </div>
                        <button type="submit" class="rounded-full w-full bg-orange-500 text-white font-bold py-2">Se
                            connecter</button>
                        <p class="text-sm mt-4 text-gray-600">Mot de passe oublier ? <a href="#"
                                class="text-blue-500">Contacter l'administrateur</a></p>
                    </form>
                </div>

            </div>
        </div>
    </div>
</template>