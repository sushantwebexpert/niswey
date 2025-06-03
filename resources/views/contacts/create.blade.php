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
                {{ __('Add New Contact') }}
            </h2>
            <a href="{{ route('contacts.index') }}">Back to Contacts</a>
        </div>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if(session('success'))
                    <div class="mb-4 p-4 rounded text-green-800 bg-green-100 border border-green-300">{{ session('success') }}</div>
                @endif
                
                <div class="flex flex-col md:flex-row gap-6">
                    <!-- Left Section -->
                    <div class="md:w-1/2 w-full px-12">
                        <form action="{{ route('contacts.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-4">
                                <label class="block text-sm font-bold mb-1 uppercase  text-gray-700 text-left text-sm">Name</label>
                                <input type="text" name="name" class="text-gray-700 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400" required>
                                @error('name')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-bold mb-1 uppercase  text-gray-700 text-left text-sm">Phone</label>
                                <input type="text" name="phone" class="text-gray-700 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400" required>
                                @error('phone')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex gap-4">
                                <button class="bg-primary hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Save</button>
                            </div>
                        </form>
                    </div>

                    <!-- Right Section -->
                    <div class="md:w-1/2 w-full px-12">
                        <form id="xml-import-form" action="{{ route('contacts.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-4">
                                <label class="block text-sm font-bold mb-1 uppercase  text-gray-700 text-left text-sm">Import from XML</label>
                                <input type="file" name="xml_file" accept=".xml" class="text-gray-700 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400" required>
                            </div>

                            <div class="mb-4 hidden" id="progress-wrapper">
                                <label class="block text-sm font-bold mb-1 uppercase  text-gray-700 text-left text-sm">Uploading...</label>
                                <div class="w-full bg-gray-200 rounded h-4">
                                    <div id="progress-bar" class="bg-blue-600 h-4 rounded" style="width: 0%"></div>
                                </div>
                                <div class="text-sm text-gray-700 mt-1" id="progress-text">0%</div>
                            </div>

                            <button type="submit" class="bg-primary hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Import</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>