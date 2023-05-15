<template>
    <div>
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right d-flex">
                        <router-link class="btn btn-sm btn-primary" :to="'/roles'" aria-label="Ir a lista de roles">
                            <i class="mdi mdi-arrow-left"></i>
                            Volver
                        </router-link>
                    </div>
                    <h4 class="page-title">{{ roleId ? 'Editar' : 'Crear' }} Roles</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row ">
            <div class="col-md-12 mt-2">
                <form class="needs-validation" @submit.prevent="saveRole" novalidate>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div :class="['card-header', roleId ? 'bg-success-lighten' : 'bg-primary-lighten']">
                                    <div class="card-title">{{ roleId ? 'Editar Rol' : 'Crear Rol' }}</div>
                                </div>
                                <div class="card-body row g-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Nombre:</label>
                                        <input type="text" id="name" class="form-control"
                                            :class="{ 'is-invalid': errors.name }" v-model="formData.name" required />
                                        <div class="invalid-feedback" v-if="errors.name">
                                            {{ errors.name[0] }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="slug" class="form-label">Slug:</label>
                                        <input type="text" id="slug" class="form-control"
                                            :class="{ 'is-invalid': errors.slug }" v-model="formData.slug" required />
                                        <div class="invalid-feedback" v-if="errors.slug">
                                            {{ errors.slug[0] }}
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button :class="['btn', roleId ? 'btn-success' : 'btn-primary',]"
                                        type="submit">{{ roleId ? 'Actualizar' : 'Guardar' }}</button>
                                    <button class="btn btn-secondary mx-2" type="button" @click="resetForm">Reset</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">Módulos</div>
                                </div>
                                <!-- Permissions By Modules -->

                                <div class="card-body">
                                    <ul class="nav nav-tabs nav-bordered mb-3">
                                        <li class="nav-item" v-for="(permissionsGroup, moduleName, index) in permissions"
                                            :key="moduleName">
                                            <a :href="'#' + moduleName" data-bs-toggle="tab" :aria-expanded="index === 0"
                                                class="nav-link" :class="{ active: index === 0 }">
                                                <i class="d-md-none d-block">{{ moduleName }}</i>
                                                <i class="d-none d-md-block">{{ moduleName }}</i>
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="tab-content">
                                        <div class="tab-pane" :class="{ 'show active': index === 0 }"
                                            v-for="(permissionsGroup, moduleName, index) in permissions" :key="moduleName"
                                            :id="moduleName">
                                            <ul class="list-group">
                                                <li class="list-group-item">
                                                    <input class="form-check-input me-1" type="checkbox" :value="moduleName"
                                                        :ref="`moduleCheckbox-${moduleName}`"
                                                        @change="toggleModule(moduleName)" aria-label="..." required />

                                                    <strong>{{ moduleName }}</strong> - (Seleccionar todo)
                                                </li>
                                                <li class="list-group-item" v-for="permission in permissionsGroup"
                                                    :key="permission.id">

                                                    <input class="form-check-input me-1" type="checkbox"
                                                        :value="permission.id"
                                                        :checked="selectPermissions.includes(permission.id)"
                                                        @change="togglePermission(permission.id, moduleName)"
                                                        aria-label="..." required />
                                                    {{ permission.name }}
                                                </li>
                                            </ul>

                                            <div class="text-danger mt-2" v-if="errors.permissions">
                                                {{ errors.permissions[0] }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- ... -->
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- end row -->
    </div>
</template>


<script>
import axios from 'axios';
import toastMixin from "../mixins/toastMixin.js";

export default {

    mixins: [toastMixin],

    props: ['roleId'],

    data() {
        return {
            formData: {
                id: null,
                name: '',
                slug: ''
            },
            errors: {},
            permissions: [],
            selectPermissions: [],
        };
    },

    mounted() {

        this.$nextTick(() => {
            const forms = this.$el.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms).forEach((form) => {
                form.addEventListener(
                    'submit',
                    (event) => {
                        if (!form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    },
                    false
                );
            });

        });

        this.loadRoleData();
        this.loadPermissionsByRol()
    },

    created() {
        this.loadRoleData();
    },

    methods: {

        async loadRoleData() {
            if (!this.roleId) {
                return;
            }
            try {
                const response = await axios.get(`/api/roles/${this.roleId}`);
                this.formData = response.data.data;

                const permissionsResponse = await axios.get(`/api/roles/permissions/${this.roleId}/`);
                this.selectPermissions = permissionsResponse.data.data.map(permission => permission.id);

                for (const moduleName in this.permissions) {
                    this.updateModuleCheckbox(moduleName);
                }

            } catch (error) {
                console.error(error);
            }
        },

        async loadPermissionsByRol() {
            try {
                const response = await axios.get("/api/permissions/by-module");
                this.permissions = response.data.data;

                console.log(response.data.data)
            } catch (error) {
                console.error(error);
            }
        },

        async saveRole() {
            try {
                if (this.roleId) {
                    const response = await axios.put(`/api/roles/${this.roleId}`, {
                        name: this.formData.name,
                        slug: this.formData.slug,
                        permissions: this.selectPermissions,
                    });
                    this.getRolePermissions()
                    this.onRoleUpdateOrCreate(response.data);

                } else {
                    const response = await axios.post('/api/roles/save', {
                        name: this.formData.name,
                        slug: this.formData.slug,
                        permissions: this.selectPermissions,
                    });
                    this.onRoleUpdateOrCreate(response.data);
                }
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    this.errors = error.response.data.errors;
                } else {
                    console.error("Error al crear o actualizar el usuario:", error.message);
                }

                this.showToast("Ocurrió un problema!", {
                    type: "error",
                });

            }
        },

        onRoleUpdateOrCreate(userData) {

            const toastDuration = 2000;

            this.showToast(this.roleId ? "Rol actualizado con éxito" : "Rol creado con éxito", {
                type: "success",
                duration: toastDuration,
            });

            setTimeout(() => {
                this.$router.push("/roles");
            }, toastDuration);
        },

        resetForm() {
            this.formData = {
                name: '',
                slug: '',
            };
            this.errors = {};
        },

        toggleModule(moduleName) {
            const permissionsGroup = this.permissions[moduleName];
            const moduleCheckbox = this.$refs[`moduleCheckbox-${moduleName}`][0];

            if (moduleCheckbox.checked) {
                permissionsGroup.forEach(permission => {
                    if (!this.selectPermissions.includes(permission.id)) {
                        this.selectPermissions.push(permission.id);
                    }
                });
            } else {
                permissionsGroup.forEach(permission => {
                    const index = this.selectPermissions.indexOf(permission.id);
                    if (index !== -1) {
                        this.selectPermissions.splice(index, 1);
                    }
                });
            }

            this.updateModuleCheckbox(moduleName);
        },

        updateModuleCheckbox(moduleName) {
            const permissionsGroup = this.permissions[moduleName];
            const allSelected = permissionsGroup.every(permission => this.selectPermissions.includes(permission.id));
            const anySelected = permissionsGroup.some(permission => this.selectPermissions.includes(permission.id));
            const moduleCheckbox = this.$refs[`moduleCheckbox-${moduleName}`][0];

            moduleCheckbox.checked = allSelected;
            moduleCheckbox.indeterminate = !allSelected && anySelected;
        },

        togglePermission(permissionId, moduleName) {
            const index = this.selectPermissions.indexOf(permissionId);

            if (index === -1) {
                this.selectPermissions.push(permissionId);
            } else {
                this.selectPermissions.splice(index, 1);
            }

            this.updateModuleCheckbox(moduleName);
        },

        async getRolePermissions() {
            try {
                const response = await axios.get("/api/users/roles/permissions");
                if (response.status === 200) {
                    localStorage.setItem('permissions', JSON.stringify(response.data));
                    this.$eventBus.$emit('updatePermissions', response.data);
                }
            } catch (error) {
                console.log(error)
            }
        },

    }

};
</script>
