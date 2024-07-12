<script setup>
import { FilterMatchMode } from 'primevue/api';
import { onBeforeMount, ref } from 'vue';

const announcements = ref([
    {
        title: 'Announcement',
        body: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit, optio sunt illum, eaque maxime temporibus, sit eum in recusandae fugit dolorum. Dolor quod nulla odio in cupiditate omnis reprehenderit eius.',
        created_at: '2024-07-12',
        updated_at: '2024-07-12'
    },
    {
        title: 'Announcement',
        body: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit, optio sunt illum, eaque maxime temporibus, sit eum in recusandae fugit dolorum. Dolor quod nulla odio in cupiditate omnis reprehenderit eius.',
        created_at: '2024-07-12',
        updated_at: '2024-07-12'
    },
    {
        title: 'Announcement',
        body: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit, optio sunt illum, eaque maxime temporibus, sit eum in recusandae fugit dolorum. Dolor quod nulla odio in cupiditate omnis reprehenderit eius.',
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
                <h5 class="mb-3">Announcements</h5>

                <DataTable
                    ref="dt"
                    :value="announcements"
                    dataKey="id"
                    :paginator="true"
                    :rows="10"
                    :filters="filters"
                    paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                    :rowsPerPageOptions="[5, 10, 25]"
                    currentPageReportTemplate="Showing {first} to {last} of {totalRecords} announcements"
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

                    <template #empty> No announcements found. </template>

                    <template #loading>
                        <ProgressSpinner style="width: 30px; height: 30px" strokeWidth="8" fill="var(--surface-ground)" animationDuration=".5s" aria-label="Custom ProgressSpinner" />
                    </template>

                    <!-- Title -->
                    <Column field="title" header="Title" :sortable="true">
                        <template #body="slotProps">
                            <span class="p-column-title">Title</span>
                            {{ slotProps.data.title }}
                        </template>
                    </Column>

                    <!-- Body -->
                    <Column field="body" header="Body" :sortable="true">
                        <template #body="slotProps">
                            <span class="p-column-title">Body</span>
                            {{ slotProps.data.body.substr(0, 50) }}...
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
                            <Button icon="pi pi-eye" class="mr-2" severity="secondary" rounded v-tooltip.top="'View Transaction'" />

                            <Button icon="pi pi-pencil" class="mr-2" rounded v-tooltip.top="'Edit Announcement'" />

                            <Button icon="pi pi-trash" class="mr-2" severity="danger" rounded v-tooltip.top="'Delete Announcement'" />
                        </template>
                    </Column>
                </DataTable>
            </div>
        </div>
    </div>
</template>
