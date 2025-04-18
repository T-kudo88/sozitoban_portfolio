// resources/js/api.js
import axios from 'axios'

export const fetchTasks = () => {
    return axios.get('http://localhost:8000/api/tasks')
}

export const shuffleTasks = () => {
    return axios.post('http://localhost:8000/api/tasks/shuffle')
}

export const createTaskHistory = (data) => {
    return axios.post('http://localhost:8000/api/task-histories', data)
}

// ↓ Register.vueで使ってる default export もつける！
const apiClient = axios.create({
    baseURL: 'http://localhost:8000/api',
    withCredentials: true,
})

export default apiClient
