<template>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header d-flex justify-content-between align-items-center">
						<h5 class="mb-0">Task Detail</h5>
						<router-link to="/task-list" class="btn btn-primary btn-sm">Back To List</router-link>
					</div>
					<div class="card-body">
						<p v-if="loading">Loading task...</p>
						<p v-else-if="error" class="text-danger">{{ error }}</p>

						<table v-else class="table table-bordered">
							<tbody>
								<tr>
									<th style="width: 180px">Title</th>
									<td>{{ task.title }}</td>
								</tr>
								<tr>
									<th>Description</th>
									<td>{{ task.description || '-' }}</td>
								</tr>
								<tr>
									<th>Assigned To</th>
									<td>{{ task.assigned_user?.name || task.assigned_to || 'Unassigned' }}</td>
								</tr>
								<tr>
									<th>Priority</th>
									<td>{{ task.priority }}</td>
								</tr>
								<tr>
									<th>Status</th>
									<td>{{ task.status }}</td>
								</tr>
								<tr>
									<th>Start Date</th>
									<td>{{ task.start_date || '-' }}</td>
								</tr>
								<tr>
									<th>End Date</th>
									<td>{{ task.end_date || '-' }}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import axios from 'axios';

export default {
	name: 'TaskDetail',
	data() {
		return {
			task: {},
			loading: true,
			error: ''
		};
	},
	mounted() {
		this.fetchTask();
	},
	methods: {
		fetchTask() {
			const id = this.$route.params.id;

			axios.get(`/api/tasks/${id}`)
				.then((response) => {
					this.task = response.data.data ?? response.data;
				})
				.catch(() => {
					this.error = 'Task not found.';
				})
				.finally(() => {
					this.loading = false;
				});
		}
	}
};
</script>
