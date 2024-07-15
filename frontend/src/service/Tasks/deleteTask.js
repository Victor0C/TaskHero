import api from '../api'
import Cookies from 'js-cookie'

export default async function deleteTask(taskID) {
  const token = Cookies.get('authToken')

  try {
    const response = await api.delete(`/tasks/${taskID}`, {
      headers: {
        Authorization: `Bearer ${token}`
      }
    })

    return true
  } catch (error) {
    return { error: error.response.status }
  }
}
