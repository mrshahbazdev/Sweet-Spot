<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

new class extends Component {
    use WithPagination;

    public $search = '';
    public $isInviteModalOpen = false;
    public $activeTab = 'all';

    public $inviteEmail = '';
    public $inviteRole = '';

    public $isEditModalOpen = false;
    public $editingUserId = null;
    public $editName = '';
    public $editEmail = '';
    public $editRole = '';

    public $isDeleteModalOpen = false;
    public $userToDelete = null;

    public function with()
    {
        $userId = auth()->id();

        $baseQuery = User::where(function ($q) use ($userId) {
            $q->where('id', $userId)->orWhere('parent_id', $userId);
        });

        $query = clone $baseQuery;

        if ($this->activeTab === 'admins') {
            $query->whereHas('roles', function ($q) {
                $q->where('name', 'Admin');
            });
        }

        return [
            'members' => $query->with('roles')
                ->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                })
                ->paginate(10),
            'availableRoles' => Role::all(),
            'totalMembers' => (clone $baseQuery)->count(),
            'adminsCount' => (clone $baseQuery)->whereHas('roles', function ($q) {
                $q->where('name', 'Admin');
            })->count(),
            'viewersCount' => (clone $baseQuery)->whereHas('roles', function ($q) {
                $q->where('name', 'Viewer');
            })->count(),
        ];
    }

    public function sendInvite()
    {
        $this->validate([
            'inviteEmail' => 'required|email|unique:users,email',
            'inviteRole' => 'required|exists:roles,id',
        ]);

        $user = User::create([
            'parent_id' => auth()->id(),
            'name' => explode('@', $this->inviteEmail)[0],
            'email' => $this->inviteEmail,
            'password' => Hash::make(Str::random(12)), // Random password initially
        ]);

        $user->roles()->attach($this->inviteRole);

        // Normally we would send an email here using Laravel Notifications.
        session()->flash('message', 'Invitation created for ' . $this->inviteEmail);

        $this->reset(['inviteEmail', 'inviteRole', 'isInviteModalOpen']);
    }

    public function openEditModal($id)
    {
        $user = User::findOrFail($id);

        if ($user->id !== auth()->id() && $user->parent_id !== auth()->id()) {
            return;
        }

        $this->editingUserId = $user->id;
        $this->editName = $user->name;
        $this->editEmail = $user->email;
        $this->editRole = $user->roles->first()->id ?? '';
        $this->isEditModalOpen = true;
    }

    public function updateMember()
    {
        $this->validate([
            'editName' => 'required|string|max:255',
            'editEmail' => 'required|email|unique:users,email,' . $this->editingUserId,
            'editRole' => 'required|exists:roles,id',
        ]);

        $user = User::findOrFail($this->editingUserId);
        if ($user->id !== auth()->id() && $user->parent_id !== auth()->id()) {
            return;
        }

        $user->update([
            'name' => $this->editName,
            'email' => $this->editEmail,
        ]);

        $user->roles()->sync([$this->editRole]);

        session()->flash('message', 'Member updated successfully.');
        $this->reset(['isEditModalOpen', 'editingUserId', 'editName', 'editEmail', 'editRole']);
    }

    public function confirmDelete($id)
    {
        $this->userToDelete = $id;
        $this->isDeleteModalOpen = true;
    }

    public function deleteMember()
    {
        if ($this->userToDelete && auth()->id() !== $this->userToDelete) {
            $user = User::findOrFail($this->userToDelete);
            if ($user->parent_id === auth()->id()) {
                $user->delete();
                session()->flash('message', 'Member removed.');
            }
        }
        $this->isDeleteModalOpen = false;
        $this->userToDelete = null;
    }
};
?>

