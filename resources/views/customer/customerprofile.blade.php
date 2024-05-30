@extends('customer.customerwelcome')

@section('customercontent')
    {{-- instead of writing $currentCustomerDetails->columnName, to access the current authenticated user details, pass the same thing from controller too the blade file using compact. --}}
    {{-- for this file, find the same thing in customerprofilecontroller.php --}}
    <div class="bg-gray-800 my-10 p-6 rounded-xl text-white">
        <h1 class="text-white font-bold text-3xl">Customer Profile</h1>
        <p class="bg-orange-50 text-orange-800 border-orange-500 px-3 py-2 text-sm rounded-r border-l-4 mt-2">
            Please contact admin
            to edit
            your
            email and other personal details. You can edit your username and phone for now.
        </p>


        {{-- if the currently authenticated customer column verification_file is empty --}}
        @if (!$currentCustomerDetails->verification_file)
            <p class="bg-pink-100 text-red-800 py-2 px-3 text-sm rounded-r border-l-4 border-red-600 mt-2">Verify your KYC
                documents
                before placing your order.
            </p>
        @endif

        {{-- if the customer uploads file, accepted, rejected or verification is pending, show this message. --}}
        @if (
            $currentCustomerDetails->verification_status == 0 and
                $currentCustomerDetails->kyc_rejection === null and
                $currentCustomerDetails->verification_file)
            <p class="bg-blue-100 text-blue-800 py-2 px-3 rounded-r border-l-4 border-blue-600 mt-2 text-sm font-semibold">
                Your KYC documents are under verification process.
                <i class="bi bi-hourglass-split"></i>
            </p>
        @elseif($currentCustomerDetails->verification_status == 0 and $currentCustomerDetails->kyc_rejection === 1)
            <p class="bg-pink-100 text-red-800 py-2 px-3 rounded-r border-l-4 border-red-600 mt-2 text-sm font-semibold">
                Your KYC documents are rejected, please upload valid KYC documents again!
            </p>
        @endif
        {{-- if the username upload success and returns back with this session, display the below p tag. --}}
        @if (session('customerDetailsUpdated'))
            <p class="text-green-800 bg-green-50 py-1 px-3 rounded-r border-l-4 border-green-500 mt-2">Username updated
                successfully.</p>
        @endif

        @if (session('cust_verification_file_deleted'))
            <p class="bg-green-50 mt-2 border-l-4 border-green-800 py-2 px-3 text-green-800">KYC file deleted
                successfully.
            </p>
        @endif

        @if (session('customer_profile_pic_uploaded'))
            <p class="bg-green-50 mt-2 border-l-4 border-green-800 py-2 px-3 text-green-800">Profile picture uploaded
                successfully.
            </p>
        @endif

        @if (session('customer_profile_pic_deleted'))
            <p class="bg-green-50 mt-2 border-l-4 border-green-800 py-2 px-3 text-green-800">Profile picture deleted.</p>
        @endif

        @if ($errors->any())
            <div class="text-red-800 bg-red-100 rounded-lg mt-2 text-md px-3 py-3 border-2 border-red-800">
                @foreach ($errors->all() as $e)
                    {{ $e }} <Br>
                @endforeach
            </div>
        @endif


        {{-- showing user details, user can edit their username --}}
        <div class="flex flex-col lg:w-1/2 w-full mx-auto bg-slate-700 p-3 rounded mt-10">
            <h1 class="text-2xl font-semibold mb-5">Customer Details</h1>


            @if ($currentCustomerDetails->profile_pic)
                <h1 class="font-semibold">Profile Picture</h1>
                <div class="flex flex-col items-center w-fit gap-2 border-2 border-yellow-600 rounded">
                    <img src="{{ asset('uploads/' . $currentCustomerDetails->profile_pic) }}" alt="testing"
                        class="rounded-full border-2 border-green-500 w-20 mt-5 mx-3">
                    <hr class="border-yellow-500 border w-full text-yellow-500">
                    <a href="{{ route('delete_cust_profile_pic') }}" class="mb-2"><i
                            class="bi bi-trash text-red-500 hover:bg-white rounded text-xl bg-red-500 text-white px-1 hover:text-red-500"></i></a>
                </div>
            @else
                <div class="mt-5">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Upload
                        Profile Picture</label>
                    <form action="{{ route('upload_customer_profile_pic') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input name='customer_profile_pic'
                            class="block w-1/2 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                            aria-describedby="file_input_help" id="file_input" type="file">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-500" id="file_input_help">PNG, JPG or JPEG</p>
                        <button type="submit" class="flex flex-wrap bg-blue-500 py-2 px-3 rounded w-fit">Upload</button>
                    </form>
                </div>
            @endif

            <hr class="my-3">

            <form class="" action="{{ route('UpdateCustomerDetails') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <p class="justify-between flex items-center">
                    Customer Id: <input disabled type="text" value="{{ $currentCustomerDetails->custId }}"
                        class="bg-gray-600 text-gray-400 placeholder-white rounded-md bg-opacity-50">
                </p>
                <p class="mt-3 justify-between flex items-center">
                    Wallet Id: <input disabled type="text" value="{{ $currentCustomerDetails->wallet->wallet_id }}"
                        class="bg-gray-600 text-gray-400 placeholder-white rounded-md bg-opacity-50" />


                <p class="mt-3 justify-between flex items-center">
                    User Name: <input disabled type="text" value="{{ $currentCustomerDetails->name }}"
                        class="bg-gray-600 text-gray-400 placeholder-white rounded-md bg-opacity-50 ">
                </p>


                <p class="mt-3 justify-between flex items-center">
                    Update User Name: <input type="text" placeholder="Enter new Username" name="username"
                        class="bg-gray-800 text-white placeholder-gray-400 rounded-md border-2 border-gray-600 focus:bg-gray-900 focus:border-blue-500">
                </p>
                <div class="text-rose-500 text-sm">{{ $errors->first('username') }}</div>

                <p class="mt-3 justify-between flex items-center">
                    Current Email: <input disabled type="text" value="{{ $currentCustomerDetails->email }}"
                        class="bg-gray-600 text-gray-400 placeholder-white rounded-md bg-opacity-50">
                </p>
                <p class="mt-3 justify-between flex items-center">
                    Current Phone: <input disabled type="text" value="{{ $currentCustomerDetails->phone }}"
                        class="bg-gray-600 text-gray-400 placeholder-white rounded-md bg-opacity-50">
                </p>
                <p class="mt-3 justify-between flex items-center">
                    Update Phone: <input type="text" placeholder="Enter new Phone" name="phone"
                        class="bg-gray-800 text-white placeholder-gray-400 rounded-md border-2 border-gray-600 focus:bg-gray-900 focus:border-blue-500">
                </p>
                <div class="text-rose-500 text-sm">{{ $errors->first('phone') }}</div>

                <button class=" mt-5 bg-blue-500 p-2 w-fit px-10 rounded-md" type="submit">Save</button>
            </form>
        </div>

        <hr class="my-5">

        {{-- verification file upload form --}}
        <form action="{{ route('customerDocVerification') }}" method="POST" enctype="multipart/form-data"
            class="lg:w-1/2 w-full mx-auto bg-slate-700 p-3 rounded">
            @csrf
            <h1 class="text-2xl font-semibold mb-5">KYC Verification
                {{-- checking igf user verification status is 1 or 0 ie true or false true(1) displays green --}}
                @if ($currentCustomerDetails->verification_status)
                    <span class="text-green-500 text-lg">Verified<i class="bi bi-check2-circle text-green-500 text-xl"></i>
                    </span>
                @else
                    <i class="bi bi-x-circle text-red-500 text-xl"></i>
                @endif
            </h1>

            <div class="flex flex-col">
                <p class="bg-orange-100 text-orange-800 rounded p-1 text-sm">
                    <i class="bi bi-exclamation-triangle-fill text-red-500"></i>
                    &nbsp;Please do not delete the KYC documents once verified,
                    else you need to verify again.
                </p>
                @if (!$currentCustomerDetails->verification_file)
                    <div class="mt-5">
                        <label for="doc" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Select
                            Document
                            Type<span class="text-red-500">*</span></label>
                        <select id="doc" name="documentType"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option selected disabled>Type of Document</option>
                            <option value="driving">Driving Lisence</option>
                            <option value="aadhar">Aadhar Card</option>
                            <option value="pan">PAN Card</option>
                        </select>
                        <div class="text-rose-500 text-sm">{{ $errors->first('documentType') }}</div>
                    </div>

                    <p class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400 mt-2">Upload
                        file<span class="text-red-500">*</span></p>
                    <input name="document"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-slate-600 dark:border-gray-600 dark:placeholder-gray-400"
                        type="file">
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-500" id="file_input_help">JPEG, PNG, JPG</p>
                    <div class="text-rose-500 text-sm">{{ $errors->first('document') }}</div>

                    <button type="submit" class="bg-blue-500 rounded py-2 px-3 w-fit mt-5">Submit</button>
                @else
                    <p class="text-gray-400">Here are the documents you submitted for verification.</p>
                    <div class="bg-gray-500 w-fit flex items-center flex-col p-1 rounded mt-3">
                        <img src="{{ asset('uploads/' . $currentCustomerDetails->verification_file) }}" alt=""
                            class="h-24 w-24">
                        <a href="{{ route('CustomerDeleteVerificationFile') }}" class="mt-2"><i
                                class="bi bi-trash hover:text-rose-400 hover:bg-white p-1 flex flex-wrap bg-gray-600 rounded"></i></a>
                    </div>
                @endif
            </div>

        </form>


    </div>
@endsection
