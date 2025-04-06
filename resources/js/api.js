// api.js
import axios from "axios";

const apiClient = axios.create({
    baseURL: "http://127.0.0.1:8000/api",
    headers: {
        Accept: "application/json",
        "Content-Type": "application/json",
    },
    withCredentials: true,
});

// 認証トークン付きリクエストの共通処理
const setAuthToken = () => {
    const token = localStorage.getItem("authToken");
    if (token) {
        apiClient.defaults.headers["Authorization"] = `Bearer ${token}`;
    }
};

// 🔹 各関数（named export にして明示的に）
export const getTaskHistories = async () => {
    setAuthToken();
    return await apiClient.get("/task-histories");
};

export const fetchUsers = () => apiClient.get("/users");

export const deleteUser = (id) => apiClient.delete(`/users/${id}`);

// 🔹 client本体だけ default export（必要な場合）
export default apiClient;