<div>
    @section('title', 'Team Management')

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
        <div class="space-y-1">
            <h1 class="text-4xl font-black text-slate-900 dark:text-white tracking-tight leading-tight">Team Management
            </h1>
            <p class="text-slate-500 dark:text-slate-400 text-lg">Manage your team members, roles, and access
                permissions.</p>
        </div>
        <button wire:click="$set('isInviteModalOpen', true)"
            class="flex items-center gap-2 px-6 py-3 bg-primary hover:bg-primary/90 text-white font-bold rounded-xl transition-all shadow-lg shadow-primary/20">
            <span class="material-symbols-outlined text-lg">person_add</span>
            Invite Member
        </button>
    </div>

    @if (session()->has('message'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
            <span class="font-medium">Success!</span> {{ session('message') }}
        </div>
    @endif

    <!-- Summary Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined">group</span>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Total Members</p>
                    <p class="text-3xl font-bold text-slate-900">{{ $totalMembers }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center text-blue-500">
                    <span class="material-symbols-outlined">admin_panel_settings</span>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Admins</p>
                    <p class="text-3xl font-bold text-slate-900">{{ $adminsCount }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-amber-500/10 rounded-xl flex items-center justify-center text-amber-500">
                    <span class="material-symbols-outlined">visibility</span>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Viewers</p>
                    <p class="text-3xl font-bold text-slate-900">{{ $viewersCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 shadow-xl overflow-hidden">
        <div class="p-6 border-b border-slate-200 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4 overflow-x-auto pb-2 md:pb-0">
                <button wire:click="$set('activeTab', 'all')"
                    class="px-4 py-2 {{ $activeTab === 'all' ? 'bg-primary/10 text-primary' : 'text-slate-500 hover:bg-slate-100' }} text-sm font-bold rounded-full whitespace-nowrap transition-colors">All
                    Members</button>
                <button wire:click="$set('activeTab', 'admins')"
                    class="px-4 py-2 {{ $activeTab === 'admins' ? 'bg-primary/10 text-primary' : 'text-slate-500 hover:bg-slate-100' }} text-sm font-bold rounded-full transition-colors whitespace-nowrap">Admins</button>
            </div>
            <div class="relative min-w-[300px]">
                <span
                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
                <input wire:model.live="search"
                    class="w-full pl-10 pr-4 py-2 bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-primary/30 text-sm"
                    placeholder="Search members by name or email..." type="text" />
            </div>
        </div>

        <!-- Members Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Member</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Joined</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($members as $member)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="h-10 w-10 rounded-full bg-primary/20 flex items-center justify-center font-bold text-primary">
                                        {{ strtoupper(substr($member->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-900">{{ $member->name }}</p>
                                        <p class="text-xs text-slate-500">{{ $member->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @forelse($member->roles as $role)
                                    <span
                                        class="px-3 py-1 bg-{{ $role->name == 'Admin' ? 'blue' : 'slate' }}-100 text-{{ $role->name == 'Admin' ? 'blue' : 'slate' }}-600 text-xs font-bold rounded-full">{{ $role->name }}</span>
                                @empty
                                    <span class="text-xs text-slate-400">None</span>
                                @endforelse
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                    <span class="text-sm font-medium text-slate-700">Active</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500">{{ $member->created_at->diffForHumans() }}</td>
                            <td class="px-6 py-4 text-right">
                                <button wire:click="openEditModal({{ $member->id }})"
                                    class="p-2 text-slate-400 hover:text-primary transition-colors">
                                    <span class="material-symbols-outlined text-xl">edit</span>
                                </button>
                                @if(auth()->id() !== $member->id)
                                    <button wire:click="confirmDelete({{ $member->id }})"
                                        class="p-2 text-slate-400 hover:text-red-500 transition-colors">
                                        <span class="material-symbols-outlined text-xl">delete</span>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-500">No members found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $members->links() }}
        </div>
    </div>

    <!-- Invite Member Modal -->
    @if($isInviteModalOpen)
            <div class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">
                <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl p-8 border border-slate-200">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-2xl font-black text-slate-900 tracking-tight">Invite Member</h3>
                            <p class="text-sm text-slate-500">Send an invitation to join your team.</p>
                        </div>
                        <button wire:click="$set('isInviteModalOpen', false)"
                            class="p-2 hover:bg-slate-100 rounded-full transition-colors">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>

                    <form wire:submit="sendInvite" class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Email Address</label>
                            <input wire:model="inviteEmail"
                                class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                                placeholder="colleague@company.com" type="email" required />
                            @error('inviteEmail') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Assign Role</label>
                            <select wire:model="inviteRole"
                                class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                                required>
                                <option value="">Select a role...</option>
                                @foreach($availableRoles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('inviteRole') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div class="bg-slate-50 p-4 rounded-xl border border-dashed border-slate-300">
                            <p class="text-xs text-slate-500">Members will receive an email invitation to create an account and
                                join this workspace.</p>
                        </div>
                        <div class="flex gap-3 pt-2">
                            <button wire:click="$set('isInviteModalOpen', false)"
                                class="flex-1 py-3 px-4 bg-slate-100 text-slate-700 font-bold rounded-xl hover:bg-slate-200 transition-colors"
                                type="button">Cancel</button>
                            <button
                                class="flex-1 py-3 px-4 bg-primary text-white font-bold rounded-xl hover:bg-primary/90 transition-all shadow-lg shadow-primary/20"
                                type="submit">Send Invite</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    @endif

<!-- Edit Member Modal -->
@if($isEditModalOpen)
    <div class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">
        <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl p-8 border border-slate-200">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight">Edit Member</h3>
                    <p class="text-sm text-slate-500">Modify member details and access level.</p>
                </div>
                <button wire:click="$set('isEditModalOpen', false)"
                    class="p-2 hover:bg-slate-100 rounded-full transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <form wire:submit="updateMember" class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Name</label>
                    <input wire:model="editName"
                        class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                        type="text" required />
                    @error('editName') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Email Address</label>
                    <input wire:model="editEmail"
                        class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                        type="email" required />
                    @error('editEmail') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Update Role</label>
                    <select wire:model="editRole"
                        class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                        required>
                        <option value="">Select a role...</option>
                        @foreach($availableRoles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('editRole') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div class="flex gap-3 pt-2">
                    <button wire:click="$set('isEditModalOpen', false)"
                        class="flex-1 py-3 px-4 bg-slate-100 text-slate-700 font-bold rounded-xl hover:bg-slate-200 transition-colors"
                        type="button">Cancel</button>
                    <button
                        class="flex-1 py-3 px-4 bg-primary text-white font-bold rounded-xl hover:bg-primary/90 transition-all shadow-lg shadow-primary/20"
                        type="submit">Update Member</button>
                </div>
            </form>
        </div>
    </div>
@endif

<!-- Delete Modal -->
@if($isDeleteModalOpen)
    <div class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">
        <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl p-8 border border-slate-200">
            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center text-red-500 mb-4">
                    <span class="material-symbols-outlined text-3xl">delete_forever</span>
                </div>
                <h3 class="text-2xl font-black text-slate-900 tracking-tight mb-2">Remove Member?</h3>
                <p class="text-slate-500 mb-8">This will immediately revoke their access to your workspace. This action
                    cannot be undone.</p>

                <div class="flex gap-3 w-full">
                    <button wire:click="$set('isDeleteModalOpen', false)"
                        class="flex-1 py-3 px-4 bg-slate-100 text-slate-700 font-bold rounded-xl hover:bg-slate-200 transition-colors"
                        type="button">Cancel</button>
                    <button wire:click="deleteMember"
                        class="flex-1 py-3 px-4 bg-red-500 text-white font-bold rounded-xl hover:bg-red-600 transition-all shadow-lg shadow-red-500/20"
                        type="button">Yes, Remove</button>
                </div>
            </div>
        </div>
    </div>
@endif
</div>