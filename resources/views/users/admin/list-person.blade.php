<x-app-layout>
    <x-slot name="title">
        Personnels
    </x-slot>
    <x-slot name="mot">
        La liste des personnels, livreurs, gérants et administrateurs.
    </x-slot>
    <table id="search-table">
        <thead>
            <tr>
                <th>
                    <span class="flex items-center">
                        #
                    </span>
                </th>
                <th>
                    <span class="flex items-center">
                        Nom
                    </span>
                </th>
                <th>
                    <span class="flex items-center">
                        Rôles
                    </span>
                </th>
                <th>
                    <span class="flex items-center">
                        Actions
                    </span>
                </th>
            </tr>
        </thead>
        <tbody>

            @foreach ($users as $user)
                <tr
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="w-4 p-4">
                        <div class="flex items-center">
                            {{ $loop->index + 1 }}
                        </div>
                    </td>
                    <th scope="row"
                        class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                        @if ($user->status == true)
                            <div class="h-2.5 w-2.5 rounded-full bg-green-500 me-2"></div>
                        @else
                            <div class="h-2.5 w-2.5 rounded-full bg-red-500 me-2"></div>
                        @endif
                        <img class="w-10 h-10 rounded-full" src="assets/img/logo.png" alt="Jese image">
                        <div class="ps-3">
                            <div class="text-base font-semibold">{{ $user->prenom }} {{ $user->nom }} </div>
                            <div class="font-normal text-gray-500">{{ $user->email }}</div>
                            <div class="font-normal text-gray-500">{{ $user->phone }}</div>
                        </div>
                    </th>
                    <td class="px-6 py-4">
                        <div class="items-center">
                            @foreach ($user->roles as $item)
                                <p>- {{$item['nom']}}</p>
                            @endforeach
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="inline-flex rounded-md shadow-sm" role="group">
                            <button data-modal-target="popup-modal" data-modal-toggle="popup-modal" type="button" title="Modifier le status du personnel" href="#"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-s-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white"
                                @if ($user->status != true) >
                                    <i class="fa-solid fa-toggle-on"></i>
                                @else
                                >
                                    <i class="fa-solid fa-toggle-off"></i> @endif
                                </button>
                                <button onclick="getUser({{ $user->id }})" type="button" href="#"
                                    title="Modifier le personnel" data-modal-target="authentication-modal"
                                    data-modal-toggle="authentication-modal"
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-e-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                                    <i class="fa-solid fa-circle-info"></i>
                                </button>
                        </div>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div id="authentication-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Mettre à jour le personnel
                    </h3>
                    <button type="button"
                        class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="authentication-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <form method="post" id="change">
                        @csrf
                        <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                            <div class="sm:col-span-2">
                                <label for="email"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                <input type="email" name="email" id="email" disabled
                                    class="bg-gray-200 text-gray-500 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Veillez entrer l'adresse email du personnel" required="">
                            </div>
                            <div class="w-full">
                                <label for="nom"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nom</label>
                                <input type="text" name="nom" id="nom"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Nom du personnel" required="">
                            </div>
                            <div class="w-full">
                                <label for="prenom"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Prénom</label>
                                <input type="text" name="prenom" id="prenom"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Prénom du personnel" required="">
                            </div>
                            <div>
                                <label for="phone"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Téléphone</label>
                                <input type="number" name="phone" id="phone"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Le numéro de téléphone" required="">
                            </div>
                            <div>
                                <label for="countries_multiple"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Choisir les
                                    rôles</label>
                                @foreach ($roles as $role)
                                    <div class="flex items-center mb-4">
                                        <input id="role{{ $loop->index }}" type="checkbox" name="roles[]"
                                            value="{{ $role->id }}"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="default-checkbox"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $role->nom }}</label>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                        <div class="flex justify-center items-center">
                            <button type="submit"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mt-4 me-4">Enregistrer</button>
                            <button type="reset"
                                class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 mt-4">Reset</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    

    
    <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete this product?</h3>
                    <button data-modal-hide="popup-modal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Yes, I'm sure
                    </button>
                    <button data-modal-hide="popup-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No, cancel</button>
                </div>
            </div>
        </div>
    </div>
    

    <script>
        let nom = document.getElementById('nom')
        let prenom = document.getElementById('prenom')
        let email = document.getElementById('email')
        let phone = document.getElementById('phone')
        let form = document.getElementById('change')

        function getUser(id) {
            axios.get(`/api/users/${id}`)
                .then(function(response) {
                    const user = response.data
                    console.log(response.data);
                    nom.value = user.nom
                    prenom.value = user.prenom
                    email.value = user.email
                    phone.value = user.phone
                    const dynamicAction = `users/change/${id}`; // Remplace par l'URL désirée
                    form.action = dynamicAction;

                })
                .catch(function(error) {
                    // handle error
                    console.log(error);
                })
        }
    </script>
</x-app-layout>
