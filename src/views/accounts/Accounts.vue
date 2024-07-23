<script setup>
import { FilterMatchMode } from 'primevue/api';
import { onBeforeMount, onMounted, ref } from 'vue';
import accountService from '@/service/accountService';
import useToast from '@/utils/toast';
import useHelper from '@/utils/helper';
import { useAuthStore } from '@/stores/auth';

const authStore = useAuthStore();
const toast = useToast();

const accounts = ref([]);
const deleteAccountDialog = ref(false);
const account = ref({});

const dt = ref(null);
const filters = ref({});
const loading = ref(false);
// const helper = useHelper();

const getAccounts = () => {
    loading.value = true;
    accountService
        .getAccounts({ include: 'user' })
        .then((response) => {
            accounts.value = response.data.data;
        })
        .catch((error) => {
            console.log(error);
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
    getAccounts();
});

const confirmDeletAccount = (data) => {
    account.value = data;
    deleteAccountDialog.value = true;
};

const deleteAccount = () => {
    accountService
        .deleteAccount(account.value.id)
        .then((response) => {
            const id = account.value.id;
            accounts.value = accounts.value.filter((account) => account.id !== id);
            deleteAccountDialog.value = false;
            account.value = {};
            toast.success(response.data.message);
        })
        .catch((error) => {
            toast.error(error.response.data.error, error.response.data.message);
        });
};

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
                    <Column field="user.full_name" header="Name" :sortable="true">
                        <template #body="slotProps">
                            <span class="p-column-title">Name</span>
                            {{ slotProps.data.user.full_name }}
                        </template>
                    </Column>

                    <!-- Current Balance -->
                    <Column field="balance" header="Current Balance" :sortable="true">
                        <template #body="slotProps">
                            <span class="p-column-title">Current Balance</span>
                            {{ slotProps.data.balance }}
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
                            <RouterLink :to="{ name: 'accounts.edit', params: { id: slotProps.data.id } }">
                                <Button icon="pi pi-pencil" class="mr-2" rounded v-tooltip.top="'Edit Account'" />
                            </RouterLink>

                            <Button icon="pi pi-trash" class="mt-2" severity="danger" rounded v-tooltip.top="'Delete Account'" @click="confirmDeletAccount(slotProps.data)" />
                        </template>
                    </Column>
                </DataTable>

                <Dialog v-model:visible="deleteAccountDialog" :style="{ width: '450px' }" header="Confirm" :modal="true">
                    <div class="flex align-items-center justify-content-center">
                        <i class="pi pi-exclamation-triangle mr-3" style="font-size: 2rem" />
                        <span v-if="account">
                            Are you sure you want to delete <b>{{ account.name }}</b
                            >?
                        </span>
                    </div>
                    <template #footer>
                        <Button label="No" icon="pi pi-times" text @click="deleteAccountDialog = false" />
                        <Button label="Yes" icon="pi pi-check" text @click="deleteAccount" />
                    </template>
                </Dialog>
            </div>
        </div>
    </div>
</template>
