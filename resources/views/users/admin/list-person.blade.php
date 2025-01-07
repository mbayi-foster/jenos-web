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
                        <div class="flex items-center">
                            Online
                        </div>
                    </td>
                    <td class="px-6 py-4">


                        <div class="inline-flex rounded-md shadow-sm" role="group">
                            <a type="button"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-s-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white"
                                @if ($user->status != true)
                                >
                                    <i class="fa-solid fa-toggle-on"></i>
                                @else
                                >
                                    <i class="fa-solid fa-toggle-off"></i>
                                @endif
                            </a>
                            <a type="button" href="{{ route('users.show', $user->id) }}"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-e-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                                <i class="fa-solid fa-circle-info"></i>
                            </a>
                        </div>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-app-layout>
