@extends('admin.layouts.app')

@section('content')
<h2 class="text-xl font-semibold mb-4">User Management</h2>
<div class="overflow-x-auto">
<table class="w-full text-sm">
    <thead><tr class="text-left border-b border-slate-700"><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th>Actions</th></tr></thead>
    <tbody>
    @foreach($users as $user)
        <tr class="border-b border-slate-800">
            <td class="py-2">{{ $user->name }}</td><td>{{ $user->email }}</td><td>{{ $user->role }}</td><td>{{ $user->is_blocked ? 'Blocked' : 'Active' }}</td>
            <td class="space-x-2">
                <form class="inline" method="POST" action="{{ route('admin.users.role', $user) }}">@csrf @method('PATCH')
                    <select name="role" class="bg-slate-800 rounded"><option>user</option><option>organizer</option><option>admin</option></select>
                    <button class="px-2 py-1 bg-cyan-700 rounded">Save</button>
                </form>
                <form class="inline" method="POST" action="{{ route('admin.users.toggleBlock', $user) }}">@csrf @method('PATCH')
                    <button class="px-2 py-1 bg-rose-700 rounded">Toggle Block</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>
{{ $users->links() }}
@endsection
