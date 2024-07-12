<script setup>
import { reactive } from 'vue';

const form = reactive({
    name: '',
    short_name: '',
    about_us: '',
    logo: ''
});
</script>

<template>
    <div class="card">
        <h5>System Settings</h5>
        <div class="p-fluid formgrid grid">
            <div class="field col-12 md:col-6">
                <label for="name">Name <small class="p-error">*</small></label>
                <InputText id="name" type="text" v-model="form.name" />
            </div>

            <div class="field col-12 md:col-6">
                <label for="short_name">Short Name <small class="p-error">*</small></label>
                <InputText id="short_name" type="text" v-model="form.short_name" />
            </div>

            <div class="field col-12">
                <label for="about_us">About Us <small class="p-error">*</small></label>
                <Textarea id="about_us" rows="4" />
            </div>

            <div class="field col-12">
                <label for="logo">Logo <small class="p-error">*</small></label>
                <FileUpload chooseLabel="Upload Logo" inputId="logo" mode="basic" accept="image/*" :maxFileSize="1000000" class="w-full" />
            </div>
        </div>

        <div class="flex gap-3 mt-1">
            <Button label="Cancel" severity="secondary" outlined />
            <Button label="Create" />
        </div>
    </div>
</template>
