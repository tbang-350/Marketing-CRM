@extends('../layouts/' . $layout)

@section('subhead')
    <title>Influencers - Marketing Agency Management</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex flex-col items-center sm:flex-row">
        <h2 class="mr-auto text-lg font-medium">Influencers</h2>
        <div class="mt-4 flex w-full sm:mt-0 sm:w-auto">
            <x-base.button
                class="mr-2 shadow-md"
                data-tw-toggle="modal"
                data-tw-target="#add-influencer-modal"
                href="#"
                as="a"
                variant="primary"
            >
                Add New Influencer
            </x-base.button>
        </div>
    </div>

    <div class="intro-y mt-5 grid grid-cols-12 gap-6">
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto 2xl:overflow-visible">
            <x-base.table class="-mt-2 border-separate border-spacing-y-[10px]">
                <x-base.table.thead>
                    <x-base.table.tr>
                        <x-base.table.th class="whitespace-nowrap border-b-0">
                            <x-base.form-check.input type="checkbox" />
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">
                            NAME
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">
                            EMAIL
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">
                            PHONE
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            STATUS
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            ACTIONS
                        </x-base.table.th>
                    </x-base.table.tr>
                </x-base.table.thead>
                <x-base.table.tbody>
                    @foreach($influencers as $influencer)
                        <x-base.table.tr class="intro-x">
                            <x-base.table.td class="w-10 border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                <x-base.form-check.input type="checkbox" />
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                <a class="whitespace-nowrap font-medium" href="#">
                                    {{ $influencer->name }}
                                </a>
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {{ $influencer->email }}
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {{ $influencer->phone }}
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                <div @class([
                                    'flex items-center justify-center whitespace-nowrap',
                                    'text-success' => $influencer->status === 'active',
                                    'text-danger' => $influencer->status === 'inactive',
                                ])>
                                    <x-base.lucide
                                        class="mr-2 h-4 w-4"
                                        icon="CheckSquare"
                                    />
                                    {{ ucfirst($influencer->status) }}
                                </div>
                            </x-base.table.td>
                            <x-base.table.td class="relative border-b-0 bg-white py-0 shadow-[20px_3px_20px_#0000000b] before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600 before:dark:bg-darkmode-400">
                                <div class="flex items-center justify-center">
                                    <a class="mr-5 flex items-center whitespace-nowrap text-primary" href="javascript:;" onclick="openEditModal({{ $influencer->id }})">
                                        <x-base.lucide class="mr-1 h-4 w-4" icon="CheckSquare" />
                                        Edit
                                    </a>
                                    <a class="mr-5 flex items-center whitespace-nowrap text-success" href="javascript:;" onclick="openViewModal({{ $influencer->id }})">
                                        <x-base.lucide class="mr-1 h-4 w-4" icon="Eye" />
                                        View
                                    </a>
                                    <a class="flex items-center whitespace-nowrap text-danger" href="javascript:;" onclick="deleteInfluencer({{ $influencer->id }})">
                                        <x-base.lucide class="mr-1 h-4 w-4" icon="Trash2" />
                                        Delete
                                    </a>
                                </div>
                            </x-base.table.td>
                        </x-base.table.tr>
                    @endforeach
                </x-base.table.tbody>
            </x-base.table>
        </div>
        <!-- END: Data List -->
        <!-- BEGIN: Pagination -->
        <div class="intro-y col-span-12 flex flex-wrap items-center sm:flex-row sm:flex-nowrap">
            {{ $influencers->links() }}
        </div>
        <!-- END: Pagination -->
    </div>

    <!-- BEGIN: Add Influencer Modal -->
    <x-base.dialog id="add-influencer-modal">
        <x-base.dialog.panel>
            <x-base.dialog.title>
                <h2 class="mr-auto text-base font-medium">Add New Influencer</h2>
            </x-base.dialog.title>
            <form id="add-influencer-form">
                <x-base.dialog.description class="grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12">
                        <x-base.form-label for="name">Name</x-base.form-label>
                        <x-base.form-input id="name" type="text" name="name" placeholder="Enter name" required />
                    </div>
                    <div class="col-span-12">
                        <x-base.form-label for="email">Email</x-base.form-label>
                        <x-base.form-input id="email" type="email" name="email" placeholder="Enter email" required />
                    </div>
                    <div class="col-span-12">
                        <x-base.form-label for="phone">Phone</x-base.form-label>
                        <x-base.form-input id="phone" type="tel" name="phone" placeholder="Enter phone" required />
                    </div>
                    <div class="col-span-12">
                        <x-base.form-label for="status">Status</x-base.form-label>
                        <x-base.form-select id="status" name="status" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </x-base.form-select>
                    </div>
                </x-base.dialog.description>
                <x-base.dialog.footer class="text-right">
                    <x-base.button
                        class="mr-1 w-32"
                        data-tw-dismiss="modal"
                        type="button"
                        variant="outline-secondary"
                    >
                        Cancel
                    </x-base.button>
                    <x-base.button
                        class="w-32"
                        type="button"
                        variant="primary"
                        onclick="submitAddForm()"
                        id="add-influencer-submit"
                    >
                        <span class="flex items-center justify-center">
                            <span class="mr-2">Save</span>
                            <x-base.lucide class="hidden h-4 w-4 animate-spin" icon="Loader" id="add-influencer-spinner" />
                        </span>
                    </x-base.button>
                </x-base.dialog.footer>
            </form>
        </x-base.dialog.panel>
    </x-base.dialog>
    <!-- END: Add Influencer Modal -->

    <!-- BEGIN: Edit Influencer Modal -->
    <x-base.dialog id="edit-influencer-modal">
        <x-base.dialog.panel>
            <x-base.dialog.title>
                <h2 class="mr-auto text-base font-medium">Edit Influencer</h2>
            </x-base.dialog.title>
            <x-base.dialog.description class="grid grid-cols-12 gap-4 gap-y-3">
                <input type="hidden" name="influencer_id" id="edit_influencer_id">
                <!-- Same fields as add form -->
            </x-base.dialog.description>
            <x-base.dialog.footer class="text-right">
                <x-base.button
                    class="mr-1 w-32"
                    data-tw-dismiss="modal"
                    type="button"
                    variant="outline-secondary"
                >
                    Cancel
                </x-base.button>
                <x-base.button
                    class="w-32"
                    type="button"
                    variant="primary"
                    onclick="submitEditForm()"
                >
                    Update
                </x-base.button>
            </x-base.dialog.footer>
        </x-base.dialog.panel>
    </x-base.dialog>
    <!-- END: Edit Influencer Modal -->

    <!-- BEGIN: View Influencer Modal -->
    <x-base.dialog id="view-influencer-modal">
        <x-base.dialog.panel>
            <x-base.dialog.title>
                <h2 class="mr-auto text-base font-medium">Influencer Details</h2>
            </x-base.dialog.title>
            <x-base.dialog.description class="grid grid-cols-12 gap-4 gap-y-3">
                <div id="influencerDetails" class="col-span-12">
                    <!-- Influencer details will be loaded here -->
                </div>
            </x-base.dialog.description>
            <x-base.dialog.footer class="text-right">
                <x-base.button
                    class="w-32"
                    data-tw-dismiss="modal"
                    type="button"
                    variant="outline-secondary"
                >
                    Close
                </x-base.button>
            </x-base.dialog.footer>
        </x-base.dialog.panel>
    </x-base.dialog>
    <!-- END: View Influencer Modal -->

    <!-- BEGIN: Delete Confirmation Modal -->
    <x-base.dialog id="delete-confirmation-modal">
        <x-base.dialog.panel>
            <div class="p-5 text-center">
                <x-base.lucide
                    class="mx-auto mt-3 h-16 w-16 text-danger"
                    icon="XCircle"
                />
                <div class="mt-5 text-3xl">Are you sure?</div>
                <div class="mt-2 text-slate-500">
                    Do you really want to delete this influencer? <br />
                    This process cannot be undone.
                </div>
            </div>
            <div class="px-5 pb-8 text-center">
                <x-base.button
                    class="mr-1 w-24"
                    data-tw-dismiss="modal"
                    type="button"
                    variant="outline-secondary"
                >
                    Cancel
                </x-base.button>
                <x-base.button
                    class="w-24"
                    type="button"
                    variant="danger"
                    onclick="confirmDelete()"
                >
                    Delete
                </x-base.button>
            </div>
        </x-base.dialog.panel>
    </x-base.dialog>
    <!-- END: Delete Confirmation Modal -->
