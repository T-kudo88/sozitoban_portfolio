import axios from "axios";

const apiClient = axios.create({
    baseURL: "http://127.0.0.1:8000/api",
    headers: {
        "Accept": "application/json",
        "Content-Type": "application/json",
    },
    withCredentials: true,
});

// 🔹 task-histories 取得関数を追加
export const getTaskHistories = async () => {
    const token = localStorage.getItem("authToken");
    if (token) {
        apiClient.defaults.headers["Authorization"] = `Bearer ${token}`;
    }
    return await apiClient.get("/task-histories");
};

export default apiClient;
