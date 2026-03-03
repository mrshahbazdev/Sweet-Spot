<?php

use Livewire\Volt\Component;
use App\Models\Role;
use App\Models\Permission;

new class extends Component {
    public $roles;
    public $permissions;
    public $groupedPermissions;

    public $isCreateModalOpen = false;
    public $newRoleName = '';
    public $newRoleDescription = '';
    public $selectedPermissions = [];

    public $editingRole = null;

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->roles = Role::withCount('users')->with('permissions')->get();
        $this->permissions = Permission::all();
        $this->groupedPermissions = $this->permissions->groupBy('group');
    }

    public function openCreateModal()
    {
        $this->reset(['newRoleName', 'newRoleDescription', 'selectedPermissions', 'editingRole']);
        $this->isCreateModalOpen = true;
    }

    public function editRole($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        $this->editingRole = $role;
        $this->newRoleName = $role->name;
        $this->newRoleDescription = $role->description;
        $this->selectedPermissions = $role->permissions->pluck('id')->toArray();
        $this->isCreateModalOpen = true;
    }

    public function saveRole()
    {
        $this->validate([
            'newRoleName' => 'required|string|max:255|unique:roles,name,' . ($this->editingRole ? $this->editingRole->id : 'NULL'),
            'newRoleDescription' => 'nullable|string|max:255',
            'selectedPermissions' => 'array',
        ]);

        if ($this->editingRole) {
            $this->editingRole->update([
                'name' => $this->newRoleName,
                'description' => $this->newRoleDescription,
            ]);
            $this->editingRole->permissions()->sync($this->selectedPermissions);
            session()->flash('message', 'Role updated successfully.');
        } else {
            $role = Role::create([
                'name' => $this->newRoleName,
                'description' => $this->newRoleDescription,
            ]);
            $role->permissions()->sync($this->selectedPermissions);
            session()->flash('message', 'Role created successfully.');
        }

        $this->isCreateModalOpen = false;
        $this->loadData();
    }

    public function deleteRole($id)
    {
        $role = Role::findOrFail($id);

        // Prevent deleting Admin role or roles with users
        if ($role->name === 'Admin') {
            session()->flash('error', 'Cannot delete the core Admin role.');
            return;
        }

        if ($role->users()->count() > 0) {
            session()->flash('error', 'Cannot delete a role that is currently assigned to users.');
            return;
        }

        $role->delete();
        session()->flash('message', 'Role deleted successfully.');
        $this->loadData();
    }
};
?>

