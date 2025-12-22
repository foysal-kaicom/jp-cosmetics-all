@extends('master')

@section('contents')

<section class="w-full bg-white rounded-lg overflow-hidden shadow">
    <!-- Section Header -->
    <div class="px-4 py-2 flex items-center justify-between" style="background-color: rgb(81, 6, 92)">
        <h3 class="m-0 text-white text-sm md:text-base font-semibold">Role List</h3>

        @hasPermission('user.roles.create')
        <a href="{{ route('user.roles.create') }}"
           class="inline-flex items-center gap-2 rounded-md bg-blue-600 px-3 py-1.5 text-xs md:text-sm font-medium text-white hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-400">
            <i class="fa-solid fa-plus text-[0.8rem]"></i>
            <span>Create New Role</span>
        </a>
        @endHasPermission
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full text-left">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th scope="col" class="px-4 py-3 uppercase text-[11px] tracking-wide text-gray-500">ID</th>
                    <th scope="col" class="px-4 py-3 uppercase text-[11px] tracking-wide text-gray-500 hidden sm:table-cell">Name</th>
                    <th scope="col" class="px-4 py-3 uppercase text-[11px] tracking-wide text-gray-500 hidden md:table-cell">Status</th>
                    <th scope="col" class="px-4 py-3 uppercase text-[11px] tracking-wide text-gray-500 hidden md:table-cell">Permission</th>
                    <th scope="col" class="px-4 py-3 uppercase text-[11px] tracking-wide text-gray-500 hidden md:table-cell">Action</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @foreach($roles as $role)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm text-gray-800">{{ $role->id }}</td>

                    <td class="px-4 py-3 hidden sm:table-cell">
                        <span class="inline-flex items-center rounded-full bg-blue-600/10 text-blue-700 px-3 py-1 text-xs font-medium">
                            {{ $role->name }}
                        </span>
                    </td>

                    <td class="px-4 py-3 hidden md:table-cell text-sm text-gray-700">
                        {{ $role->status }}
                    </td>

                    <td class="px-4 py-3 hidden md:table-cell">
                        @hasPermission('user.roles.edit')
                        <a href="{{ route('user.roles.edit', $role->id) }}"
                           class="inline-flex items-center rounded-md bg-gray-900 px-2 py-1 text-xs font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400">
                           Assign permission
                        </a>
                        @endHasPermission
                    </td>

                    <td class="px-4 py-3 hidden md:table-cell">
                        @hasPermission('user.roles.toggleStatus')
                        <form action="{{ route('user.roles.toggleStatus', $role->id) }}" method="POST" class="inline-block">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center rounded-md px-4 py-1.5 text-xs font-semibold text-white focus:outline-none focus:ring-2 {{ $role->status == 'active' ? 'bg-gray-600 hover:bg-gray-500 focus:ring-gray-400' : 'bg-blue-600 hover:bg-blue-500 focus:ring-blue-400' }}"
                                onclick="return confirm('Are you sure you want to {{ $role->status == 'active' ? 'disable' : 'enable' }} this role?')">
                                {{ $role->status == 'active' ? 'Freeze' : 'De-freeze' }}
                            </button>
                        </form>
                        @endHasPermission
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

@endsection
