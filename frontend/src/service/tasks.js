import api from './api'
import Cookies from 'js-cookie'

export default async function getTasks(params) {
  const token = Cookies.get('authToken')

  try {
    const response = await api.get('/tasks', {
      params: params,
      headers: {
        Authorization: `Bearer ${token}`
      }
    })

    return response.data
  } catch (error) {
    return { error: error.response.status }
  }
}
