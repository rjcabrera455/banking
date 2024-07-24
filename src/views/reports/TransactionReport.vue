<script setup>
import { FilterMatchMode } from 'primevue/api';
import { onBeforeMount, onMounted, ref } from 'vue';
import reportService from '@/service/reportService';
import useToast from '@/utils/toast';

const toast = useToast();
const loading = ref(false);
const transactions = ref([]);

const dt = ref(null);
const filters = ref({});

const getTransactions = () => {
    loading.value = true;
    reportService
        .getTransactions({ include: 'user' })
        .then((response) => {
            transactions.value = response.data.data;
        })
        .catch((error) => {
            toast.error(error.response.data.error, error.response.data.message);
        })
        .finally(() => {
            loading.value = false;
        });
};

onBeforeMount(() => {
    initFilters();
});

onMounted(() => {
    getTransactions();
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

                    <template #empty> No transactions found. </template>

                    <template #loading>
                        <ProgressSpinner style="width: 30px; height: 30px" strokeWidth="8" fill="var(--surface-ground)" animationDuration=".5s" aria-label="Custom ProgressSpinner" />
                    </template>

                    <!-- User -->
                    <Column field="user.full_name" header="User" :sortable="true">
                        <template #body="slotProps">
                            <span class="p-column-title">User</span>
                            {{ slotProps.data.user.full_name }}
                        </template>
                    </Column>

                    <!-- Amount -->
                    <Column field="amount" header="Amount" :sortable="true">
                        <template #body="slotProps">
                            <span class="p-column-title">Amount</span>
                            {{ slotProps.data.amount }}
                        </template>
                    </Column>

                    <!-- Remarks -->
                    <Column field="remarks" header="Remarks" :sortable="true">
                        <template #body="slotProps">
                            <span class="p-column-title">Remarks</span>
                            {{ slotProps.data.remarks }}
                        </template>
                    </Column>

                    <!-- Transaction Date -->
                    <Column field="created_at" header="Transaction Date" :sortable="true">
                        <template #body="slotProps">
                            <span class="p-column-title">Transaction Date</span>
                            {{ slotProps.data.created_at }}
                        </template>
                    </Column>

                    <!-- Action Buttons -->
                    <Column>
                        <template #body="slotProps">
                            <!-- <Button icon="pi pi-eye" class="mr-2" severity="secondary" rounded v-tooltip.top="'View Transaction'" /> -->
                        </template>
                    </Column>
                </DataTable>
            </div>
        </div>
    </div>
</template>
