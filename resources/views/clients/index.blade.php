@extends('../layouts/' . $layout)

@section('subhead')
    <title>Clients - Marketing Agency Management</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex flex-col items-center sm:flex-row">
        <h2 class="mr-auto text-lg font-medium">Clients</h2>
        <div class="mt-4 flex w-full sm:mt-0 sm:w-auto">
            <x-base.button
                class="mr-2 shadow-md"
                data-tw-toggle="modal"
                data-tw-target="#add-client-modal"
                href="#"
                as="a"
                variant="primary"
            >
                Add New Client
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
                            COMPANY NAME
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">
                            CONTACT PERSON
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
                    @foreach($clients as $client)
                        <x-base.table.tr class="intro-x">
                            <x-base.table.td class="w-10 border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                <x-base.form-check.input type="checkbox" />
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                <a class="whitespace-nowrap font-medium" href="#">
                                    {{ $client->company_name }}
                                </a>
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {{ $client->contact_person }}
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {{ $client->email }}
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {{ $client->phone }}
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                <div @class([
                                    'flex items-center justify-center whitespace-nowrap',
                                    'text-success' => $client->status === 'active',
                                    'text-danger' => $client->status === 'inactive',
                                ])>
                                    <x-base.lucide
                                        class="mr-2 h-4 w-4"
                                        icon="CheckSquare"
                                    />
                                    {{ ucfirst($client->status) }}
                                </div>
                            </x-base.table.td>
                            <x-base.table.td class="relative border-b-0 bg-white py-0 shadow-[20px_3px_20px_#0000000b] before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600 before:dark:bg-darkmode-400">
                                <div class="flex items-center justify-center">
                                    <a class="mr-5 flex items-center whitespace-nowrap text-primary" href="javascript:;" onclick="openEditModal({{ $client->id }})">
                                        <x-base.lucide class="mr-1 h-4 w-4" icon="CheckSquare" />
                                        Edit
                                    </a>
                                    <a class="mr-5 flex items-center whitespace-nowrap text-success" href="javascript:;" onclick="openViewModal({{ $client->id }})">
                                        <x-base.lucide class="mr-1 h-4 w-4" icon="Eye" />
                                        View
                                    </a>
                                    <a class="flex items-center whitespace-nowrap text-danger" href="javascript:;" onclick="deleteClient({{ $client->id }})">
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
            {{ $clients->links() }}
        </div>
        <!-- END: Pagination -->
    </div>

    <!-- BEGIN: Add Client Modal -->
    <x-base.dialog id="add-client-modal">
        <x-base.dialog.panel>
            <x-base.dialog.title>
                <h2 class="mr-auto text-base font-medium">Add New Client</h2>
            </x-base.dialog.title>
            <form id="add-client-form">
                <x-base.dialog.description class="grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12">
                        <x-base.form-label for="company-name">Company Name</x-base.form-label>
                        <x-base.form-input id="company-name" type="text" name="company_name" placeholder="Enter company name" required />
                    </div>
                    <div class="col-span-12">
                        <x-base.form-label for="contact-person">Contact Person</x-base.form-label>
                        <x-base.form-input id="contact-person" type="text" name="contact_person" placeholder="Enter contact person" required />
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
                        <x-base.form-label for="address">Address</x-base.form-label>
                        <x-base.form-textarea id="address" name="address" placeholder="Enter address" required />
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
                        id="add-client-submit"
                    >
                        <span class="flex items-center justify-center">
                            <span class="mr-2">Save</span>
                            <x-base.lucide class="hidden h-4 w-4 animate-spin" icon="Loader" id="add-client-spinner" />
                        </span>
                    </x-base.button>
                </x-base.dialog.footer>
            </form>
        </x-base.dialog.panel>
    </x-base.dialog>
    <!-- END: Add Client Modal -->

    <!-- BEGIN: Edit Client Modal -->
    <x-base.dialog id="edit-client-modal">
        <x-base.dialog.panel>
            <x-base.dialog.title>
                <h2 class="mr-auto text-base font-medium">Edit Client</h2>
            </x-base.dialog.title>
            <form id="edit-client-form">
                <input type="hidden" name="client_id" id="edit_client_id">
                <x-base.dialog.description class="grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12">
                        <x-base.form-label for="edit-company-name">Company Name</x-base.form-label>
                        <x-base.form-input id="edit-company-name" type="text" name="company_name" placeholder="Enter company name" required />
                    </div>
                    <div class="col-span-12">
                        <x-base.form-label for="edit-contact-person">Contact Person</x-base.form-label>
                        <x-base.form-input id="edit-contact-person" type="text" name="contact_person" placeholder="Enter contact person" required />
                    </div>
                    <div class="col-span-12">
                        <x-base.form-label for="edit-email">Email</x-base.form-label>
                        <x-base.form-input id="edit-email" type="email" name="email" placeholder="Enter email" required />
                    </div>
                    <div class="col-span-12">
                        <x-base.form-label for="edit-phone">Phone</x-base.form-label>
                        <x-base.form-input id="edit-phone" type="tel" name="phone" placeholder="Enter phone" required />
                    </div>
                    <div class="col-span-12">
                        <x-base.form-label for="edit-address">Address</x-base.form-label>
                        <x-base.form-textarea id="edit-address" name="address" placeholder="Enter address" required />
                    </div>
                    <div class="col-span-12">
                        <x-base.form-label for="edit-status">Status</x-base.form-label>
                        <x-base.form-select id="edit-status" name="status" required>
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
                        onclick="submitEditForm()"
                        id="edit-client-submit"
                    >
                        <span class="flex items-center justify-center">
                            <span class="mr-2">Update</span>
                            <x-base.lucide class="hidden h-4 w-4 animate-spin" icon="Loader" id="edit-client-spinner" />
                        </span>
                    </x-base.button>
                </x-base.dialog.footer>
            </form>
        </x-base.dialog.panel>
    </x-base.dialog>
    <!-- END: Edit Client Modal -->

    <!-- BEGIN: View Client Modal -->
    <x-base.dialog id="view-client-modal">
        <x-base.dialog.panel>
            <x-base.dialog.title>
                <h2 class="mr-auto text-base font-medium">Client Details</h2>
            </x-base.dialog.title>
            <x-base.dialog.description class="grid grid-cols-12 gap-4 gap-y-3">
                <div id="clientDetails" class="col-span-12">
                    <!-- Client details will be loaded here -->
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
    <!-- END: View Client Modal -->

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
                    Do you really want to delete this client? <br />
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
                    id="delete-client-submit"
                >
                    <span class="flex items-center justify-center">
                        <span class="mr-2">Delete</span>
                        <x-base.lucide class="hidden h-4 w-4 animate-spin" icon="Loader" id="delete-client-spinner" />
                    </span>
                </x-base.button>
            </div>
        </x-base.dialog.panel>
    </x-base.dialog>
    <!-- END: Delete Confirmation Modal -->
