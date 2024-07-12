<script setup>
import { FilterMatchMode } from 'primevue/api';
import { onBeforeMount, ref } from 'vue';

const transactions = ref([
    {
        transaction_date: '2024-07-12',
        description: 'Deposit',
        amount: 5000,
        status: 'Success'
    },
    {
        transaction_date: '2024-07-12',
        description: 'Transfer to 09123456789 - Jane Doe',
        amount: 10000,
        status: 'Success'
    },
    {
        transaction_date: '2024-07-12',
        description: 'Funds received from 0912345677 - John Smith',
        amount: 5000,
        status: 'Success'
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
                <h5 class="mb-3">Transaction Report</h5>

                <DataTable
                    ref="dt"
                    :value="transactions"
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
                                <Button icon="pi pi-upload" severity="help" @click="exportCSV($event)" v-tooltip.top="'Export CSV'" />
                            </div>
                        </div>
                    </template>

                    <template #empty> No transaction report found. </template>

                    <template #loading>
                        <ProgressSpinner style="width: 30px; height: 30px" strokeWidth="8" fill="var(--surface-ground)" animationDuration=".5s" aria-label="Custom ProgressSpinner" />
                    </template>

                    <!-- Transaction Date -->
                    <Column field="transaction_date" header="Transaction Date" :sortable="true">
                        <template #body="slotProps">
                            <span class="p-column-title">Transaction Date</span>
                            {{ slotProps.data.transaction_date }}
                        </template>
                    </Column>

                    <!-- Description -->
                    <Column field="description" header="Description" :sortable="true">
                        <template #body="slotProps">
                            <span class="p-column-title">Transaction Date</span>
                            {{ slotProps.data.description }}
                        </template>
                    </Column>

                    <!-- Amount -->
                    <Column field="amount" header="Amount" :sortable="true">
                        <template #body="slotProps">
                            <span class="p-column-title">Amount</span>
                            {{ slotProps.data.amount }}
                        </template>
                    </Column>

                    <!-- Status -->
                    <Column field="status" header="Status" :sortable="true">
                        <template #body="slotProps">
                            <span class="p-column-title">Status</span>
                            {{ slotProps.data.status }}
                        </template>
                    </Column>

                    <!-- Action Buttons -->
                    <Column>
                        <template #body="slotProps">
                            <Button icon="pi pi-eye" class="mr-2" severity="secondary" rounded v-tooltip.top="'View Transaction'" />
                        </template>
                    </Column>
                </DataTable>
            </div>
        </div>
    </div>
</template>
