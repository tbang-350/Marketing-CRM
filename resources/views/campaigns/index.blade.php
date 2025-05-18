@extends('../layouts/' . $layout)

@section('subhead')
    <title>Campaigns - Marketing Agency Management</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex flex-col items-center sm:flex-row">
        <h2 class="mr-auto text-lg font-medium">Campaigns</h2>
        <div class="mt-4 flex w-full sm:mt-0 sm:w-auto">
            <x-base.button
                class="mr-2 shadow-md"
                data-tw-toggle="modal"
                data-tw-target="#add-campaign-modal"
                href="#"
                as="a"
                variant="primary"
            >
                Create New Campaign
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
                            CLIENT
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">
                            START DATE
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">
                            END DATE
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
                    @foreach($campaigns as $campaign)
                        <x-base.table.tr class="intro-x">
                            <x-base.table.td class="w-10 border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                <x-base.form-check.input type="checkbox" />
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                <a class="whitespace-nowrap font-medium" href="#">
                                    {{ $campaign->name }}
                                </a>
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {{ $campaign->client->company_name }}
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {{ $campaign->start_date->format('M d, Y') }}
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {{ $campaign->end_date->format('M d, Y') }}
                            </x-base.table.td>
                            <x-base.table.td class="border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                <div @class([
                                    'flex items-center justify-center whitespace-nowrap',
                                    'text-success' => $campaign->status === 'active',
                                    'text-primary' => $campaign->status === 'completed',
                                    'text-warning' => $campaign->status === 'draft',
                                ])>
                                    <x-base.lucide
                                        class="mr-2 h-4 w-4"
                                        icon="CheckSquare"
                                    />
                                    {{ ucfirst($campaign->status) }}
                                </div>
                            </x-base.table.td>
                            <x-base.table.td class="relative border-b-0 bg-white py-0 shadow-[20px_3px_20px_#0000000b] before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600 before:dark:bg-darkmode-400">
                                <div class="flex items-center justify-center">
                                    <a class="mr-5 flex items-center whitespace-nowrap text-primary" href="javascript:;" onclick="openEditModal({{ $campaign->id }})">
                                        <x-base.lucide class="mr-1 h-4 w-4" icon="CheckSquare" />
                                        Edit
                                    </a>
                                    <a class="mr-5 flex items-center whitespace-nowrap text-success" href="javascript:;" onclick="openViewModal({{ $campaign->id }})">
                                        <x-base.lucide class="mr-1 h-4 w-4" icon="Eye" />
                                        View
                                    </a>
                                    <a class="mr-5 flex items-center whitespace-nowrap text-primary" href="javascript:;" onclick="openInfluencersModal({{ $campaign->id }})">
                                        <x-base.lucide class="mr-1 h-4 w-4" icon="Users" />
                                        Influencers
                                    </a>
                                    <a class="flex items-center whitespace-nowrap text-danger" href="javascript:;" onclick="deleteCampaign({{ $campaign->id }})">
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
            {{ $campaigns->links() }}
        </div>
        <!-- END: Pagination -->
    </div>

    <!-- BEGIN: Add Campaign Modal -->
    <x-base.dialog id="add-campaign-modal">
        <x-base.dialog.panel>
            <x-base.dialog.title>
                <h2 class="mr-auto text-base font-medium">Create New Campaign</h2>
            </x-base.dialog.title>
            <form id="add-campaign-form">
                <x-base.dialog.description class="grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12">
                        <x-base.form-label for="campaign-name">Campaign Name</x-base.form-label>
                        <x-base.form-input id="campaign-name" type="text" name="name" placeholder="Enter campaign name" required />
                    </div>
                    <div class="col-span-12">
                        <x-base.form-label for="client">Client</x-base.form-label>
                        <x-base.form-select id="client" name="client_id" required>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->company_name }}</option>
                            @endforeach
                        </x-base.form-select>
                    </div>
                    <div class="col-span-12">
                        <x-base.form-label for="start-date">Start Date</x-base.form-label>
                        <x-base.form-input id="start-date" type="date" name="start_date" required />
                    </div>
                    <div class="col-span-12">
                        <x-base.form-label for="end-date">End Date</x-base.form-label>
                        <x-base.form-input id="end-date" type="date" name="end_date" required />
                    </div>
                    <div class="col-span-12">
                        <x-base.form-label for="budget">Budget</x-base.form-label>
                        <x-base.form-input id="budget" type="number" name="budget" step="0.01" placeholder="Enter budget" required />
                    </div>
                    <div class="col-span-12">
                        <x-base.form-label for="status">Status</x-base.form-label>
                        <x-base.form-select id="status" name="status" required>
                            <option value="draft">Draft</option>
                            <option value="active">Active</option>
                            <option value="completed">Completed</option>
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
                        id="add-campaign-submit"
                    >
                        <span class="flex items-center justify-center">
                            <span class="mr-2">Save</span>
                            <x-base.lucide class="hidden h-4 w-4 animate-spin" icon="Loader" id="add-campaign-spinner" />
                        </span>
                    </x-base.button>
                </x-base.dialog.footer>
            </form>
        </x-base.dialog.panel>
    </x-base.dialog>
    <!-- END: Add Campaign Modal -->

    <!-- BEGIN: Edit Campaign Modal -->
    <x-base.dialog id="edit-campaign-modal">
        <x-base.dialog.panel>
            <x-base.dialog.title>
                <h2 class="mr-auto text-base font-medium">Edit Campaign</h2>
            </x-base.dialog.title>
            <x-base.dialog.description class="grid grid-cols-12 gap-4 gap-y-3">
                <input type="hidden" name="campaign_id" id="edit_campaign_id">
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
    <!-- END: Edit Campaign Modal -->

    <!-- BEGIN: View Campaign Modal -->
    <x-base.dialog id="view-campaign-modal">
        <x-base.dialog.panel>
            <x-base.dialog.title>
                <h2 class="mr-auto text-base font-medium">Campaign Details</h2>
            </x-base.dialog.title>
            <x-base.dialog.description class="grid grid-cols-12 gap-4 gap-y-3">
                <div id="campaignDetails" class="col-span-12">
                    <!-- Campaign details will be loaded here -->
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
    <!-- END: View Campaign Modal -->

    <!-- BEGIN: Manage Influencers Modal -->
    <x-base.dialog id="influencers-modal">
        <x-base.dialog.panel class="max-w-3xl">
            <x-base.dialog.title>
                <h2 class="mr-auto text-base font-medium">Manage Campaign Influencers</h2>
            </x-base.dialog.title>
            <x-base.dialog.description class="grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12">
                    <x-base.button
                        class="mb-4"
                        data-tw-toggle="modal"
                        data-tw-target="#add-influencer-modal"
                        href="#"
                        as="a"
                        variant="success"
                    >
                        Add Influencer
                    </x-base.button>
                    <div id="influencersList" class="overflow-x-auto">
                        <!-- Influencers list will be loaded here -->
                    </div>
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
    <!-- END: Manage Influencers Modal -->

    <!-- BEGIN: Add Influencer Modal -->
    <x-base.dialog id="add-influencer-modal">
        <x-base.dialog.panel>
            <x-base.dialog.title>
                <h2 class="mr-auto text-base font-medium">Add Influencer to Campaign</h2>
            </x-base.dialog.title>
            <x-base.dialog.description class="grid grid-cols-12 gap-4 gap-y-3">
                <input type="hidden" name="campaign_id" id="add_influencer_campaign_id">
                <div class="col-span-12">
                    <x-base.form-label for="influencer">Influencer</x-base.form-label>
                    <x-base.form-select id="influencer" name="influencer_id">
                        @foreach($influencers as $influencer)
                            <option value="{{ $influencer->id }}">{{ $influencer->name }}</option>
                        @endforeach
                    </x-base.form-select>
                </div>
                <div class="col-span-12">
                    <x-base.form-label for="contract-value">Contract Value</x-base.form-label>
                    <x-base.form-input id="contract-value" type="number" name="contract_value" step="0.01" placeholder="Enter contract value" />
                </div>
                <div class="col-span-12">
                    <x-base.form-label for="influencer-status">Status</x-base.form-label>
                    <x-base.form-select id="influencer-status" name="status">
                        <option value="pending">Pending</option>
                        <option value="active">Active</option>
                        <option value="completed">Completed</option>
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
                    onclick="submitAddInfluencerForm()"
                >
                    Add
                </x-base.button>
            </x-base.dialog.footer>
        </x-base.dialog.panel>
    </x-base.dialog>
    <!-- END: Add Influencer Modal -->

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
                    Do you really want to delete this campaign? <br />
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
    let currentCampaignId = null;

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

    function openEditModal(campaignId) {
        currentCampaignId = campaignId;
        fetch(`/api/campaigns/${campaignId}`)
            .then(response => response.json())
            .then(data => {
                // Populate form fields
                document.getElementById('edit_campaign_id').value = campaignId;
                // Show modal
                const modal = document.getElementById('edit-campaign-modal');
                modal.classList.remove('hidden');
            });
    }

    function openViewModal(campaignId) {
        fetch(`/api/campaigns/${campaignId}`)
            .then(response => response.json())
            .then(data => {
                const details = document.getElementById('campaignDetails');
                // Populate details
                const modal = document.getElementById('view-campaign-modal');
                modal.classList.remove('hidden');
            });
    }

    function openInfluencersModal(campaignId) {
        currentCampaignId = campaignId;
        document.getElementById('add_influencer_campaign_id').value = campaignId;
        fetch(`/api/campaigns/${campaignId}/influencers`)
            .then(response => response.json())
            .then(data => {
                const list = document.getElementById('influencersList');
                // Populate influencers list
                const modal = document.getElementById('influencers-modal');
                modal.classList.remove('hidden');
            });
    }

    function submitAddForm() {
        const form = document.getElementById('add-campaign-form');
        const formData = new FormData(form);

        showSpinner('add-campaign-submit', 'add-campaign-spinner');

        fetch('/api/campaigns', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(Object.fromEntries(formData))
        })
        .then(response => response.json())
        .then(data => {
            hideSpinner('add-campaign-submit', 'add-campaign-spinner');
            if (data.status === 'success') {
                window.location.reload();
            } else {
                alert(data.message || 'An error occurred while saving the campaign.');
            }
        })
        .catch(error => {
            hideSpinner('add-campaign-submit', 'add-campaign-spinner');
            alert('An error occurred while saving the campaign.');
            console.error('Error:', error);
        });
    }

    function submitEditForm() {
        const formData = new FormData(document.getElementById('edit-campaign-modal').querySelector('form'));
        fetch(`/api/campaigns/${currentCampaignId}`, {
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

    function submitAddInfluencerForm() {
        const formData = new FormData(document.getElementById('add-influencer-modal').querySelector('form'));
        fetch(`/api/campaigns/${currentCampaignId}/influencers`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(Object.fromEntries(formData))
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const modal = document.getElementById('add-influencer-modal');
                modal.classList.add('hidden');
                openInfluencersModal(currentCampaignId);
            }
        });
    }

    function deleteCampaign(campaignId) {
        currentCampaignId = campaignId;
        const modal = document.getElementById('delete-confirmation-modal');
        modal.classList.remove('hidden');
    }

    function confirmDelete() {
        fetch(`/api/campaigns/${currentCampaignId}`, {
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