<div>
    @section('title', 'Role Management')

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
        <div class="space-y-1">
            <h1 class="text-4xl font-black text-slate-900 dark:text-white tracking-tight leading-tight">Roles &
                Permissions</h1>
            <p class="text-slate-500 dark:text-slate-400 text-lg">Define custom roles and configure granular access
                permissions.</p>
        </div>
        <button wire:click="openCreateModal"
            class="flex items-center gap-2 px-6 py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-xl transition-all shadow-lg">
            <span class="material-symbols-outlined text-lg">add_security</span>
            Create Custom Role
        </button>
    </div>

    @if (session()->has('message'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
            <span class="font-medium">Success!</span> {{ session('message') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
            <span class="font-medium">Error!</span> {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Roles List (Sidebar) -->
        <div class="lg:col-span-1 space-y-4">
            <h3 class="font-bold text-slate-900 text-lg mb-2">Available Roles</h3>

            @foreach($roles as $role)
                <div class="bg-white rounded-xl border {{ $editingRole && $editingRole->id === $role->id ? 'border-primary ring-1 ring-primary' : 'border-slate-200 hover:border-slate-300' }} p-5 shadow-sm transition-all cursor-pointer relative group"
                    wire:click="editRole({{ $role->id }})">

                    <div class="flex justify-between items-start mb-2">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-8 h-8 rounded-lg {{ $role->name === 'Admin' ? 'bg-primary/10 text-primary' : 'bg-slate-100 text-slate-500' }} flex items-center justify-center">
                                <span
                                    class="material-symbols-outlined text-sm">{{ $role->name === 'Admin' ? 'shield_person' : 'badge' }}</span>
                            </div>
                            <h4 class="font-bold text-slate-900">{{ $role->name }}</h4>
                        </div>

                        <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            @if($role->name !== 'Admin' && $role->users_count === 0)
                                <button wire:click.stop="deleteRole({{ $role->id }})"
                                    wire:confirm="Delete this role? This action cannot be undone."
                                    class="text-slate-400 hover:text-red-500 p-1">
                                    <span class="material-symbols-outlined text-sm">delete</span>
                                </button>
                            @endif
                        </div>
                    </div>

                    <p class="text-sm text-slate-500 mb-4">{{ $role->description ?: 'No description provided.' }}</p>

                    <div class="flex items-center justify-between text-xs text-slate-500 border-t border-slate-100 pt-3">
                        <span class="flex items-center gap-1"><span class="material-symbols-outlined text-xs">group</span>
                            {{ $role->users_count }} users</span>
                        <span class="flex items-center gap-1"><span class="material-symbols-outlined text-xs">key</span>
                            {{ $role->permissions->count() }} rules</span>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Permissions Configuration (Main Area) -->
        <div class="lg:col-span-2">
            @if($isCreateModalOpen)
                <div class="bg-white rounded-2xl border border-slate-200 shadow-xl overflow-hidden">
                    <div class="bg-slate-50 p-6 border-b border-slate-200">
                        <h3 class="text-xl font-bold text-slate-900">
                            {{ $editingRole ? 'Edit Role: ' . $editingRole->name : 'Create New Role' }}</h3>
                        <p class="text-sm text-slate-500">Configure core details and granular access permissions.</p>
                    </div>

                    <form wire:submit="saveRole" class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Role Name</label>
                                <input wire:model="newRoleName" type="text"
                                    class="w-full px-4 py-2 bg-slate-50 border-slate-200 rounded-lg focus:ring-2 focus:ring-primary"
                                    required {{ $editingRole && $editingRole->name === 'Admin' ? 'disabled' : '' }}>
                                @error('newRoleName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Description</label>
                                <input wire:model="newRoleDescription" type="text"
                                    class="w-full px-4 py-2 bg-slate-50 border-slate-200 rounded-lg focus:ring-2 focus:ring-primary">
                            </div>
                        </div>

                        <h4 class="font-bold text-slate-900 mb-4 border-b border-slate-100 pb-2">Permission Configuration
                        </h4>

                        <div class="space-y-6">
                            @foreach($groupedPermissions as $group => $perms)
                                <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                                    <h5
                                        class="text-sm font-bold text-slate-700 uppercase tracking-widest mb-4 flex items-center gap-2">
                                        <span class="material-symbols-outlined text-sm text-primary">folder_open</span>
                                        {{ $group ?: 'System' }}
                                    </h5>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach($perms as $perm)
                                            <label
                                                class="flex items-start gap-3 p-3 bg-white rounded-lg border border-slate-200 cursor-pointer hover:border-primary transition-colors">
                                                <div class="flex items-center h-5">
                                                    <input wire:model="selectedPermissions" type="checkbox" value="{{ $perm->id }}"
                                                        class="w-4 h-4 text-primary bg-slate-100 border-slate-300 rounded focus:ring-primary">
                                                </div>
                                                <div>
                                                    <p class="text-sm font-bold text-slate-900">
                                                        {{ ucwords(str_replace('_', ' ', $perm->name)) }}</p>
                                                    <p class="text-xs text-slate-500">{{ $perm->description }}</p>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-8 pt-6 border-t border-slate-200 flex justify-end gap-3">
                            <button type="button" wire:click="$set('isCreateModalOpen', false)"
                                class="px-6 py-2 bg-slate-100 text-slate-700 font-bold rounded-xl hover:bg-slate-200 transition-colors">Cancel</button>
                            <button type="submit"
                                class="px-6 py-2 bg-primary text-white font-bold rounded-xl hover:bg-primary/90 transition-colors shadow-lg shadow-primary/20">Save
                                Role</button>
                        </div>
                    </form>
                </div>
            @else
                <div
                    class="bg-slate-50 border border-slate-200 border-dashed rounded-2xl h-full min-h-[400px] flex flex-col items-center justify-center p-8 text-center text-slate-400">
                    <span class="material-symbols-outlined text-6xl mb-4 text-slate-300">security</span>
                    <h3 class="text-xl font-bold text-slate-600 mb-2">Select a Role to Edit</h3>
                    <p class="max-w-md">Click on any role from the sidebar to view its configured permissions, or create a
                        brand new custom role to tailor access for your team.</p>
                </div>
            @endif
        </div>
    </div>
</div>