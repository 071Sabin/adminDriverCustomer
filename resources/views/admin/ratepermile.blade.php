@extends('admin.adminwelcome')

@section('admincontent')
    <div class="bg-gray-800 my-10 p-6 rounded-xl">
        <h1 class="text-white font-bold text-2xl">Rate Per Mile</h1>

        @if (session('success'))
            <p class="bg-green-50 text-green-900 py-3 px-3 rounded-md mt-2 border-2  border-green-900">
                New Rate Per Mile <strong>Rs. {{ session('success') }}/-</strong> is updated successfully.
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
        <form method="POST" action="{{ route('ratepermile') }}" class="bg-slate-700 p-5 mt-10 rounded-md">
            @csrf

            @foreach ($rate as $r)
                <div class="p-6 rounded-lg">
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="border p-4 rounded-lg">
                            <p class="text-gray-300 text-sm font-bold">Previous Rate</p>
                            <p class="text-lg text-red-500 font-semibold">Rs {{ $r->last_rate }}/-</p>
                        </div>
                        <div class="border p-4 rounded-lg">
                            <p class="text-gray-300 text-sm font-bold">Current Rate</p>
                            <p class="text-lg text-green-500 font-semibold">Rs {{ $r->current_rate }}/-</p>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="form-group mt-3">
                <label for="rate" class="text-lg">New Rate:</label>
                <input type="number" step="0.01" name="rate" id="rate" placeholder="Enter New Rate/Mile"
                    class="form-control ml-3 text-gray-200 bg-gray-600 focus:border-0 rounded-lg" required>
            </div>

            <button type="submit" class="text-md bg-blue-600 px-3 py-3 mt-7 rounded-lg hover:bg-blue-700">Update
                Rate</button>

        </form>
    </div>
@endsection
