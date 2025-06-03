<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Contacts') }}
            </h2>
            <a href="{{ route('contacts.create') }}">Add New Contact</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <form method="GET" action="{{ route('contacts.index') }}" class="mb-4">
                    <div class="flex justify-end gap-2">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search contacts..."
                            class="text-gray-700 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400" />
                        <button type="submit" class="bg-primary text-white px-4 py-2 rounded">Search</button>
                    </div>
                </form>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg sm:px-6 lg:px-8 py-4">

                @if (session('success'))
                    <div class="mb-4 p-4 rounded text-green-800 bg-green-100 border border-green-300">{{ session('success') }}</div>
                @endif

                <table class="min-w-full table-auto border border-gray-300 rounded-md overflow-hidden shadow-sm">
                    <thead class="bg-gray-100 text-gray-700 text-left text-sm uppercase font-semibold">
                        <tr>
                            <th class="px-4 py-3 border-b">Name</th>
                            <th class="px-4 py-3 border-b">Phone</th>
                            <th class="px-4 py-3 border-b text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-700">
                        @forelse ($contacts as $contact)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 border-b">{{ $contact->name }}</td>
                                <td class="px-4 py-3 border-b">{{ $contact->phone }}</td>
                                <td class="px-4 py-3 border-b text-center">
                                    <a href="{{ route('contacts.edit', $contact->_id) }}" class="inline-block bg-yellow-400 text-white px-3 py-1 text-xs font-semibold rounded hover:bg-yellow-500 mr-1">Edit</a>
                                    <form action="{{ route('contacts.destroy', $contact->_id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="bg-red-500 text-white px-3 py-1 text-xs font-semibold rounded hover:bg-red-600">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-3 text-center text-gray-500">No contacts found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $contacts->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>