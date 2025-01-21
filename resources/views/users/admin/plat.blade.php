<x-app-layout>
    <x-slot name="title">
        Commande
    </x-slot>
    <x-slot name="mot">

        <div class="flex items-center justify-between mb-4">

            <div class="w-full bg-gray-200 rounded-full dark:bg-gray-700">
                <div class="bg-orange-600 text-xs font-medium text-orange-100 text-center p-0.5 leading-none rounded-full"
                    style="width: 75%">En cours de préparation</div>
            </div>

        </div>
        @if (session('success'))
            <div id="alert-3"
                class="flex items-center p-4 mb-4 text-orange-800 rounded-lg bg-orange-50 dark:bg-gray-800 dark:text-orange-400"
                livreur="alert">
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
                    class="ms-auto -mx-1.5 -my-1.5 bg-orange-50 text-orange-500 rounded-lg focus:ring-2 focus:ring-orange-400 p-1.5 hover:bg-orange-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-orange-400 dark:hover:bg-gray-700"
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



    <div class="grid grid-cols-1 md:grid-cols-2 justify-center w-full justify-center items-center">
        {{-- photos des produits --}}
        <div id="controls-carousel" class="relative w-full" data-carousel="static">
            <!-- Carousel wrapper -->
            <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                <!-- Item 1 -->
                <div class="hidden duration-700 ease-in-out" data-carousel-item>

                    <div class="w-full flex-shrink-0">
                        <img src="/storage//images/rfcrffdaw_1736592714.jpg" alt="Image 1"
                            class="w-full h-full object-cover">
                        <div class="absolute inset-0 flex items-end justify-center bg-black bg-opacity-50">
                            <div class="text-center">
                                <p class="text-xl font-bold text-white dark:text-white">Courge à la patate douce</p>
                                <p class="text-2xl font-bold text-white dark:text-white">200 $</p>
                                <p class="text-2xl  font-bold text-white dark:text-white">Qte. 3</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Slider controls -->
            <button type="button"
                class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                data-carousel-prev>
                <span
                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 1 1 5l4 4" />
                    </svg>
                    <span class="sr-only">Previous</span>
                </span>
            </button>
            <button type="button"
                class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                data-carousel-next>
                <span
                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                    <span class="sr-only">Next</span>
                </span>
            </button>
        </div>

        {{-- details --}}
        <div class="p-6 relative overflow-x-auto ">
            <div class="flex items-end justify-between mb-2">
                <p class="text-xl font-black text-gray-900 dark:text-white">#2025-96968-9658</p>
                <p class="text-xl font-thin text-gray-900 dark:text-white">2025-12-02</p>
            </div>
            <p class="text-sm font-thin text-gray-900 dark:text-white">Client : Jean Mark
            </p>
            <p class="text-sm font-thin text-gray-900 dark:text-white mt-2 mb-2">Contact : <i
                    class="fa-solid fa-envelope"></i> jfkfoster@gmails.com <i class="fa-solid fa-phone"></i> +243
                996896586
            </p>
            <p class="text-sm font-thin text-gray-900 dark:text-white">Adresse de livraison : <i
                    class="fa-solid fa-location-dot"></i> Nzoloko 9A
            </p>

            <div class="flex items-end justify-between w-72 bg-gray-100 p-2 mt-3">
                <div>
                    <p class="text-sm text-gray-900 font-extralight dark:text-white">Facture</p>
                    <p class="text-lg text-gray-800 font-medium  dark:text-white">200000 FC</p>
                </div>
                <div>
                    <i class="fa-solid fa-square-check text-green-800 text-4xl"></i>
                    <i class="fa-solid fa-square-check text-red-800 text-4xl"></i>
                </div>
            </div>
            <div class="relative overflow-x-auto  p-4 mt-3">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                                Plats
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Qte
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                Courge à la patate douce
                            </th>
                            <td class="px-6 py-4">
                                5
                            </td>
                        </tr>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                Apple MacBook Pro 17"
                            </th>
                            <td class="px-6 py-4">
                                Silver
                            </td>
                        </tr>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                Apple MacBook Pro 17"
                            </th>
                            <td class="px-6 py-4">
                                Silver
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-4 text-center">
                <button type="button" data-modal-target="popup-modal1" data-modal-toggle="popup-modal1"
                    class="w-full text-white bg-orange-700 hover:bg-orange-800 focus:outline-none focus:ring-4 focus:ring-orange-300 font-medium rounded-full text-sm py-2.5 text-center me-2 mb-2 dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800">Analyser
                    la commande</button>
                <button type="button" data-modal-target="popup-modal" data-modal-toggle="popup-modal"
                    class="w-full text-white bg-orange-700 hover:bg-orange-800 focus:outline-none focus:ring-4 focus:ring-orange-300 font-medium rounded-full text-sm py-2.5 text-center me-2 mb-2 dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800">Prêt
                    pour la livraison</button>
            </div>
            <p class="text-sm font-thin text-gray-900 dark:text-white">Livreur : Jean Claude</p>
            <p class="text-sm font-thin text-gray-900 dark:text-white mt-2 mb-2">Contact : <i
                    class="fa-solid fa-envelope"></i> jfkfoster@gmails.com <i class="fa-solid fa-phone"></i> +243
                996896586
            </p>
        </div>
    </div>

    <div id="popup-modal" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Choisir le livreur
                        </h3>
                        <button type="button"
                            class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="popup-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 14 14">
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
                            <div class="w-full">
                                <label for="countries"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Livreurs</label>
                                <select id="countries"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    {{--    @foreach ($livreurs as $livreur)
                                        <option value="{{ $livreur->id }}">{{ $livreur->prenom }} {{ $livreur->nom }}
                                        </option>
                                    @endforeach --}}
                                </select>
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
                        valider cette commande pour débuter sa préparation</h3>
                    <button onclick="changeStatus()" id="non" data-modal-hide="popup-modal1" type="button"
                        class="text-white bg-orange-600 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 dark:focus:orange-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Oui
                    </button>
                    <button data-modal-hide="popup-modal1" type="button"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Non</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
