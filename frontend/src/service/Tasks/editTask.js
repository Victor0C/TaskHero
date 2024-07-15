import api from '../api'
import Cookies from 'js-cookie'

export default async function editTask(taskID, task) {
  const token = Cookies.get('authToken')

  try {
    const response = await api.patch(`/tasks/${taskID}`, task, {
      headers: {
        Authorization: `Bearer ${token}`
      }
    })

    return response.data
  } catch (error) {
    return { error: error.response.status }
  }
}