@endsection

@push('scripts')
<script>
    let currentClientId = null;

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

    function openEditModal(clientId) {
        currentClientId = clientId;
        fetch(`/api/clients/${clientId}`)
            .then(response => response.json())
            .then(data => {
                // Populate form fields
                document.getElementById('edit_client_id').value = clientId;
                document.getElementById('edit-company-name').value = data.company_name;
                document.getElementById('edit-contact-person').value = data.contact_person;
                document.getElementById('edit-email').value = data.email;
                document.getElementById('edit-phone').value = data.phone;
                document.getElementById('edit-address').value = data.address;
                document.getElementById('edit-status').value = data.status;

                // Show modal
                const modal = document.getElementById('edit-client-modal');
                modal.classList.remove('hidden');
            });
    }

    function openViewModal(clientId) {
        fetch(`/api/clients/${clientId}`)
            .then(response => response.json())
            .then(data => {
                const details = document.getElementById('clientDetails');
                details.innerHTML = `
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-6">
                            <p class="font-medium">Company Name:</p>
                            <p>${data.company_name}</p>
                        </div>
                        <div class="col-span-6">
                            <p class="font-medium">Contact Person:</p>
                            <p>${data.contact_person}</p>
                        </div>
                        <div class="col-span-6">
                            <p class="font-medium">Email:</p>
                            <p>${data.email}</p>
                        </div>
                        <div class="col-span-6">
                            <p class="font-medium">Phone:</p>
                            <p>${data.phone}</p>
                        </div>
                        <div class="col-span-12">
                            <p class="font-medium">Address:</p>
                            <p>${data.address}</p>
                        </div>
                        <div class="col-span-6">
                            <p class="font-medium">Status:</p>
                            <p>${data.status}</p>
                        </div>
                    </div>
                `;
                const modal = document.getElementById('view-client-modal');
                modal.classList.remove('hidden');
            });
    }

    function submitAddForm() {
        const form = document.getElementById('add-client-form');
        const formData = new FormData(form);

        showSpinner('add-client-submit', 'add-client-spinner');

        fetch('/api/clients', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(Object.fromEntries(formData))
        })
        .then(response => response.json())
        .then(data => {
            hideSpinner('add-client-submit', 'add-client-spinner');
            if (data.status === 'success') {
                window.location.reload();
            } else {
                alert(data.message || 'An error occurred while saving the client.');
            }
        })
        .catch(error => {
            hideSpinner('add-client-submit', 'add-client-spinner');
            alert('An error occurred while saving the client.');
            console.error('Error:', error);
        });
    }

    function submitEditForm() {
        const form = document.getElementById('edit-client-form');
        const formData = new FormData(form);

        showSpinner('edit-client-submit', 'edit-client-spinner');

        fetch(`/api/clients/${currentClientId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(Object.fromEntries(formData))
        })
        .then(response => response.json())
        .then(data => {
            hideSpinner('edit-client-submit', 'edit-client-spinner');
            if (data.status === 'success') {
                window.location.reload();
            } else {
                alert(data.message || 'An error occurred while updating the client.');
            }
        })
        .catch(error => {
            hideSpinner('edit-client-submit', 'edit-client-spinner');
            alert('An error occurred while updating the client.');
            console.error('Error:', error);
        });
    }

    function deleteClient(clientId) {
        currentClientId = clientId;
        const modal = document.getElementById('delete-confirmation-modal');
        modal.classList.remove('hidden');
    }

    function confirmDelete() {
        showSpinner('delete-client-submit', 'delete-client-spinner');

        fetch(`/api/clients/${currentClientId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            hideSpinner('delete-client-submit', 'delete-client-spinner');
            if (data.status === 'success') {
                window.location.reload();
            } else {
                alert(data.message || 'An error occurred while deleting the client.');
            }
        })
        .catch(error => {
            hideSpinner('delete-client-submit', 'delete-client-spinner');
            alert('An error occurred while deleting the client.');
            console.error('Error:', error);
        });
    }
</script>
@endpush