@endsection

@push('scripts')
<script>
    let currentInfluencerId = null;

    function showSpinner(buttonId, spinnerId) {
        const button = document.getElementById(buttonId);
        const spinner = document.getElementById(spinnerId);
        button.disabled = true;
        spinner.classList.remove('hidden');
    }

    function hideSpinner(buttonId, spinnerId) {
        const button = document.getElementById(buttonId);
        const spinner = document.getElementById(spinnerId);
        button.disabled = false;
        spinner.classList.add('hidden');
    }

    function openEditModal(influencerId) {
        currentInfluencerId = influencerId;
        fetch(`/api/influencers/${influencerId}`)
            .then(response => response.json())
            .then(data => {
                // Populate form fields
                document.getElementById('edit_influencer_id').value = influencerId;
                // Show modal
                const modal = document.getElementById('edit-influencer-modal');
                modal.classList.remove('hidden');
            });
    }

    function openViewModal(influencerId) {
        fetch(`/api/influencers/${influencerId}`)
            .then(response => response.json())
            .then(data => {
                const details = document.getElementById('influencerDetails');
                // Populate details
                const modal = document.getElementById('view-influencer-modal');
                modal.classList.remove('hidden');
            });
    }

    function submitAddForm() {
        const form = document.getElementById('add-influencer-form');
        const formData = new FormData(form);

        showSpinner('add-influencer-submit', 'add-influencer-spinner');

        fetch('/api/influencers', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(Object.fromEntries(formData))
        })
        .then(response => response.json())
        .then(data => {
            hideSpinner('add-influencer-submit', 'add-influencer-spinner');
            if (data.status === 'success') {
                window.location.reload();
            } else {
                alert(data.message || 'An error occurred while saving the influencer.');
            }
        })
        .catch(error => {
            hideSpinner('add-influencer-submit', 'add-influencer-spinner');
            alert('An error occurred while saving the influencer.');
            console.error('Error:', error);
        });
    }

    function submitEditForm() {
        const formData = new FormData(document.getElementById('edit-influencer-modal').querySelector('form'));
        fetch(`/api/influencers/${currentInfluencerId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(Object.fromEntries(formData))
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                window.location.reload();
            }
        });
    }

    function deleteInfluencer(influencerId) {
        currentInfluencerId = influencerId;
        const modal = document.getElementById('delete-confirmation-modal');
        modal.classList.remove('hidden');
    }

    function confirmDelete() {
        fetch(`/api/influencers/${currentInfluencerId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                window.location.reload();
            }
        });
    }
</script>
@endpush
