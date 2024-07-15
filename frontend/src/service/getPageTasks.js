import api from './api'
import Cookies from 'js-cookie'

export default async function getPageTasks(url) {
  const token = Cookies.get('authToken')

  try {
    const {data} = await api.get(url, {
      headers: {
        Authorization: `Bearer ${token}`
      }
    })

    return data
  } catch (error) {
    return { error: error.response.status }
  }
}
