@extends('admin.adminwelcome')

@section('admincontent')
    <div class="bg-gray-800 my-10 p-6 rounded-xl">
        <h1 class="text-white font-bold text-2xl">Minimum Charges</h1>

        @if (session('success'))
            <p class="bg-green-50 text-green-900 py-3 px-3 rounded-md mt-2 border-2  border-green-900">

                {{-- here session('success') displays the messsage whatever is there in with() function in return type of a function in controller, this controller is minchargescontroller.php --}}
                New Minimum Charge <strong>Rs. {{ session('success') }}/-</strong> is updated successfully.
            </p>
        @endif

        @if ($errors->any())
            <div class="text-red-800 bg-red-100 rounded-lg mt-10 text-md px-3 py-3 border-2 border-red-800">
                @foreach ($errors->all() as $e)
                    {{ $e }} <Br>
                @endforeach
            </div>
        @endif

        {{-- {{ route('ratepermile') }} --}}
        <!-- Form to update rate   -->
        <form method="POST" action="{{ route('showmincharge') }}" class="bg-slate-700 p-5 mt-10 rounded-md">
            @csrf

            @foreach ($charge as $c)
                <div class="p-6 rounded-lg">
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="border p-4 rounded-lg">
                            <p class="text-gray-300 text-sm font-bold">Previous Min. Charge</p>
                            <p class="text-lg text-red-500 font-semibold">Rs {{ $c->last_min_charge }}/-</p>
                        </div>
                        <div class="border p-4 rounded-lg">
                            <p class="text-gray-300 text-sm font-bold">Current Min. Charge</p>
                            <p class="text-lg text-green-500 font-semibold">Rs {{ $c->current_min_charge }}/-</p>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="form-group mt-3">
                <label for="rate" class="text-md">New Minimum Charge:</label>
                <input type="number" step="0.01" name="charge" id="charge" placeholder="enter new min. charge"
                    class="form-control ml-3 text-gray-200 bg-gray-600 focus:border-0 rounded-lg" required>
            </div>

            <button type="submit" class="text-md bg-blue-600 px-3 py-3 mt-8 rounded-lg hover:bg-blue-700">Update
                Minimum Charge</button>

        </form>
    </div>
@endsection
