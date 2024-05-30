@extends('admin.adminwelcome')

@section('admincontent')
    <div class="bg-gray-800 my-10 p-6 rounded-xl flex-nowrap">
        <h1 class="text-white font-bold text-2xl">Customers Wallet</h1>
        <div class="mt-10">

            {{-- checking if the session is returning emptydb if there is no any customer wallet [file= walletcontroller.php] --}}
            {{-- [function = customerwallet()] --}}
            {{-- @if (session('emptydb'))
                <p class="bg-blue-50 text-blue-800 rounded-md px-3 py-3">{{ session('emptydb') }}</p> --}}

            {{-- check if the returned value is zero, if zero there is no data in table --}}
            {{-- this thing to count() is already checked in walletcontroller.php/customerwallet() function, but still for good practice and knowledge we did this --}}

            @if (count($cust_wallet1) > 0)
                <table class="w-full text-center text-gray-300 table-auto text-sm md:text-md">
                    <tr class="text-sm md:text-md lg:text-lg bg-gray-900 border-b-2 border-gray-100">
                        <th class="py-4 px-1 border-r border-gray-600">S.no</th>
                        <th class="border-r border-gray-600">cId</th>
                        <th class="border-r border-gray-600">wId</th>
                        <th class="border-r border-gray-600">cName</th>
                        <th class="border-r border-gray-600">cEmail</th>
                        <th class="border-r border-gray-600">cPhone</th>
                        <th class="">cBalance</th>
                    </tr>

                    {{-- accessing cust_wallet1 variable using for loop, this cust_wallet1 has list of customer wallet rows. --}}
                    @foreach ($cust_wallet1 as $wallet)
                        <tr class="border-b border-gray-500 bg-slate-700">
                            <td class=" border-r border-gray-600 px-2 md:py-2 md:px-0">{{ $wallet->id }}</td>
                            <td class="border-r border-gray-600 px-2 md:p-0">{{ $wallet->custId }}</td>

                            {{-- making the walletid clickable and  route with walletid, we can remove "$wallet-> " this thing and just put wallet_id  --}}
                            {{-- this will pass the wallet_id from the db that we are accessing using this forloop to the url in web.php {walletid} to make unique url for every customer wallets. --}}
                            <td class="border-r border-gray-600 px-2 md:p-0"><a
                                    href="{{ route('IndividualCustWallet', $wallet->wallet->wallet_id) }}"
                                    class="underline hover:text-blue-400 text-blue-300 px-2 md:p-0">{{ $wallet->wallet->wallet_id }}</a>
                            </td>
                            <td class="border-r border-gray-600 px-2 md:p-0">{{ $wallet->name }}</td>
                            <td class="border-r border-gray-600">{{ $wallet->email }}</td>
                            <td class="border-r border-gray-600">{{ $wallet->phone }}</td>
                            <td class="">Rs. {{ $wallet->wallet->balance }}</td>
                        </tr>
                    @endforeach
                </table>
            @else
                {{-- this will be displayed if the customer wallet table is empty --}}
                <p class="bg-gray-700 text-gray-300 mt-5 text-center py-2 rounded-lg">There is no any customer wallets at
                    the
                    moment.
                </p>
            @endif
        </div>
    </div>
@endsection
