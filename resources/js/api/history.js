import axios from 'axios'

const BASE_URL = 'http://localhost:8000/api'

export const fetchTaskHistories = () => {
    return axios.get(`${BASE_URL}/task-histories`)
}

export const createTaskHistory = (data) => {
    return axios.post(`${BASE_URL}/task-histories`, data)
}
