import api from '../api'
import Cookies from 'js-cookie'

export default async function addTask(task) {
  const token = Cookies.get('authToken')

  try {
    const response = await api.post('/tasks', task, {
      headers: {
        Authorization: `Bearer ${token}`
      }
    })

    return response.data
  } catch (error) {
    return { error: error.response.status }
  }
}
