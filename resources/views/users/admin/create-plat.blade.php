<x-app-layout>
    <x-slot name="title">
        Nouveau plat
    </x-slot>
    <x-slot name="mot">
        Créer un nouveau plat dans le système
    </x-slot>
    <div class="px-4 mx-auto max-w-2xl">
        <form action="{{ route('plats.store') }}" method="post" enctype="multipart/form-data">
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
                        for="photo">Photo*</label>
                    <input name="photo"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                        aria-describedby="file_input_help" id="photo" type="file" accept=".png, .jpg, .jpeg">
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PNG, JPG ou JPEG
                        (MAX. 800x400px).</p>
                    @error('photo')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="sm:col-span-2">

                    <label for="details" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Détails
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
</x-app-layout>
