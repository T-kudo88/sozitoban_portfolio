import axios from 'axios'

const BASE_URL = 'http://localhost:8000/api'

export const fetchUsers = () => {
    return axios.get(`${BASE_URL}/users`)
}

export const deleteUsers = (ids) => {
    return axios.post(`${BASE_URL}/users/delete`, { ids })
}
