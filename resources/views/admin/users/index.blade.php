<x-admin-layout pageTitle="User Management">
    <div class="admin-card">
        <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap mb-4">
            <div>
                <div class="admin-kicker">Directory</div>
                <h3 class="h4 mb-1">All users</h3>
                <p class="text-muted mb-0">Manage user roles, review signups, and keep access levels organized.</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table admin-table align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Joined</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td class="text-muted small">{{ $user->id }}</td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $user->name }}</div>
                            </td>
                            <td class="text-muted small">{{ $user->email }}</td>
                            <td>
                                <span class="badge rounded-pill
                                    {{ $user->role === 'admin' ? 'bg-danger' : '' }}
                                    {{ $user->role === 'manager' ? 'bg-warning text-dark' : '' }}
                                    {{ $user->role === 'moderator' ? 'bg-info text-dark' : '' }}
                                    {{ $user->role === 'student' ? 'bg-secondary' : '' }}
                                ">{{ ucfirst($user->role) }}</span>
                            </td>
                            <td class="small text-muted">{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 me-1">Edit</a>
                                @if(auth()->id() !== $user->id)
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Delete user {{ $user->name }}?')">Delete</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pt-3">
            {{ $users->links() }}
        </div>
    </div>
</x-admin-layout>
