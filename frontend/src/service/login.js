import api from "./api";

export default async function login(email, password){
    try{
        const response = (await api.post('/login',{email, password})).data

        return response
    }catch{
        return {error: error.response.status}
    }
}