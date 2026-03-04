<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\Customer;

new class extends Component {
    use WithPagination;

    public $search = '';
    public $isModalOpen = false;
    public $editingId = null;
    public $isDeleteModalOpen = false;
    public $customerToDelete = null;

    public $name = '';
    public $industry = '';
    public $revenue = 0;
    public $profit_margin_eur = 0;
    public $effort_hours = 0;

    public function create()
    {
        $this->reset(['name', 'industry', 'revenue', 'profit_margin_eur', 'effort_hours', 'editingId']);
        $this->isModalOpen = true;
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        $this->editingId = $id;
        $this->name = $customer->name;
        $this->industry = $customer->industry;
        $this->revenue = $customer->revenue;
        $this->profit_margin_eur = $customer->profit_margin_eur;
        $this->effort_hours = $customer->effort_hours;

        $this->isModalOpen = true;
    }

    public function confirmDelete($id)
    {
        $this->customerToDelete = $id;
        $this->isDeleteModalOpen = true;
    }

    public function delete()
    {
        if ($this->customerToDelete) {
            Customer::findOrFail($this->customerToDelete)->delete();
            session()->flash('message', 'Customer deleted successfully.');
            $this->isDeleteModalOpen = false;
            $this->customerToDelete = null;
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'industry' => 'nullable|string|max:255',
            'revenue' => 'nullable|numeric|min:0',
            'profit_margin_eur' => 'nullable|numeric',
            'effort_hours' => 'nullable|numeric|min:0',
        ]);

        if ($this->editingId) {
            Customer::findOrFail($this->editingId)->update([
                'name' => $this->name,
                'industry' => $this->industry,
                'revenue' => $this->revenue,
                'profit_margin_eur' => $this->profit_margin_eur,
                'effort_hours' => $this->effort_hours,
            ]);
            session()->flash('message', 'Customer successfully updated.');
        } else {
            Customer::create([
                'name' => $this->name,
                'industry' => $this->industry,
                'revenue' => $this->revenue,
                'profit_margin_eur' => $this->profit_margin_eur,
                'effort_hours' => $this->effort_hours,
            ]);
            session()->flash('message', 'Customer successfully added.');
        }

        $this->reset(['name', 'industry', 'revenue', 'profit_margin_eur', 'effort_hours', 'isModalOpen', 'editingId']);
    }

    public function with()
    {
        return [
            'customers' => Customer::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('industry', 'like', '%' . $this->search . '%')
                ->paginate(10),
        ];
    }
};
?>

<div>
    @section('title', 'Customers')

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
        <div class="px-6 py-4 border-b border-slate-200 flex flex-wrap justify-between items-center bg-slate-50 gap-4">
            <h3 class="text-lg font-bold">{{ __('Raw Customer Data') }}</h3>

            <div class="flex items-center gap-4">
                <div class="relative">
                    <span
                        class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">search</span>
                    <input wire:model.live="search"
                        class="pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-primary w-64"
                        placeholder="{{ __('Search customers...') }}" type="text" />
                </div>
                <button wire:click="create"
                    class="px-4 py-2 bg-primary text-white rounded-xl text-sm font-semibold hover:opacity-90 transition flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">add</span> {{ __('Add Customer') }}
                </button>
            </div>
        </div>

        @if (session()->has('message'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                role="alert">
                <span class="font-medium">Success!</span> {{ session('message') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 text-slate-500 text-xs font-bold uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3">{{ __('ID') }}</th>
                        <th class="px-6 py-3">{{ __('Name') }}</th>
                        <th class="px-6 py-3">{{ __('Industry') }}</th>
                        <th class="px-6 py-3">{{ __('Revenue') }}</th>
                        <th class="px-6 py-3">{{ __('Margin (EUR)') }}</th>
                        <th class="px-6 py-3">{{ __('Effort (Hrs)') }}</th>
                        <th class="px-6 py-3 text-right">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($customers as $customer)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-slate-500">#{{ $customer->id }}</td>
                            <td class="px-6 py-4 font-bold text-primary">{{ $customer->name }}</td>
                            <td class="px-6 py-4">{{ $customer->industry ?? '-' }}</td>
                            <td class="px-6 py-4">€{{ number_format($customer->revenue, 2) }}</td>
                            <td class="px-6 py-4">€{{ number_format($customer->profit_margin_eur, 2) }}</td>
                            <td class="px-6 py-4">{{ $customer->effort_hours ?? '-' }}</td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('customers.show', $customer->id) }}"
                                    class="text-slate-500 hover:text-primary transition" title="View details">
                                    <span class="material-symbols-outlined text-sm">visibility</span>
                                </a>
                                <button wire:click="edit({{ $customer->id }})"
                                    class="text-slate-500 hover:text-blue-500 transition" title="Edit">
                                    <span class="material-symbols-outlined text-sm">edit</span>
                                </button>
                                <button wire:click="confirmDelete({{ $customer->id }})"
                                    class="text-slate-500 hover:text-red-500 transition" title="Delete">
                                    <span class="material-symbols-outlined text-sm">delete</span>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-slate-500">
                                No customers found. Try adjusting your search or add a new customer.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $customers->links() }}
        </div>
    </div>

    <!-- Modal for Adding Customer -->
    @if($isModalOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                    wire:click="$set('isModalOpen', false)"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form wire:submit="save">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">
                                {{ $editingId ? __('Edit Customer') : __('Add New Customer') }}
                            </h3>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">{{ __('Customer Name') }}</label>
                                    <input type="text" wire:model="name"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                        required>
                                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">{{ __('Industry') }}</label>
                                    <input type="text" wire:model="industry"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                    @error('industry') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">{{ __('Revenue') }}</label>
                                        <input type="number" step="0.01" wire:model="revenue"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700">{{ __('Profit Margin (EUR)') }}</label>
                                        <input type="number" step="0.01" wire:model="profit_margin_eur"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700">{{ __('Effort (Hours)') }}</label>
                                        <input type="number" step="0.1" wire:model="effort_hours"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-end gap-3">
                            <button type="button" wire:click="$set('isModalOpen', false)"
                                class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:w-auto sm:text-sm">
                                {{ __('Cancel') }}
                            </button>
                            <button type="submit"
                                class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-medium text-white hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:w-auto sm:text-sm">
                                {{ __('Save Customer') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal for Deleting Customer -->
    @if($isDeleteModalOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                    wire:click="$set('isDeleteModalOpen', false)"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <span class="material-symbols-outlined text-red-600">warning</span>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    {{ __('Delete Customer') }}
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        {{ __('Are you sure you want to delete this customer? All of their data will be permanently removed. This action cannot be undone.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-end gap-3">
                        <button type="button" wire:click="$set('isDeleteModalOpen', false)"
                            class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                        <button type="button" wire:click="delete"
                            class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto sm:text-sm">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>