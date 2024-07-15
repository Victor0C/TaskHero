import api from './api'

export default async function getUsers() {
  try {
    const { data } = await api.get('/users')

    return data
  } catch (error) {
    return { error: error.response.status }
  }
}
