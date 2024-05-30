<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver-Panel</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="{{ asset('bootstrapIcons/font/bootstrap-icons.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body class="h-screen bg-gray-600">
    {{-- NAV BAR --}}
    @if (Auth::guard('driver')->check())
        <nav class="bg-white border-gray-200 dark:bg-gray-900 dark:border-gray-700">
            <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
                <a href="{{ route('driverdashboard') }}" class="flex items-center space-x-3 rtl:space-x-reverse">

                    <span
                        class="self-center text-2xl font-bold whitespace-nowrap dark:text-white">Driver-Dashboard</span>
                </a>
                <button data-collapse-toggle="navbar-dropdown" type="button"
                    class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                    aria-controls="navbar-dropdown" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 17 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 1h15M1 7h15M1 13h15" />
                    </svg>
                </button>
                <div class="hidden w-full md:block md:w-auto" id="navbar-dropdown">
                    <ul
                        class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">

                        <li>
                            <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar"
                                class="flex items-center justify-between w-full py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:w-auto dark:text-white md:dark:hover:text-blue-500 dark:focus:text-white dark:border-gray-700 dark:hover:bg-gray-700 md:dark:hover:bg-transparent">

                                @if (!Auth::guard('driver')->user()->profile_pic)
                                    <i class="bi bi-person-circle text-3xl"></i>
                                @else
                                    <img src="{{ asset('uploads/' . Auth::guard('driver')->user()->profile_pic) }}"
                                        alt="" class="h-10 w-10 rounded-full">
                                @endif

                                <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </button>
                            <!-- Dropdown menu -->
                            <div id="dropdownNavbar"
                                class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-400"
                                    aria-labelledby="dropdownLargeButton">
                                    <li>
                                        <p
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white border-b border-gray-600">
                                            <strong class="text-lg">{{ Auth::guard('driver')->user()->name }}</strong>
                                            <br>
                                            #{{ Auth::guard('driver')->user()->driverId }}<br>
                                            #{{ Auth::guard('driver')->user()->driverwallet->wallet_id }}
                                        </p>
                                    </li>

                                    <li>
                                        <a href="{{ route('driverdashboard') }}"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('driverprofile') }}"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Profile
                                        </a>
                                    </li>
                                </ul>
                                <div class="py-1">
                                    <a href="{{ route('driverlogout') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign
                                        out</a>
                                </div>
                            </div>
                        </li>
                        {{-- <li>
                            <a href="#"
                                class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Services</a>
                        </li> --}}

                    </ul>
                </div>
            </div>
        </nav>



        <main class="max-w-screen-xl flex flex-wrap justify-between mx-auto w-full p-1 lg:p-4 flex-col">
            @yield('drivercontent')
        </main>
    @endif



    {{-- FOOTER --}}
    <footer class="bottom-0 bg-gray-800 py-8 px-4 sm:px-8 lg:px-16 text-white mt-20" id="contact">
        <div class="max-w-7xl mx-auto flex flex-col items-center justify-center">
            <div class="flex space-x-4 mb-4">
                <!-- Facebook Icon -->
                <a href="#" class="inline-block bg-blue-500 rounded-sm p-1">
                    <img src="{{ asset('bootstrap-icons/facebook.svg') }}" alt="" class="h-6 w-6">
                </a>
                <!-- Instagram Icon -->
                <a href="#" class="inline-block bg-gradient-to-r from-purple-500 to-pink-500 rounded-sm p-1">
                    <img src="{{ asset('bootstrap-icons/instagram.svg') }}" alt="" class="h-6 w-6">
                </a>
                <!-- Twitter Icon -->
                <a href="#" class="inline-block bg-blue-400 rounded-sm p-1">
                    <img src="{{ asset('bootstrap-icons/twitter.svg') }}" alt="" class="h-6 w-6">
                </a>
            </div>
            <div class="text-sm">
                <p>Terms and Conditions | Privacy Policy | &copy; XYZ Since 2024</p>
            </div>
        </div>
    </footer>


</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>

</html>
