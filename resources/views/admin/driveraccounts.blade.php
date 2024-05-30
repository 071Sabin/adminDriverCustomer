@extends('admin.adminwelcome')

@section('admincontent')
    <style>
        td,
        th {
            padding: 0 10px;
        }
    </style>
    <div class="bg-gray-800 my-10 p-6 rounded-xl">
        <h1 class="text-gray-300 font-bold text-2xl">Existing Drivers Account</h1>
        <p class="text-gray-500">Total approved driver: {{ $totaldriver }}</p>
        @if ($errors->any())
            <div class="text-red-800 bg-red-100 rounded-lg mt-10 text-md px-3 py-3 border-2 border-red-800">
                @foreach ($errors->all() as $e)
                    {{ $e }} <Br>
                @endforeach
            </div>
        @endif

        @if (count($drivers) > 0)
            <form action="" method="POST" enctype="multipart/form-data" class=" mt-10">
                @csrf
                {{-- giving a hidden data as driver because driver and driver approval page are using the same function approvalprocess in approvalcontroller.php --}}
                <input type="hidden" name="category" value="driver">
                <div class="flex justify-end gap-2 mb-4">

                    {{-- <button type="submit" name="action" value="approve"
                        class="bg-green-500 text-white rounded-lg py-2 px-5 hover:bg-green-600 font-semibold">Approve</button> --}}

                </div>


                <table class="w-full text-center text-gray-300 table-auto text-sm md:text-md">

                    <tr class="text-sm md:text-md lg:text-lg bg-gray-900 border-b border-gray-100">
                        {{-- <th class="py-3">Select</th> --}}
                        <th class="py-4">S.No.</th>
                        <th class="border-l border-gray-600">DriverId</th>
                        <th class="border-l border-gray-600">Verification<br>Status</th>
                        <th class="border-l border-gray-600">KYC<br>Rejection</th>
                        <th class="border-l border-gray-600">Name</th>
                        <th class="border-l border-gray-600">Email</th>
                        <th class="border-l border-gray-600">Phone</th>
                    </tr>


                    @foreach ($drivers as $driver)
                        <tr class=" border-b border-gray-500 bg-slate-700">
                            {{-- 1st td --}}
                            <td class="py-2">
                                {{ $driver->id }}
                            </td>
                            {{-- 2nd td --}}
                            <td class="border-l border-gray-400">
                                <a class="text-blue-400 underline hover:text-blue-500"
                                    href="{{ route('showIndividualDriverDetails', $driver->driverId) }}">{{ $driver->driverId }}
                                </a>
                            </td>

                            {{-- 3rd td --}}
                            {{-- choosing which table data <td> to display fr each condition verification status column --}}
                            @if ($driver->verification_status === 0)
                                <td class="bg-red-200 border-l border-gray-400">
                                    <i class="bi bi-x-circle text-red-700 text-xl"></i>
                                </td>
                            @else
                                <td class="text-green-800 bg-green-100 border-l border-gray-400">
                                    <i class="bi bi-check2-circle text-green-800 text-xl"></i>
                                </td>
                            @endif

                            {{-- 4th td --}}
                            {{-- if there is verification file and admin is reviewing it, display this table data for kyc rejection column --}}
                            {{-- more details in individualDriverDetails.php --}}
                            @if ($driver->verification_file and $driver->kyc_rejection === null)
                                <td class="border-l border-gray-400 bg-blue-100 text-blue-800">
                                    <i class="bi bi-hourglass-split"></i>
                                </td>

                                {{-- if driver has not uploaded file then display this table data --}}
                            @elseif($driver->verification_file === null and $driver->kyc_rejection === null)
                                <td class="bg-red-100 border-l border-gray-400">
                                    <p class="bg-red-100 text-red-800">--No File--</p>
                                </td>
                            @elseif($driver->kyc_rejection === 1)
                                <td class="bg-red-100 border-l border-gray-400">
                                    <i class="bi bi-file-earmark-x-fill text-red-700"></i>
                                </td>
                            @elseif($driver->kyc_rejection === 0)
                                <td class="bg-green-100 border-l border-gray-400 text-green-700 text-xl">
                                    <i class="bi bi-check2-circle"></i>
                                </td>
                            @endif

                            {{-- 5th td --}}
                            <td class="border-l border-gray-400">{{ $driver->name }}</td>

                            {{-- 6th td --}}
                            <td class="border-l border-gray-400">{{ $driver->email }}</td>
                            <td class="border-l border-gray-400">{{ $driver->phone }}</td>
                        </tr>
                    @endforeach

                </table>
            </form>
        @else
            <p class="text-center rounded-md py-2 mt-10 text-md bg-gray-600">No drivers are approved !</p>
        @endif
    </div>
@endsection
