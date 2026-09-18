import axios from 'axios'

// Cria uma instância do Axios
const api = axios.create({

  // Toda requisição começará com essa URL
  // Assim, api.get('/filmes')
  // vira http://localhost/api/filmes
  baseURL: 'http://localhost/api'

})

// Exporta a instância para ser usada em qualquer componente
export { api }