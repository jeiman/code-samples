import axios from 'axios'

// const riotApi = axios.create({
//     baseURL: 'https://na1.api.riotgames.com',
//     timeout: 5000,
//     withCredentials: true,
//     headers: {
//         'Accept': 'application/json',
//         'X-Riot-Token': 'RGAPI-db937f79-4171-4d0b-a8a7-a8e6f709c7cc'
//     }
// })

function axiosWrapper (region) {
    return axios.create({
        baseURL: `https://${region}.api.riotgames.com`,
        timeout: 5000,
        withCredentials: true,
        headers: {
            'Accept': 'application/json',
            'X-Riot-Token': 'RGAPI-db937f79-4171-4d0b-a8a7-a8e6f709c7cc'
        }
    })
}

// const riotApi = axiosWrapper(region)

export async function getStaticDataApi () {
    return riotApi
    .get('/lol/champion-mastery/v3/champion-masteries/by-summoner/19367416')
    .then((response) => {
        return response.data
    })
    .catch((err) => {
        console.log('err ==> ', err)
        return
    })
}

export async function getSummonerName (name, region) {
    return axiosWrapper(region)
    .get(`/lol/summoner/v3/summoners/by-name/${name}`)
    .then((response) => {
        return response.data
    })
    .catch((err) => {
        console.log('err ==> ', err)
        return
    })
} 

export async function getUserChampionMastery (summonerId, region) {
    return axiosWrapper(region)
    .get(`/lol/champion-mastery/v3/champion-masteries/by-summoner/${summonerId}`)
    .then((response) => {
        return response.data
    })
    .catch((err) => {
        console.log('err ==> ', err)
        return
    })
}