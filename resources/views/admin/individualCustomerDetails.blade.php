@extends('admin.adminwelcome')

@section('admincontent')
    <div class="bg-gray-800 my-10 p-6 rounded-xl">

        @if ($errors->any())
            <div class="text-red-800 bg-red-100 rounded-lg mt-10 text-md px-3 py-3 border-2 border-red-800">
                @foreach ($errors->all() as $e)
                    {{ $e }} <Br>
                @endforeach
            </div>
        @endif

        <div class="flex flex-col lg:flex-row justify-center items-center lg:items-start">

            <div class="lg:border-r-4 border-gray-500 lg:pr-10 border-b-2 lg:border-b-0 w-full lg:w-fit pb-10 lg:pb-0">
                <h1 class="font-bold text-2xl underline text-center lg:text-left">Customer Personal Details</h1>

                {{-- @foreach ($customerDetails as $c) --}}
                <table class="border border-gray-200 mt-10 mx-auto">
                    <tr class="border-b border-gray-200">
                        <td class="p-2 font-bold">Profile Picture</td>
                        <td class="p-2 border-l border-gray-200 bg-gray-700 flex justify-center">
                            <img src="{{ asset('uploads/' . $customerDetails->profile_pic) }}" alt="profilePic"
                                class="h-20 rounded-xl">
                        </td>
                    </tr>
                    <tr class="border-b border-gray-200">
                        <td class="p-2 font-bold">Customer Name</td>
                        <td class="p-2 border-l border-gray-200 bg-gray-700">{{ $customerDetails->name }}</td>
                    </tr>
                    <tr class="border-b border-gray-200">
                        <td class="p-2 font-bold">Customer Id</td>
                        <td class="p-2 border-l border-gray-200 bg-gray-700">{{ $customerDetails->custId }}</td>
                    </tr>
                    <tr class="border-b border-gray-200">
                        <td class="p-2 font-bold">Email</td>
                        <td class="p-2 border-l border-gray-200 bg-gray-700">{{ $customerDetails->email }}</td>
                    </tr>
                    <tr class="border-b border-gray-200">
                        <td class="p-2 font-bold">Phone</td>
                        <td class="p-2 border-l border-gray-200 bg-gray-700">{{ $customerDetails->phone }}</td>
                    </tr>
                </table>
                {{-- @endforeach --}}
            </div>


            <div class="lg:pl-10 pt-10 lg:pt-0">

                <h1 class="font-bold text-2xl underline text-center lg:text-left">Edit the Customer Details</h1>


                @if (session('customer_details_updated'))
                    <p class="text-green-500">updated</p>
                @endif

                <form action="{{ route('adminUpdateCustomerDetails', $customerDetails->custId) }}" class="mt-10"
                    enctype="multipart/form-data" method="POST">
                    @csrf
                    <p class="mt-3 justify-between flex items-center">
                        Update Customer Name: <input type="text" placeholder="Enter new Name" name="updatedName"
                            class="bg-gray-800 ml-2 text-white placeholder-gray-400 rounded-md border-2 border-gray-600 focus:bg-gray-900 focus:border-blue-500">
                    </p>
                    <div class="text-red-500 text-sm">{{ $errors->first('updatedName') }}</div>

                    <p class="mt-3 justify-between flex items-center">
                        Update Customer Email:<input type="email" placeholder="Enter new Email" name="updatedEmail"
                            class="bg-gray-800 ml-2 text-white placeholder-gray-400 rounded-md border-2 border-gray-600 focus:bg-gray-900 focus:border-blue-500">
                    </p>
                    <div class="text-red-500 text-sm">{{ $errors->first('updatedEmail') }}</div>

                    <p class="mt-3 justify-between flex items-center">
                        Update Customer Phone:<input type="text" placeholder="Enter new Phone" name="updatedPhone"
                            class="bg-gray-800 ml-2 text-white placeholder-gray-400 rounded-md border-2 border-gray-600 focus:bg-gray-900 focus:border-blue-500">
                    </p>
                    <div class="text-red-500 text-sm">{{ $errors->first('updatedPhone') }}</div>

                    <button class="bg-blue-500 rounded px-5 py-2 mt-3" type="submit">Save</button>
                </form>
            </div>
        </div>

        <hr class="my-5">
        <div>
            <h1 class="font-semibold text-2xl mb-5">User KYC Verification File</h1>

            {{-- this condition works if customer has uploaded the kyc file for verification else no need to go in this statement --}}
            {{-- kyc_verification is null in 2 condition, if the user has not uploaded the file, and after user uploads the file.
            if we just check only null value in kyc_rejection field for particular customer without checking if the kyc file has been uploaded or not, this will not work because weather the customers uploads/doesn't uploads that field is going to be null anyway by default as soon as customer account is created or approved by admin. 
            if there is file uploaded, the kyc_rejection field is still null so that we display "under verification" message, so checking if file exists and the kyc_rejection is null, then display the verification pending message.
            so we need to check if it is null after uploading the kyc file by customer. so either use if($customerDetails->verification_file and $customerDetails->kyc_rejection === null) or put the if($customerDetails->verification_file) and then put other conditions in this so that code enters in this condition only if the customer has uploaded kyc file.
            after that, the kyc will eiter be approved or rejected. then we can just check the kyc_rejection is 0 or 1. 0=not rejected, 1=rejected
             --}}
            @if ($customerDetails->verification_file)
                @if ($customerDetails->kyc_rejection === null)
                    <p class="mb-3">User Verification Status:
                        <span class="p-1 text-sm rounded bg-blue-100 text-blue-800">KYC Under
                            Verification
                            <i class="bi bi-hourglass-split"></i>
                        </span>
                    </p>
                @elseif($customerDetails->kyc_rejection === 0)
                    <p class="mb-3">User Verification Status:
                        <span class="p-1 text-sm rounded bg-green-50 text-green-900">
                            KYC Verified <i class="bi bi-check2-circle"></i>
                        </span>
                    </p>
                @elseif($customerDetails->kyc_rejection === 1)
                    <p class="mb-3">User Verification Status:
                        <span class="p-1 text-sm rounded bg-pink-200 text-red-800">
                            KYC Rejected <i class="bi bi-file-earmark-x"></i>
                        </span>
                    </p>
                @endif

                <div class="bg-gray-600 w-fit p-1 rounded flex items-center flex-col mt-10">
                    <p class="text-center mb-2 text-black bg-gray-200 rounded p-1">
                        {{ $customerDetails->verification_type }}
                    </p>
                    <img src="{{ asset('uploads/' . $customerDetails->verification_file) }}" alt="" class="w-1/2">
                </div>

                <p class="mt-4 flex flex-wrap gap-3">
                    <a href="{{ route('AdmincustKycApprove', $customerDetails->custId) }}"
                        class="bg-blue-500 w-fit p-3 rounded">Approve</a>
                    <a href="{{ route('AdmincustKycReject', $customerDetails->custId) }}"
                        class="bg-red-500 w-fit p-3 rounded">Reject</a>
                </p>
            @else
                <p class="text-gray-300 bg-gray-500 rounded p-2 text-center">This user has not uploaded the KYC documents
                    yet.</p>
            @endif
        </div>
    </div>
@endsection
