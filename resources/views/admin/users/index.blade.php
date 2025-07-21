@extends('layouts.admin')

@section('title', 'Manage Users')

@section('content')
<div class="glass-effect rounded-lg overflow-hidden shadow-lg border border-gray-800 p-6">
    <div class="flex justify-between items-center">
        <h3 class="text-xl font-medium text-white">User Management</h3>
        <a href="{{ route('admin.users.create') }}" class="px-4 py-2 bg-accent-teal hover:bg-primary-500 text-white rounded-md transition duration-200">
            <div class="flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add User
            </div>
        </a>
    </div>
    
    <div class="mt-6">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-900 bg-opacity-20 border border-green-800 text-green-300 rounded-md">
                {{ session('success') }}
            </div>
        @endif
        
        <div class="flex justify-between items-center mb-4">
            <div class="flex border-b border-gray-700">
                <button class="px-3 py-2 border-b-2 {{ request()->get('filter') !== 'admin' ? 'border-accent-teal text-accent-teal' : 'border-transparent text-gray-400 hover:text-gray-300 hover:border-gray-600' }}" onclick="window.location='{{ route('admin.users.index') }}'">
                    All Users
                </button>
                <button class="ml-4 px-3 py-2 border-b-2 {{ request()->get('filter') === 'admin' ? 'border-accent-teal text-accent-teal' : 'border-transparent text-gray-400 hover:text-gray-300 hover:border-gray-600' }}" onclick="window.location='{{ route('admin.users.index', ['filter' => 'admin']) }}'">
                    Administrators
                </button>
            </div>
            
            <form action="{{ route('admin.users.index') }}" method="GET" class="flex items-center">
                @if(request()->has('filter'))
                    <input type="hidden" name="filter" value="{{ request()->get('filter') }}">
                @endif
                <div class="relative">
                    <input type="text" name="search" placeholder="Search users" value="{{ request()->get('search') }}" 
                          class="bg-darker border border-gray-700 rounded-md w-full py-2 pl-3 pr-10 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent-teal focus:border-transparent">
                    <button type="submit" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-accent-teal">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead>
                    <tr>
                        <th scope="col" class="px-6 py-3 bg-card bg-opacity-50 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                            User
                        </th>
                        <th scope="col" class="px-6 py-3 bg-card bg-opacity-50 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3 bg-card bg-opacity-50 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                            Role
                        </th>
                        <th scope="col" class="px-6 py-3 bg-card bg-opacity-50 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                            Registered
                        </th>
                        <th scope="col" class="px-6 py-3 bg-card bg-opacity-50 text-right text-xs font-medium text-gray-400 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach($users as $user)
                        <tr class="hover:bg-card hover:bg-opacity-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if($user->profile_picture)
                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-secondary-400 bg-opacity-20 flex items-center justify-center text-secondary-400 font-semibold">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-white">
                                            {{ $user->name }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-300">{{ $user->email }}</div>
                                <div class="text-xs">
                                    @if($user->email_verified_at)
                                        <span class="text-green-400 flex items-center mt-1">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            Verified
                                        </span>
                                    @else
                                        <span class="text-yellow-400 flex items-center mt-1">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Not verified
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($user->is_admin)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-secondary-400 bg-opacity-20 text-secondary-400">
                                        Administrator
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-accent-teal bg-opacity-20 text-accent-teal">
                                        Customer
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.users.edit', $user) }}" class="text-accent-teal hover:text-accent-light mr-3" title="Edit User">
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                
                                @if(auth()->id() !== $user->id)
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-400" title="Delete User">
                                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">
            {{ $users->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection