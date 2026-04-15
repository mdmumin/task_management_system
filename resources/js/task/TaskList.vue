<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap">
                            <form class="d-flex gap-2 flex-wrap" @submit.prevent="searchTasks">
                                <input
                                    v-model="searchInput"
                                    type="text"
                                    class="form-control"
                                    placeholder="Search task title..."
                                    style="min-width: 260px;"
                                >
                                <button type="submit" class="btn btn-outline-primary">Search</button>
                                <button type="button" class="btn btn-outline-secondary" @click="clearSearch">Clear</button>
                            </form>

                            <router-link to="/task-create" class="btn btn-primary">Create Task</router-link>
                        </div>
                    </div>            
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Serial</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Assigned To</th>
                                    <th scope="col">Priority</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Start Date</th>
                                    <th scope="col">End Date</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="!tasks.length">
                                    <td colspan="9" class="text-center">No tasks found.</td>
                                </tr>
                                <tr v-for="(task, index) in tasks" :key="task.id">
                                    <th scope="row">{{ startIndex + index + 1 }}</th>
                                    <td>{{ task.title }}</td>
                                    <td>{{ task.description || '-' }}</td>
                                    <td>{{ task.assigned_to || 'Unassigned' }}</td>
                                    <td>{{ task.priority }}</td>
                                    <td>
                                        <select
                                            v-model="task.status"
                                            class="form-select form-select-sm"
                                            style="min-width: 140px;"
                                            @change="updateTaskStatus(task)"
                                        >
                                            <option value="pending">Pending</option>
                                            <option value="in_progress">In Progress</option>
                                            <option value="completed">Completed</option>
                                        </select>
                                    </td>
                                    <td>{{ task.start_date || '-' }}</td>
                                    <td>{{ task.end_date || '-' }}</td>
                                    <td>
                                        <router-link :to="`/task-edit/${task.id}`" class="btn btn-sm btn-outline-primary">Edit</router-link>
                                        <router-link :to="`/task-detail/${task.id}`" class="btn btn-sm btn-outline-secondary">View</router-link>
                                        <button class="btn btn-sm btn-outline-danger" @click="deleteTask(task.id)">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <nav v-if="totalPages > 1" aria-label="Task pagination">
                            <ul class="pagination justify-content-center mb-0">
                                <li class="page-item" :class="{ disabled: currentPage === 1 }">
                                    <button class="page-link" type="button" @click="changePage(currentPage - 1)">Previous</button>
                                </li>

                                <li
                                    v-for="page in totalPages"
                                    :key="page"
                                    class="page-item"
                                    :class="{ active: currentPage === page }"
                                >
                                    <button class="page-link" type="button" @click="changePage(page)">{{ page }}</button>
                                </li>

                                <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                                    <button class="page-link" type="button" @click="changePage(currentPage + 1)">Next</button>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'TaskList',
    data() {
        return {
            tasks: [],
            searchInput: '',
            searchQuery: '',
            currentPage: 1,
            perPage: 10,
            totalPages: 1,
            totalTasks: 0
        };
    },
    mounted() {
        this.fetchTasks();
    },
    methods: {
        fetchTasks(page = 1) {
            axios.get('/api/tasks', {
                params: {
                    search: this.searchQuery,
                    page: page,
                }
            })
                .then(response => {
                    this.tasks = response.data.data ?? [];
                    this.currentPage = response.data.meta?.current_page ?? page;
                    this.totalPages = response.data.meta?.last_page ?? 1;
                    this.perPage = response.data.meta?.per_page ?? this.perPage;
                    this.totalTasks = response.data.meta?.total ?? this.tasks.length;
                })
                .catch(error => {
                    console.error('Error fetching tasks:', error);
                });
        },
        searchTasks() {
            this.searchQuery = this.searchInput;
            this.currentPage = 1;
            this.fetchTasks(1);
        },
        clearSearch() {
            this.searchInput = '';
            this.searchQuery = '';
            this.currentPage = 1;
            this.fetchTasks(1);
        },
        changePage(page) {
            if (page < 1 || page > this.totalPages) {
                return;
            }

            this.fetchTasks(page);
        },
        deleteTask(id) {
            if (!window.confirm('Are you sure you want to delete this task?')) {
                return;
            }

            axios.delete(`/api/tasks/${id}`)
                .then(() => {
                    if (this.tasks.length === 1 && this.currentPage > 1) {
                        this.fetchTasks(this.currentPage - 1);
                        return;
                    }

                    this.fetchTasks(this.currentPage);
                })
                .catch(error => {
                    console.error('Error deleting task:', error);
                });
        },
        updateTaskStatus(task) {
            axios.put(`/api/tasks/${task.id}`, {
                status: task.status,
            })
                .then(() => {
                    this.fetchTasks(this.currentPage);
                })
                .catch(error => {
                    console.error('Error updating task status:', error);
                    this.fetchTasks(this.currentPage);
                });
        }
    },
    computed: {
        startIndex() {
            return (this.currentPage - 1) * this.perPage;
        }
    }

}  
</script>