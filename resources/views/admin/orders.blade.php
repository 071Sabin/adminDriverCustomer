@extends('admin.adminwelcome')

@section('admincontent')
    {{-- <div class="bg-gray-800 my-10 p-6 rounded-xl">
        <h1 class="text-white font-bold text-2xl">All Orders</h1>
        @if ($errors->any())
            <div class="text-red-800 bg-red-100 rounded-lg mt-10 text-md px-3 py-3 border-2 border-red-800">
                @foreach ($errors->all() as $e)
                    {{ $e }} <Br>
                @endforeach
            </div>
        @endif

        @if (count($orders) > 0)
            <form action="" method="POST" enctype="multipart/form-data" class=" mt-10">
                @csrf
                <table class="w-full text-center table-auto text-sm md:text-md">

                    <tr class="text-lg bg-gray-900 border-b border-gray-100">
                        <th class="py-3">Select</th>
                        <th class="">S.No.</th>
                        <th class="">OrderId</th>
                        <th class="">c.Name</th>
                        <th class="">c.Email</th>
                        <th class="">c.Phone</th>

                        <th class="">d.Name</th>
                        <th class="">d.Email</th>
                        <th class="">d.Phone</th>
                    </tr>


                    @foreach ($orders as $order)
                        <tr class=" border-b border-gray-500 bg-slate-700">
                            <td class="py-2">
                                <input type="checkbox" name="items[]" value="{{ $user->id }}">
                            </td>
                            <td>{{ $order->order_id }}</td>
                            <td>{{ $order->c_id }}</td>

                            <td>{{ $order->d_id }}</td>
                            <td>{{ $order->d_email }}</td>

                            <td>{{ $order->delivery_address }}</td>
                            <td>{{ $order->distance }}</td>
                            <td>{{ $order->total_charge }}</td>


                        </tr>
                    @endforeach
                </table>
            </form>
        @else
            <p class="text-center rounded-md py-2 mt-10 text-md bg-gray-600">No orders have been placed yet.</p>
        @endif

    </div> --}}

    orders will appear here
@endsection
