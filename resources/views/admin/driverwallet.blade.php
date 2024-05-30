@extends('admin.adminwelcome')

@section('admincontent')
    <div class="bg-gray-800 my-10 p-6 rounded-xl">
        <h1 class="text-white font-bold text-2xl">Driver Wallet</h1>
        <div class="mt-10">
            {{-- @if (session('emptydb'))
                <p class="bg-blue-50 text-blue-800 rounded-md px-3 py-3">{{ session('emptydb') }}</p> --}}
            @if (count($driver_wallets) > 0)
                <table class="w-full text-center text-gray-300 table-auto text-sm md:text-md">
                    <tr class="text-sm md:text-md lg:text-lg bg-gray-900 border-b border-gray-100">
                        <th class="py-4">S.no</th>
                        <th>d.Id</th>
                        <th>w.Id</th>
                        <th>d.Name</th>
                        <th>d.Email</th>
                        <th>d.Phone</th>
                        <th>d.Balance</th>
                    </tr>

                    @foreach ($driver_wallets as $wallet)
                        <tr class="border-b border-gray-500 bg-slate-700">
                            <td class="py-2">{{ $wallet->driverwallet->id }}</td>
                            <td>{{ $wallet->driverId }}</td>
                            <td><a href="{{ route('IndividualDriverWallet', $wallet->driverwallet->wallet_id) }}"
                                    class="underline hover:text-blue-400 text-blue-300">{{ $wallet->driverwallet->wallet_id }}</a>
                            </td>
                            <td>{{ $wallet->name }}</td>
                            <td>{{ $wallet->email }}</td>
                            <td>{{ $wallet->phone }}</td>
                            <td>{{ $wallet->driverwallet->balance }}</td>
                        </tr>
                    @endforeach
                </table>
            @else
                <p class="bg-gray-700 text-gray-300 mt-5 text-center py-2 rounded-lg">There are no any driver wallets at the
                    moment.</p>
            @endif
        </div>
    </div>
@endsection
