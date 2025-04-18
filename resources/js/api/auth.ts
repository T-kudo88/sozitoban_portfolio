import axios from 'axios'

export const login = async (email: string, password: string) => {
    // ① CSRF Cookie 取得
    await axios.get('http://localhost:8000/sanctum/csrf-cookie', {
        withCredentials: true
    })

    // ② ログインリクエスト
    const response = await axios.post(
        'http://localhost:8000/api/auth/login',
        { email, password },
        { withCredentials: true }
    )

    // ③ トークン保存
    const token = response.data.token // ← API 仕様で key 確認要
    localStorage.setItem('authToken', token)

    return response
}
