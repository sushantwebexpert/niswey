<x-app-layout>
    <div 
        x-data="{ show: false, message: '', type: 'success' }"
        x-show="show"
        x-transition
        x-init="window.addEventListener('toast', e => { 
            type = e.detail.type;
            message = e.detail.message; 
            show = true;
            setTimeout(() => show = false, 4000);
        })"
        :class="type === 'success' ? 'bg-green-500' : 'bg-red-500'"
        class="fixed top-4 right-4 text-white px-4 py-2 rounded shadow-lg z-50"
        style="display: none;"
    >
        <span x-text="message"></span>
    </div>

    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Contact') }}
            </h2>
            <a href="{{ route('contacts.index') }}">Back to Contacts</a>
        </div>
    </x-slot>

    <div class="py-12">
         <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 lg:px-6">
                <div class="px-12">
                    <form action="{{ route('contacts.update', $contact->_id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="block text-sm font-bold mb-1 uppercase  text-gray-700 text-left text-sm">Name</label>
                            <input type="text" name="name" class="text-gray-700 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400" value="{{ $contact->name }}" required>
                            @error('name')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold mb-1 uppercase  text-gray-700 text-left text-sm">Phone</label>
                            <input type="text" name="phone" class="text-gray-700 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400" value="{{ $contact->phone }}" required>
                            @error('phone')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="flex gap-4">
                            <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>