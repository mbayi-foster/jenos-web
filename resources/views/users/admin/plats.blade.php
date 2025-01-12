<x-app-layout>
    <x-slot name="title">
        Plats
    </x-slot>
    <x-slot name="mot">

        <div class="flex items-center justify-between mb-4">
            <p> La liste des plats</p>
            <a href="{{ route('plats.create') }}"
                class="py-8 px-8 text-white bg-orange-700 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800">
                <i class="fa-solid fa-plus"></i>
                <span class="sr-only">Icon description</span>
            </a>
        </div>
        @if (session('success'))
            <div id="alert-3"
                class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                role="alert">
                <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Info</span>
                <div class="ms-3 text-sm font-medium">
                    {{ session('success') }}
                </div>
                <button type="button"
                    class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
                    data-dismiss-target="#alert-3" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        @endif
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
                        Prix
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

            @foreach ($plats as $plat)
                <tr
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="w-4 p-4">
                        <div class="flex items-center">
                            {{ $loop->index + 1 }}
                        </div>
                    </td>
                    <th scope="row"
                        class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                        @if ($plat->status == true)
                            <div class="h-2.5 w-2.5 rounded-full bg-green-500 me-2"></div>
                        @else
                            <div class="h-2.5 w-2.5 rounded-full bg-red-500 me-2"></div>
                        @endif
                        <img class="w-10 h-10 rounded-full" src="{{ Storage::url($plat->photo) }}" alt="Jese image">
                        <div class="ps-3">
                            <div class="text-base font-semibold">{{ $plat->nom }} </div>
                            <div class="font-normal text-gray-500">{{ $plat->like }} <i class="fa-solid fa-heart"></i>
                            </div>
                        </div>
                    </th>
                    <td class="px-6 py-4">
                        <div class="items-center">
                            {{ $plat->prix }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="inline-flex rounded-md shadow-sm" role="group">
                            @if ($plat->status != true)
                                <button data-modal-target="popup-modal1" data-modal-toggle="popup-modal1" type="button"
                                    title="Modifier le status du plat" onclick="getStatus({{ $plat->id }})"
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-s-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                                    <i class="fa-solid fa-toggle-on"></i>
                                </button>
                            @else
                                <button data-modal-target="popup-modal2" data-modal-toggle="popup-modal2" type="button"
                                    title="Modifier le status du plat" onclick="getStatus({{ $plat->id }})"
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-s-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                                    <i class="fa-solid fa-toggle-off"></i>
                                </button>
                            @endif

                            <button onclick="getPlat({{ $plat->id }})" type="button" href="#"
                                title="Modifier l'plat" data-modal-target="authentication-modal"
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
                        Mettre à jour le plat
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
                    <form id="change" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                            <div class="sm:col-span-2">
                                <label for="nom"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nom*</label>
                                <input type="text" name="nom" id="nom"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Veillez nommer le plat" required="">
                                @error('nom')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="sm:col-span-2">
                                <label for="prix"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Prix*</label>
                                <input type="text" name="prix" id="prix"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Veillez nommer le plat" required="">
                                @error('prix')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="sm:col-span-2">

                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    for="photo">Photo</label>
                                <input name="photo"
                                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                    aria-describedby="file_input_help" id="photo" type="file"
                                    accept=".png, .jpg, .jpeg">
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PNG, JPG
                                    ou JPEG
                                    (MAX. 800x400px).</p>
                                @error('photo')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="sm:col-span-2">

                                <label for="details"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Détails
                                    du plat*</label>
                                <textarea id="details" rows="4" name="details"
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Détaillez le plat..." required></textarea>
                                @error('details')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
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



    <div id="popup-modal1" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                    class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="popup-modal1">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <h3 id="status" class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Voulez vous
                        vraiment activer ce plat</h3>
                    <button onclick="changeStatus()" id="non" data-modal-hide="popup-modal1" type="button"
                        class="text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:green-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Oui
                    </button>
                    <button data-modal-hide="popup-modal1" type="button"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Annuler</button>
                </div>
            </div>
        </div>
    </div>
    <div id="popup-modal2" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                    class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="popup-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <h3 id="status" class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Voulez vous
                        vraiment désactiver ce plat</h3>
                    <button onclick="changeStatus()" id="yes" data-modal-hide="popup-modal2" type="button"
                        class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Oui
                    </button>
                    <button data-modal-hide="popup-modal2" type="button"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Annuler</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        let idPlat

        function getPlat(id) {
            const nom = document.getElementById('nom')
            const prix = document.getElementById('prix')
            const details = document.getElementById('details')
            const photo = document.getElementById('photo')
            const form = document.getElementById('change')
            axios.get(`/api/plats/${id}`)
                .then(function(response) {
                    const plat = response.data
                    console.log(response.data);
                    nom.value = plat.nom
                    prix.value = plat.prix
                    details.value = plat.details
                    const dynamicAction = `plats/change/${id}`; // Remplace par l'URL désirée
                    form.action = dynamicAction;
                })
                .catch(function(error) {
                    // handle error
                    console.log(error);
                })
        }

        function getStatus(id) {
            idPlat = id
        }

        function changeStatus() {
            axios.get(`/api/plats/status/change/${idPlat}`)
                .then(function(response) {
                    location.reload();
                })
                .catch(function(error) {
                    // handle error
                    console.log(error);
                })
        }
    </script>
</x-app-layout>
