<script setup>
import { FilterMatchMode } from 'primevue/api';
import { onBeforeMount, ref } from 'vue';

const accounts = ref([
    {
        account_number: '123456789',
        name: 'John Doe',
        current_balance: 10000,
        created_at: '2024-07-12',
        updated_at: '2024-07-12'
    },
    {
        account_number: '123456789',
        name: 'Jane Doe',
        current_balance: 10000,
        created_at: '2024-07-12',
        updated_at: '2024-07-12'
    },
    {
        account_number: '123456789',
        name: 'John Smith',
        current_balance: 10000,
        created_at: '2024-07-12',
        updated_at: '2024-07-12'
    }
]);
const loading = ref(false);

const dt = ref(null);
const filters = ref({});

onBeforeMount(() => {
    initFilters();
});

const exportCSV = () => {
    dt.value.exportCSV();
};

const initFilters = () => {
    filters.value = {
        global: { value: null, matchMode: FilterMatchMode.CONTAINS }
    };
};
</script>

<template>
    <div class="grid">
        <div class="col-12">
            <div class="card border-0 shadow-1">
                <h5 class="mb-3">Accounts</h5>

                <DataTable
                    ref="dt"
                    :value="accounts"
                    dataKey="id"
                    :paginator="true"
                    :rows="10"
                    :filters="filters"
                    paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                    :rowsPerPageOptions="[5, 10, 25]"
                    currentPageReportTemplate="Showing {first} to {last} of {totalRecords} transactions"
                    :loading="loading"
                >
                    <!-- Table Header -->
                    <template #header>
                        <div class="flex flex-column sm:flex-row sm:justify-content-between sm:align-items-center">
                            <IconField iconPosition="left" class="block mt-2 sm:mt-0">
                                <InputIcon class="pi pi-search" />
                                <InputText class="w-full sm:w-auto" v-model="filters['global'].value" placeholder="Search..." />
                            </IconField>

                            <div class="mt-2 sm:mt-0">
                                <Button icon="pi pi-upload" class="mr-2" severity="help" @click="exportCSV($event)" v-tooltip.top="'Export CSV'" />

                                <RouterLink :to="{ name: 'accounts.create' }">
                                    <Button icon="pi pi-plus" severity="success" v-tooltip.top="'Create Account'" />
                                </RouterLink>
                            </div>
                        </div>
                    </template>

                    <template #empty> No accounts found. </template>

                    <template #loading>
                        <ProgressSpinner style="width: 30px; height: 30px" strokeWidth="8" fill="var(--surface-ground)" animationDuration=".5s" aria-label="Custom ProgressSpinner" />
                    </template>

                    <!-- Account Number -->
                    <Column field="account_number" header="Account Number" :sortable="true">
                        <template #body="slotProps">
                            <span class="p-column-title">Account Number</span>
                            {{ slotProps.data.account_number }}
                        </template>
                    </Column>

                    <!-- Name -->
                    <Column field="name" header="Name" :sortable="true">
                        <template #body="slotProps">
                            <span class="p-column-title">Name</span>
                            {{ slotProps.data.name }}
                        </template>
                    </Column>

                    <!-- Current Balance -->
                    <Column field="current_balance" header="Current Balance" :sortable="true">
                        <template #body="slotProps">
                            <span class="p-column-title">Current Balance</span>
                            {{ slotProps.data.current_balance }}
                        </template>
                    </Column>

                    <!-- Created At -->
                    <Column field="created_at" header="Created At" :sortable="true">
                        <template #body="slotProps">
                            <span class="p-column-title">Created At</span>
                            {{ slotProps.data.created_at }}
                        </template>
                    </Column>

                    <!-- Updated At -->
                    <Column field="updated_at" header="Updated At" :sortable="true">
                        <template #body="slotProps">
                            <span class="p-column-title">Updated At</span>
                            {{ slotProps.data.updated_at }}
                        </template>
                    </Column>

                    <!-- Action Buttons -->
                    <Column>
                        <template #body="slotProps">
                            <!-- <Button icon="pi pi-eye" class="mr-2" severity="secondary" rounded v-tooltip.top="'View Account'" /> -->
                            <Button icon="pi pi-pencil" class="mr-2" rounded v-tooltip.top="'Edit Account'" />
                            <Button icon="pi pi-trash" class="mr-2" severity="danger" rounded v-tooltip.top="'Delete Account'" />
                        </template>
                    </Column>
                </DataTable>
            </div>
        </div>
    </div>
</template>
