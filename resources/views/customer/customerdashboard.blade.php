@extends('customer.customerwelcome')


@section('customercontent')
    @if (count($customerbroadcastMesg) > 0)
        <div>
            @foreach ($customerbroadcastMesg as $cbm)
                @if ($cbm->broadcast_type == 'primary')
                    <div
                        class="bg-blue-100 mt-3 mb-4 py-1 text-blue-800 rounded-md max-w-screen-xl flex flex-wrap justify-between mx-auto w-full p-4 flex-col">
                        <h1 class="font-bold">{{ $cbm->broadcast_title }}</h1>
                        <p class="ml-0 lg:ml-5">
                            {{ $cbm->message }}
                            <br>
                        </p>
                    </div>
                @else
                    <div
                        class="bg-pink-100 mt-3 mb-4 py-1 text-red-800 rounded-md max-w-screen-xl flex flex-wrap justify-between mx-auto w-full p-4 flex-col">
                        <h1 class="font-bold">{{ $cbm->broadcast_title }}</h1>
                        <p class="ml-0 lg:ml-5">
                            {{ $cbm->message }}
                            <br>
                        </p>
                    </div>
                @endif
            @endforeach
        </div>
    @endif

    <div
        class="bg-gray-800 mb-10 rounded-xl text-white max-w-screen-xl flex flex-wrap justify-between mx-auto w-full p-4 flex-col mt-3">
        <h1 class="font-bold text-2xl">Customer Dashboard</h1>

        <p class="">Balance Available: <strong>Rs.
                {{ Auth::guard('customer')->user()->wallet->balance }}/-</strong>
        </p>
    </div>
@endsection
