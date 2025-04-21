import axios from 'axios'

const BASE_URL = 'http://localhost:8000/api'

export const fetchTasks = () => {
    return axios.get(`${BASE_URL}/tasks`)
}

export const shuffleTasks = () => {
    return axios.post(`${BASE_URL}/tasks/shuffle`)
}
