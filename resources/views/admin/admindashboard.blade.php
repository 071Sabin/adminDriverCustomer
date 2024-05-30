@extends('admin.adminwelcome')

@section('admincontent')
    <div class="bg-gray-800 p-6 rounded-xl">
        <h1 class="text-white font-bold text-3xl">Admin Dashboard(ID: {{ Auth::guard('admin')->user()->id }})</h1>

        <p>Admins can broadcast some messages to customer and driver from here.</p>


        @if (session('cust_broadcast_success'))
            <p class="bg-green-100 text-green-900 py-2 px-3 rounded mt-10">{{ session('cust_broadcast_success') }}</p>
        @endif
        @if (session('driver_broadcast_success'))
            <p class="bg-green-100 text-green-900 py-2 px-3 rounded mt-10">{{ session('driver_broadcast_success') }}</p>
        @endif

        @if ($errors->any())
            <div class="text-red-800 bg-red-100 rounded-lg mt-10 text-md px-3 py-3 border-2 border-red-800">
                @foreach ($errors->all() as $e)
                    {{ $e }} <Br>
                @endforeach
            </div>
        @endif


        <div class="mt-10 lg:flex lg:flex-row">
            <form action="{{ route('admincustbroadcast') }}" method="POST" enctype="multipart/form-data"
                class="custBroadcast lg:w-1/2 w-full p-3 mt-2 flex flex-col gap-5 lg:border-r lg:border-gray-300 lg:pr-10 border-b lg:border-b-0 pb-10 lg:pb-3">
                @csrf
                <h1 class="font-semibold text-xl underline text-fuchsia-500 text-center mb-3">Customer Broadcast</h1>

                <div class="flex items-center gap-2">
                    <p>Title:</p> <input type="text" name="custBroadcastTitle" class="rounded bg-gray-500 w-full"
                        placeholder="Title of Broadcast...">
                </div>
                <div class="flex items-center gap-2">
                    <p>Message:</p> <input type="text" name="custBroadcastmesg" class="rounded bg-gray-500 w-full"
                        placeholder="Type Mesg to broadcast...">
                </div>
                <div class="flex items-center gap-3 justify-between bg-gray-600 p-3 rounded">
                    <p class="font-bold">Importance: </p>
                    <p>
                        Primary: <input type="radio" name="messageUrgency" value="primary">
                    </p>
                    {{-- <p>
                        Secondary: <input type="radio" name="custmessage"value="secondary">
                    </p> --}}
                    <p>
                        Urgent: <input type="radio" name="messageUrgency"value="urgent">
                    </p>
                </div>
                <button type="submit" class="bg-fuchsia-600 hover:bg-fuchsia-500 px-3 py-2 rounded mt-5">Broadcast</button>
            </form>

            {{-- driver broadcast --}}
            <form action="{{ route('admindriverbroadcast') }}" method="POST" enctype="multipart/form-data"
                class="custBroadcast lg:w-1/2 w-full p-3 mt-2 flex flex-col gap-5 lg:pl-10
                pl-0">
                @csrf
                <h1 class="font-semibold text-xl underline text-cyan-400 text-center mb-3">Driver Broadcast</h1>

                <div class="flex items-center gap-2">
                    <p>Title:</p> <input type="text" name="driverBroadcastTitle" class="rounded bg-gray-500 w-full"
                        placeholder="Title of Broadcast...">
                </div>
                <div class="flex items-center gap-2">
                    <p>Message:</p> <input type="text" name="driverBroadcastmesg" class="rounded bg-gray-500 w-full"
                        placeholder="Type Mesg to broadcast...">
                </div>
                <div class="flex items-center justify-between bg-gray-600 p-3 rounded">
                    <p class="font-bold">Importance: </p>
                    <p class="">
                        Primary: <input type="radio" name="messageUrgency" value="primary" class="">
                    </p>
                    {{-- <p>
                            Secondary: <input type="radio" name="custmessage"value="secondary">
                        </p> --}}
                    <p>
                        Urgent: <input type="radio" name="messageUrgency"value="urgent">
                    </p>

                </div>
                <button type="submit" class="bg-cyan-500 hover:bg-cyan-600 px-3 py-2 rounded mt-5">Broadcast</button>
            </form>
        </div>

        <hr class="my-10">


        {{-- BROADCAST DETAILS AND DELETE OPTIONS --}}
        <div>
            <h1 class="text-center underline font-bold text-3xl">Broadcast Details</h1>
            @if (session('broadcast_deleted'))
                <p class="text-green-900 bg-green-100 p-2 rounded mt-5">Broadcast with id <span
                        class="font-semibold">{{ session('broadcast_deleted') }}</span> is deleted
                    successfully.</p>
            @endif

            @if (count($allbroadcasts) > 0)
                <table class="w-full text-center text-gray-300 table-auto text-sm md:text-md mt-5">

                    <tr class="text-sm md:text-md lg:text-lg bg-gray-900 border-b border-gray-100">
                        {{-- <th class="py-3">Select</th> --}}
                        <th class="py-4">S.No.</th>
                        <th class="">Broadcast<br>Type</th>
                        <th class="">Broadcast<br>Title</th>
                        <th class="">Broadcast<br>For</th>
                        <th class="">Message</th>
                        <th class="">Date</th>
                        <th class="">Action</th>
                    </tr>


                    @foreach ($allbroadcasts as $broadcast)
                        <tr class=" border-b border-gray-500 bg-slate-700">
                            {{-- <td class="py-2">
                                <input type="checkbox" name="items[]" value="{{ $broadcast->id }}">
                            </td> --}}
                            <td class="py-2">{{ $broadcast->id }}</td>
                            @if ($broadcast->broadcast_type == 'urgent')
                                <td class="bg-pink-100 text-red-800">{{ $broadcast->broadcast_type }}</td>
                            @else
                                <td class="bg-blue-100 text-blue-800">{{ $broadcast->broadcast_type }}</td>
                            @endif
                            <td class="bg-gray-600">{{ $broadcast->broadcast_title }}</td>
                            @if ($broadcast->for == 'customer')
                                <td class="text-fuchsia-500">{{ $broadcast->for }}</td>
                            @elseif($broadcast->for == 'driver')
                                <td class="text-cyan-500">{{ $broadcast->for }}</td>
                            @endif

                            <td class="bg-gray-600">{{ $broadcast->message }}</td>
                            <td>{{ $broadcast->updated_at }}</td>
                            <td class="">
                                <a href="{{ route('deletebroadcast', $broadcast->id) }}"><i
                                        class="bi bi-trash3-fill text-xl text-red-600 px-1 rounded-full bg-white hover:bg-red-500 hover:text-white"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach

                </table>
            @else
                <p class="text-gray-500">Broadcast message by admin for drivers and customers are shown here!</p>
                <p class="bg-gray-500 text-gray-100 py-2 px-3 w-full rounded text-center mt-3">Admins didn't broadcast
                    anything yet...</p>
            @endif
        </div>
    </div>
@endsection
