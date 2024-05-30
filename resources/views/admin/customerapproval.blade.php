@extends('admin.adminwelcome')

@section('admincontent')
    <div class="bg-gray-800 my-10 p-6 text-white rounded-xl">
        <h1 class="text-white font-bold text-2xl">Customers Waiting Approval</h1>
        <p class="text-gray-500">Pending customer approvals: {{ count($pendingcustomers) }}</p>


        {{-- this is taking the errors that is returned from any fn in controller using withErrors() fn --}}
        @if ($errors->any())
            <div class="text-red-800 bg-red-100 rounded-lg mt-10 text-md px-3 py-3 border-2 border-red-800">
                @foreach ($errors->all() as $e)
                    {{ $e }} <Br>
                @endforeach
            </div>
        @endif

        {{-- checking of session is true and displaying message approvalcontroller.php/approvalprocess() --}}

        @if (session('approvalsuccess'))
            <p class="text-green-800 bg-green-50 p-2 mt-3 rounded-md">{{ session('approvalsuccess') }}</p>
        @endif

        @if (count($pendingcustomers) > 0)
            <form action="{{ route('approveprocess') }}" method="POST" enctype="multipart/form-data" class=" mt-10">
                @csrf
                {{-- giving a hidden data as customer because customer and driver approval page are using the same function approvalprocess in approvalcontroller.php --}}
                <input type="hidden" name="category" value="customer">
                <div class="flex justify-end gap-2 mb-4">
                    <button type="submit" name="action" value="approve"
                        class="bg-green-500 text-white rounded-lg py-2 px-5 hover:bg-green-600 font-semibold">Approve</button>
                    <button type="submit" name="action" value="reject"
                        class="bg-red-500 text-white rounded-lg py-2 px-7 hover:bg-red-600 font-semibold">Reject</button>
                </div>


                <table class="w-full text-center table-auto text-sm md:text-md">

                    <tr class="text-lg bg-gray-900 border-b border-gray-100">
                        <th class="py-3">Select</th>
                        <th class="">S.No.</th>
                        <th class="">CustId</th>
                        <th class="">Name</th>
                        <th class="">Email</th>
                        <th class="">Phone</th>
                    </tr>

                    {{-- taking the pendingcustomers data from the approvalcontroller.php and displaying using forloop --}}
                    @foreach ($pendingcustomers as $user)
                        <tr class=" border-b border-gray-500 bg-slate-700">
                            <td class="py-2">
                                {{-- this input is the hidden field and stores the customer id for the checkbox. if the checkbox is checked, and thens ubmitted it will pass the checked row only to the backend, approvalcontroller.php --}}
                                <input type="checkbox" name="customeritems[]" value="{{ $user->custId }}">
                            </td>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->custId }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                        </tr>
                    @endforeach
                </table>
            </form>
        @else
            <p class="text-center rounded-md py-2 mt-10 text-md bg-gray-600">No Customer signups awaiting
                approval
                at the
                moment.</p>
        @endif


    </div>
@endsection
