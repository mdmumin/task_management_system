<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <router-link to="/task-list" class="btn btn-primary">Task List</router-link>
                    </div>            
                    <div class="card-body">
                        <form @submit.prevent="createTask">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input id="title" v-model="task.title" type="text" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea id="description" v-model="task.description" class="form-control" rows="3"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="assigned_to" class="form-label">Assigned To</label>
                                <input id="assigned_to" v-model="task.assigned_to" type="text" class="form-control" placeholder="Leave empty for unassigned">
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="priority" class="form-label">Priority</label>
                                    <select id="priority" v-model="task.priority" class="form-control">
                                        <option value="low">Low</option>
                                        <option value="medium">Medium</option>
                                        <option value="high">High</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select id="status" v-model="task.status" class="form-control">
                                        <option value="pending">Pending</option>
                                        <option value="in_progress">In Progress</option>
                                        <option value="completed">Completed</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input id="start_date" v-model="task.start_date" type="datetime-local" class="form-control" @change="syncEndDateWithStartDate">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input id="end_date" v-model="task.end_date" type="datetime-local" class="form-control" :min="task.start_date || null">
                                </div>
                            </div>

                            <div v-if="errorMessage" class="alert alert-danger" role="alert">
                                {{ errorMessage }}
                            </div>

                            <button type="submit" class="btn btn-success" :disabled="loading">
                                {{ loading ? 'Saving...' : 'Create Task' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'TaskCreate',
    data() {
        return {
            task: {
                title: '',
                description: '',
                assigned_to: '',
                priority: 'medium',
                status: 'pending',
                start_date: '',
                end_date: ''
            },
            loading: false,
            errorMessage: ''
        };
    },
    methods: {
        createTask() {
            this.errorMessage = '';

            if (!this.isValidDateRange()) {
                this.errorMessage = 'End Date cannot be earlier than Start Date.';
                return;
            }

            this.loading = true;

            const payload = {
                ...this.task,
                assigned_to: this.task.assigned_to || null,
                start_date: this.task.start_date || null,
                end_date: this.task.end_date || null,
            };

            axios.post('/api/tasks', payload)
                .then(() => {
                    this.$router.push('/task-list');
                })
                .catch((error) => {
                    this.errorMessage = error?.response?.data?.message || 'Failed to create task.';
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        isValidDateRange() {
            if (!this.task.start_date || !this.task.end_date) {
                return true;
            }

            return new Date(this.task.end_date) >= new Date(this.task.start_date);
        },
        syncEndDateWithStartDate() {
            if (!this.isValidDateRange()) {
                this.task.end_date = this.task.start_date;
            }
        }
    }
};
</script>