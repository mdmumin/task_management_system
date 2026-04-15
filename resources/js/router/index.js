import { createRouter, createWebHistory } from 'vue-router'
import TaskCreate from '../task/TaskCreate.vue'
import TaskEdit from '../task/TaskEdit.vue'
import TaskList from '../task/TaskList.vue'
import TaskDetail from '../task/TaskDetail.vue'
const routes = [
    { path: '/task-create', name: 'TaskCreate', component: TaskCreate },
    { path: '/task-edit/:id', name: 'TaskEdit', component: TaskEdit },
    { path: '/task-list', name: 'TaskList', component: TaskList },
    { path: '/task-detail/:id', name: 'TaskDetail', component: TaskDetail }
]
const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router