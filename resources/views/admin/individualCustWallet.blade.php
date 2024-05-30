@extends('admin.adminwelcome')


@section('admincontent')
    <div class="bg-gray-800 my-10 p-6 rounded-xl">
        <h1 class="text-3xl font-bold mb-10">Customer Wallet Update</h1>
        {{-- showing the success message for remove/add to the wallet --}}
        @if (session('removesuccess'))
            <P class="bg-green-50 text-green-900 px-5 py-2 rounded-md text-md mt-4">Balance of Rs.
                <strong>{{ session('removesuccess') }}/-</strong>
                removed from wallet successfully.
            </P>
        @endif

        @if (session('addsuccess'))
            <P class="bg-green-50 text-green-900 px-5 py-2 rounded-md text-md mt-4">Balance of Rs.
                <strong>{{ session('addsuccess') }}/-</strong>
                added to wallet successfully.
            </P>
        @endif

        @if ($errors->any())
            <div class="text-red-800 bg-red-100 rounded-lg mt-10 text-md px-3 py-3 border-2 border-red-800">
                @foreach ($errors->all() as $e)
                    {{ $e }} <Br>
                @endforeach
            </div>
        @endif

        <div class=" grid grid-cols-1 lg:grid-cols-2">
            <div>
                {{-- this <a> tag is to return tothe table that shows all customer wallets  --}}
                <a href="{{ route('customerwallet') }}" class="text-blue-500">--- Return to Customer Wallet table---</a>


                {{-- taking individual customer details from the db, this is coming from walletcontroller.php --> IndividualCustWallet(Request $request, $wallet) function --}}
                {{-- using for loop, accessing the individual customer details --}}
                <h2 class="font-semibold">Customer details</h2>
                @foreach ($custWalletDetails as $IndCustDetails)
                    <table class="border border-gray-200 mt-3">
                        <tr class="border-b border-gray-200">
                            <td class="p-2">Customer Name</td>
                            <td class="p-2 border-l border-gray-200">{{ $IndCustDetails->name }}</td>
                        </tr>
                        <tr class="border-b border-gray-200">
                            <td class="p-2">Customer Id</td>
                            <td class="p-2 border-l border-gray-200">{{ $IndCustDetails->custId }}</td>
                        </tr>
                        <tr class="border-b border-gray-200">
                            <td class="p-2">Customer wallet Id</td>
                            <td class="p-2 border-l border-gray-200">{{ $IndCustDetails->wallet_id }}</td>
                        </tr>
                        <tr class="border-b border-gray-200">
                            <td class="p-2">Current Balance</td>
                            <td class="p-2 border-l border-gray-200">Rs. {{ $IndCustDetails->balance }}/-</td>
                        </tr>
                    </table>
                @endforeach
            </div>

            <form action="{{ route('IndividualCustWallet', $IndCustDetails->wallet_id) }}"
                class="pt-6 mt-6 border-t border-gray-100 lg:pt-0 lg:mt-0 lg:border-none" method="POST"
                enctype="multipart/form-data">

                @csrf
                @method('PUT')
                <h1 class="text-xl font-semibold">Update Balance</h1>
                <div>
                    <div class="grid gap-3 grid-cols-1 lg:grid-cols-2 mt-2">
                        <input type="number" step="0.01" name='newbalance' placeholder="Enter New Balance"
                            class="text-gray-200 rounded-md bg-gray-500">

                        <select id="transaction_type" name="transaction_type"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option selected disabled>Transaction Type</option>
                            <option value="add">Add</option>
                            <option value="remove">Remove</option>
                            <option value="refund">Refund</option>
                            <option value="transfer">Transfer</option>
                        </select>

                        <select id="currency" name="currency"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option selected disabled class="">Select Currency</option>
                            <option value="inr">INR &#8377;</option>
                            <option value="npr">NPR रू</option>
                            <option value="usd">USD $</option>
                            <option value="eur">EUR €</option>
                            <option value="gbp">GBP £</option>
                            <option value="jpy">JPY ¥</option>
                            <option value="aud">AUD $</option>
                            <option value="cad">CAD $</option>
                            <option value="chf">CHF Fr.</option>
                            <option value="cny">CNY ¥</option>
                            <option value="sgd">SGD $</option>
                        </select>

                        <select id="transaction_status" name="transaction_status"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option selected disabled class="">Transaction-Status</option>
                            <option value="failed">Failed</option>
                            <option value="success">Success</option>
                            <option value="pending">Pending</option>
                        </select>

                    </div>
                    <textarea name="description" id="description" cols="30" rows="5" name="description"
                        class="bg-gray-500 rounded-md px-2 w-full mt-3 py-1" placeholder="Description of the transaction.........."></textarea>
                </div>
                <div class="flex gap-3 mt-6">
                    <button class="py-2 px-3 bg-green-500 rounded-md" value="add" name="btn_updatebalance"
                        type="submit">Add
                        balance</button>
                    <button class="py-2 px-3 bg-red-500 rounded-md" value="remove" name="btn_updatebalance"
                        type="submit">Remove
                        balance</button>
                </div>
            </form>
        </div>


        <div class="mt-10 pt-10 border-t border-gray-500">
            <h1 class="text-3xl font-bold mb-5 text-center underline">Transactions</h1>
            {{-- check if the returned value is zero, if zero there is no data in table --}}
            {{-- this thing to count() is already checked in walletcontroller.php/customerwallet() function, but still for good practice and knowledge we did this --}}
            @if (count($custTransDetails) > 0)
                <table class="w-full text-center text-gray-300 table-auto text-sm md:text-md">
                    <tr class="text-sm md:text-md bg-gray-900 border-b-2 border-gray-100">
                        <th class="py-4 px-1 border-r border-gray-600">S.no</th>
                        <th class="border-r border-gray-600">t_id</th>
                        <th class="border-r border-gray-600">transaction<br>Type</th>
                        <th class="border-r border-gray-600">Previous<br>balance</th>
                        <th class="border-r border-gray-600">Updated<br>balance</th>
                        <th class="border-r border-gray-600">Currency</th>
                        <th class="border-r border-gray-600">description</th>
                        <th class="border-r border-gray-600">status</th>
                        <th class="border-r border-gray-600">p.Gateway<br>id</th>
                        <th class="border-r border-gray-600">reference<br>id</th>
                        <th class="">Date</th>
                    </tr>

                    {{-- accessing cust_wallet1 variable using for loop, this cust_wallet1 has list of customer wallet rows. --}}
                    @foreach ($custTransDetails as $transDetails)
                        <tr class="border-b border-gray-500 bg-slate-700">
                            <td class=" border-r border-gray-600 px-2 md:py-2 md:px-0">{{ $transDetails->id }}</td>
                            <td class=" border-r border-gray-600 px-2 md:py-2 md:px-0">{{ $transDetails->transaction_id }}
                            </td>

                            @if ($transDetails->transaction_type === 'remove')
                                <td class="border-r border-gray-600 px-2 md:p-0 bg-red-100 text-red-800">
                                    {{ $transDetails->transaction_type }}</td>
                            @elseif(
                                $transDetails->transaction_type === 'add' ||
                                    $transDetails->transaction_type === 'refund' ||
                                    $transDetails->transaction_type === 'transfer')
                                <td class="border-r border-gray-600 px-2 md:p-0 bg-green-100 text-green-800">
                                    {{ $transDetails->transaction_type }}</td>
                            @endif


                            {{-- making the walletid clickable and  route with walletid, we can remove "$wallet-> " this thing and just put wallet_id  --}}
                            {{-- this will pass the wallet_id from the db that we are accessing using this forloop to the url in web.php {walletid} to make unique url for every customer wallets. --}}
                            <td class="border-r border-gray-600 px-2 md:p-0">{{ $transDetails->previous_balance }}</td>
                            <td class="border-r border-gray-600 px-2 md:p-0">{{ $transDetails->updated_balance }}</td>
                            <td class="border-r border-gray-600">{{ $transDetails->currency }}</td>
                            <td class="border-r border-gray-600">{{ $transDetails->description }}</td>

                            <td class="border-r border-gray-600">{{ $transDetails->status }}</td>

                            <td class="border-r border-gray-600">{{ $transDetails->payment_gateway_id }}</td>
                            <td class="border-r border-gray-600">{{ $transDetails->reference_id }}</td>
                            <td class="">{{ $transDetails->updated_at }}</td>
                        </tr>
                    @endforeach

                </table>
            @else
                {{-- this will be displayed if the customer wallet table is empty --}}
                <p class="bg-gray-700 text-gray-300 mt-5 text-center py-2 rounded-lg">There is no any transactions for this
                    customer.
                </p>
            @endif
        </div>

    </div>
@endsection
