@extends('welcome')

@section('content')
    <div class="flex items-center justify-center bg-gray-700 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-gray-800 p-10 rounded-3xl text-white">
            <div>
                <h2 class="text-center text-3xl font-extrabold mb-12">
                    Driver Sign up
                </h2>
            </div>
            @if ($errors->any())
                <div class="text-red-800 bg-red-100 rounded-lg mt-10 text-md px-2 py-2 border-2 border-red-600">
                    @foreach ($errors->all() as $e)
                        {{ $e }} <Br>
                    @endforeach
                </div>
            @endif
            <form class="space-y-6" action="{{ Route('driversignup') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="rounded-md shadow-sm -space-y-px">
                    <div>
                        <p class="mt-3">Full Name</p>
                        <label for="fullname" class="sr-only">Name</label>
                        <input id="fullname" name="fullname" type="text"
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Full Name">
                    </div>
                    <div>
                        <p class="mt-3">Email</p>
                        <label for="email-address" class="sr-only">Email address</label>
                        <input id="email-address" name="email" type="email" autocomplete="email" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Email address">
                        {{-- <div class="text-red-600 bg-red-300">{{ $errors->first('email') }}</div> --}}
                    </div>
                    <div>
                        <p class="mt-3">Phone</p>
                        <label for="phoneno" class="sr-only">Email address</label>
                        <input id="phoneno" name="phone" type="text" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Phone No.">
                    </div>
                    <div>
                        <p class="mt-3">Password</p>
                        <label for="password" class="sr-only">Password</label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Password">

                        {{-- <div class="text-red-600 bg-red-100">{{ $errors->first('password') }}</div> --}}
                    </div>
                </div>
                <p class="font-thin text-md">Already a member? <a href="{{ Route('driverlogin') }}"
                        class="text-indigo-300">Login
                        Here</a>

                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Sign Up
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
