import api from './api'
import Cookies from 'js-cookie'

export default async function login(email, password) {
  try {
    const response = (await api.post('/login', { email, password })).data

    Cookies.set('authToken', response.token, { expires: 1 })
    Cookies.set('userID', response.user_id, { expires: 1 })
    Cookies.set('userRole', response.role, { expires: 1 })
    Cookies.set('isAuthenticated', true, { expires: 1 })

    return true
  } catch (error) {
    return { error: error.response?.status }
  }
}
