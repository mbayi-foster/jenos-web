<x-app-layout>
    <x-slot name="title">
        Zones
    </x-slot>
    <x-slot name="mot">

        <div class="flex items-center justify-between mb-4">
            <p> Liste des zones de travaille</p>
            <a href="{{ route('zones.create') }}"
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
                        Gérant
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

            @foreach ($zones as $zone)
                <tr>
                    <td class="w-4 p-4">
                        <div class="flex items-center">
                            {{ $loop->index + 1 }}
                        </div>
                    </td>
                    <td>
                        <div class="flex items-center">
                            {{ $zone->nom }}
                        </div>
                    </td>
                    <td>
                        <div class="flex items-center">
                            {{ $zone->chefs->prenom }} {{ $zone->chefs->nom }}
                        </div>
                    </td>
                    <td>
                        <div class="inline-flex rounded-md shadow-sm" role="group">
                            <button data-modal-target="popup-modal" data-modal-toggle="popup-modal" type="button"
                                title="Modifier le status du personnel" onclick="getStatus({{ $zone->id }})"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-s-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white"
                                @if ($zone->status != true) >
                                    <i class="fa-solid fa-toggle-on"></i>
                                @else
                                >
                                    <i class="fa-solid fa-toggle-off"></i> @endif
                                </button>
                                <button onclick="getZone({{ $zone->id }})" type="button" href="#"
                                    title="Modifier la zone" data-modal-target="authentication-modal"
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
    <div id="popup-modal" tabindex="-1"
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
                    <h3 id="status" class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                    </h3>
                    <button onclick="changeStatus()" id="yes" data-modal-hide="popup-modal" type="button"
                        class="hidden text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Oui
                    </button>
                    <button onclick="changeStatus()" id="non" data-modal-hide="popup-modal" type="button"
                        class=" text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:green-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center hidden">
                        Oui
                    </button>
                    <button data-modal-hide="popup-modal" type="button"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Annuler</button>
                </div>
            </div>
        </div>
    </div>
    <div id="authentication-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Mettre à jour la zone
                    </h3>
                    <button type="button"
                        class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="authentication-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <form method="post" id="change">
                        @csrf
                        <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                            <div class="w-full">
                                <label for="nom"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nom</label>
                                <input name="nom" type="text" id="nom"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Nom de la ville" required />
                            </div>
                            <div class="w-full">
                                <label for="gerant"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gérant</label>
                                <select id="gerant" name="gerant"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected>Selectionner un gérant</option>
                                    @foreach ($gerants as $gerant)
                                        <option value="{{ $gerant->id }}">{{ $gerant->prenom }} {{ $gerant->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-full flex justify-center items-center">
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
    <script>
        let nom = document.getElementById('nom')
        let gerant = document.getElementById('gerant')
        let form = document.getElementById('change')
        let idZone

        function getZone(id) {
            axios.get(`/api/zones/${id}`)
                .then(function(response) {
                    const zone = response.data
                    nom.value = zone.nom
                    gerant.value = zone.chef
                    form.action = `/zones/change/${id}`
                    console.log(response.data);

                })
                .catch(function(error) {
                    // handle error
                    console.log(error);
                })
        }

        function getStatus(id) {
            axios.get(`/api/zones/${id}`)
                .then(function(response) {
                    const status = response.data.status
                    idZone = response.data.id
                    const stat = document.getElementById('status')
                    const yes = document.getElementById('yes')
                    const non = document.getElementById('non')
                    console.log(response.data);
                    if (status == 1) {
                        stat.textContent = "Voulez vous vraiment désactiver cette zone"
                        if (!non.classList.contains("hidden")) {
                            non.classList.add('hidden')
                        }

                        yes.classList.remove('hidden')
                    }
                    if (status == 0) {
                        stat.textContent = "Voulez vous vraiment activer cette zone"
                        if (!yes.classList.contains("hidden")) {
                            yes.classList.add('hidden')
                        }
                        non.classList.remove('hidden')
                    }

                })
                .catch(function(error) {
                    // handle error
                    console.log(error);
                })

        }

        function changeStatus() {
            axios.get(`/api/zones/status/change/${idZone}`)
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
