@extends('driver.driverwelcome')


@section('drivercontent')
    @if (count($driverbroadcastMesg) > 0)
        <div>
            @foreach ($driverbroadcastMesg as $dbm)
                @if ($dbm->broadcast_type == 'primary')
                    <div
                        class="bg-blue-100 mt-3 mb-4 py-1 text-blue-800 rounded-md max-w-screen-xl flex flex-wrap justify-between mx-auto w-full p-4 flex-col">
                        <h1 class="font-bold">{{ $dbm->broadcast_title }}</h1>
                        <p class="ml-0 lg:ml-5">
                            {{ $dbm->message }}
                            <br>
                        </p>
                    </div>
                @else
                    <div
                        class="bg-pink-100 mt-3 mb-4 py-1 text-red-800 rounded-md max-w-screen-xl flex flex-wrap justify-between mx-auto w-full p-4 flex-col">
                        <h1 class="font-bold">{{ $dbm->broadcast_title }}</h1>
                        <p class="ml-0 lg:ml-5">
                            {{ $dbm->message }}
                            <br>
                        </p>
                    </div>
                @endif
            @endforeach
        </div>
    @endif

    <div
        class="bg-gray-800 mb-10 rounded-xl text-white max-w-screen-xl flex flex-wrap justify-between mx-auto w-full p-4 flex-col">
        <h1 class="font-bold text-2xl">Driver Dashboard</h1>

        <p class="">Balance Available: <strong>Rs.
                {{ Auth::guard('driver')->user()->driverwallet->balance }}/-</strong>
        </p>
    </div>
@endsection
