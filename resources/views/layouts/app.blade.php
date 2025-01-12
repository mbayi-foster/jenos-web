<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="./assets/img/fav.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.tailwindcss.css" />
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <title>Jenos-Food</title>
    @vite(['resources/css/app.css'])
</head>

<body class="bg-gray-100">
    <x-nav-bar></x-nav-bar>
    <!-- strat wrapper -->
    <x-side-bar></x-side-bar>
    <!-- strat content -->
    <div class="p-4 sm:ml-64">

        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mt-14">
            <div class="flex flex-col justify-center mb-3">

                <h3
                    class="mb-4 text-3xl font-extrabold tracking-tight leading-none text-gray-900 md:text-4xl lg:text-5xl dark:text-white">
                    {{ $title }}
                </h3>
                <p class="mb-8 text-lg font-normal text-gray-500 lg:text-xl dark:text-gray-400">
                    {{ $mot }}</p>
                {{--     <div class="flex flex-col space-y-4 sm:flex-row sm:space-y-0">
                    <a href="#"
                        class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900">
                        Get started
                        <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                    </a>
                    <a href="#"
                        class="py-3 px-5 sm:ms-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        Learn more
                    </a>
                </div> --}}
            </div>
            {{ $slot }}
        </div>
    </div>
    <!-- end content -->
    <!-- end wrapper -->

    <!-- start script -->
    @vite(['resources/js/app.js'])
    @yield('script')
    <!-- end script -->
</body>

</html>
