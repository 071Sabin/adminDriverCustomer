@extends('welcome')

@section('content')
    <div class="logindiv flex bg-gray-700 items-center z-10 justify-center text-white py-12 px-4 sm:px-6 lg:px-8">

        <div class="w-full max-w-md space-y-8 opacity-80">
            <div class="bg-slate-900 shadow-lg p-10 rounded-3xl">
                <h2 class="text-center text-3xl font-extrabold mb-12">
                    <i class="bi bi-person-circle"></i>&nbsp;Customer Login
                </h2>
                @if (!empty(session('customer_register_success')))
                    <div class="text-blue-800 bg-blue-100 rounded-lg mt-10 text-md px-3 py-3 border-2 border-blue-800">
                        {{-- Registerd as Customer. Please Login. --}}
                        Your account is currently undergoing review by our administrators. Please note that this process may
                        require 2-3 business days to complete.
                    </div>
                @endif
                @if ($errors->any())
                    <div class="text-red-800 bg-red-100 rounded-lg mt-10 text-md px-3 py-3 border-2 border-red-800">
                        @foreach ($errors->all() as $e)
                            {{ $e }} <Br>
                        @endforeach
                    </div>
                @endif
                {{-- @if (!empty(session('no-user-with-this-email')))
                    <div class="text-red-600 bg-red-100 rounded-lg mt-10 text-md px-2 py-2 border-2 border-red-600">
                        No user with this Email, Please Sign Up first.
                    </div>
                @endif --}}


                <form class="mt-8 space-y-6" action="{{ Route('customerlogin') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="rounded-md shadow-sm -space-y-px">
                        <div>
                            <p class="mt-3">Email</p>
                            <label for="email-address" class="sr-only">Email address</label>
                            <input id="email-address" name="email" type="email" autocomplete="email" required
                                class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                placeholder="Email address">
                        </div>
                        <div>
                            <p class="mt-3">Password</p>
                            <label for="password" class="sr-only">Password</label>
                            <input id="password" name="password" type="password" autocomplete="current-password" required
                                class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                placeholder="Password">
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember-me" name="remember-me" type="checkbox"
                                class="h-4 w-4 text-indigo-300 focus:ring-indigo-300 border-gray-300 rounded">
                            <label for="remember-me" class="ml-2 block text-sm text-gray-300">
                                Remember me
                            </label>
                        </div>

                        <div class="text-sm">
                            <a href="#" class="font-medium text-indigo-400 hover:text-indigo-300">
                                Forgot your password?
                            </a>
                        </div>
                    </div>
                    <p>New to our site? <a class="text-indigo-400" href="{{ Route('customersignup') }}">SignUp Here</a></p>
                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Sign in
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
