<template>
  <q-page class="bg-grey-10 q-pa-lg row  items-center">
    <q-card flat bordered style="max-width: 90%;"  class="q-mx-auto" >
      <q-card-section >
        <div class="text-h4 text-bold">FILMES</div>
      <div class="text-subtitle2 text-grey-7">Lista de filmes cadastrados no sistema</div>

    <div class="row q-gutter-md">
      <q-input 
        style="max-width:300px" 
        v-model="search" 
        filled
        debounce="700"
        type="search" 
        color="light-blue-3"
        placeholder="Pesquisar filme..."
      >
        <template v-slot:append>
          <q-icon name="search" />
        </template>
      </q-input>
      <q-select
        style="width: 100px"
        v-model="ano"
        :options="anos"
        label="Ano"
        input-debounce="700"
        placeholder="Selecione"
        clearable
      />
    
      <q-select
        filled
        label="Selecione os Generos"
        v-model="generos"
        use-input
        use-chips
        multiple
        :max-values="3"
        input-debounce="700"
        :options="['Ação', 'Aventura', 'Comédia', 'Drama', 'Fantasia', 'Terror', 'Mistério', 'Romance', 'Ficção Científica', 'Suspense', 'Animação', 'Família', 'Biografia', 'Crime']"
        style="width: 250px"
      />
  </div>
     </q-card-section>

     <q-card-section>
      <q-btn rounded color="primary" label="Adicionar Filme"  icon="add"
      style="width: 190px;" @click="dialog = true"/>
    </q-card-section>

    <Adicionar
    :dialog="dialog"
    :FilmeSalvou="FilmeSalvou"
    @cancelar="dialog = false"
    @salvarFilme="EnviarFilme"
    @filmeSalvou="FilmeSalvou = false"
    />

    <Editar
    :dialog="dialogEditar"
    :filmeselect="filmeselect"
    @cancelar="manterformeditar"
    @editar="editarFilme"
    :FilmeSalvou="FilmeSalvou"
    @filmeSalvou="FilmeSalvou = false"
    />


    <dialogdelete
    :OpenDialogDelete="OpenDialogDelete"
    :filmepradeletar="filmepradeletar"
    @cancelar="OpenDialogDelete = false"
    @excluir="excluirFilme"/>

      <Tabela
      :rows="filmes"
      @editar="Filmeselecionado"
      @excluir="Dialogdelete"
      @propriedades="DialogProp"/>

      <Propriedades
      :filmeselect="propfilme"
      :dialogprop="dialogprop"
      @fechar="dialogprop = false"
      />
      </q-card>
  </q-page>


</template>
<script setup>
import { ref, onMounted, watch } from 'vue'
import Tabela from '../components/tabela.vue'
import { api } from '../boot/axios'
import Adicionar from '@/components/adicionar.vue'
import Editar from '@/components/editar.vue'
import dialogdelete from '@/components/dialog/deletedialog.vue'
import { useQuasar } from 'quasar'
import Propriedades from '@/components/propriedades.vue'
import { Dark } from 'quasar'
Dark.set(true)



const filmeselect = ref({})
const dialogEditar = ref(false)
const dialog = ref(false)
const search = ref('')
const filmes = ref([])
const FilmeSalvou = ref(false)
const OpenDialogDelete = ref(false)
const filmepradeletar = ref({})
const $q = useQuasar()
const propfilme  = ref({})
const dialogprop = ref(false)
const ano = ref(null)
const anos = Array.from(
  { length: 100 },
  (_, i) => new Date().getFullYear() - i
)

const generos =  ref(null)
const paginacao = ref(null)

onMounted(() => {
  buscarFilmes()
})

async function buscarFilmes() {
  try {
  const response = await api.get('/filmes')
  filmes.value = response.data

} catch (error) {
  console.log("Erro ao buscar filmes: ",error)
  console.log(error.response?.data)
}}


async function EnviarFilme(dados){

  //transforma o arquivo em formdata para poder enviar para o laravel, precisa serf formdata pq tem a imagem
  
  try {
  dialog.value = false
  dados.filme.genero = dados.filme.genero.join(", ")
  const formData = new FormData()
  formData.append('titulo', dados.filme.titulo)
  formData.append('diretor', dados.filme.diretor)
  formData.append('ano', dados.filme.ano)
  formData.append('genero', dados.filme.genero)
  formData.append('sinopse', dados.filme.sinopse)

  if (dados.capa) {
      formData.append('capa', dados.capa)
    }

  await api.post('/filmes/', formData)
  
  FilmeSalvou.value = true
  $q.notify({
    type: 'positive',
    message: 'Filme adicionado com sucesso.'
  })
  console.log(formData)
  buscarFilmes()
} catch (error) {
    console.log(error.response.data)
  }}

function Filmeselecionado(filme){
  filmeselect.value = filme
  dialogEditar.value = true
  }

function manterformeditar(){
  filmeselect.value ={}
  dialogEditar.value = false
}

async function editarFilme(dados) {
 
  try {
  dialogEditar.value = false
  const formData = new FormData()
  dados.filme.genero = dados.filme.genero.join(", ")
  formData.append('titulo', dados.filme.titulo)
  formData.append('diretor', dados.filme.diretor)
  formData.append('ano', dados.filme.ano)
  formData.append('genero', dados.filme.genero)
  formData.append('sinopse',dados.filme.sinopse === null ? '' : dados.filme.sinopse)
  if (dados.capa != null) {
      formData.append('capa', dados.capa)
    }

  await api.put(`/filmes/${dados.filme.hashid}`, formData)
  
  $q.notify({
    type: 'positive',
    message: 'Filme editado com sucesso.'
  })
  FilmeSalvou.value = true
  await buscarFilmes()
} catch (error) {
  console.log(error)
  console.log(error.response?.data)
}}

function DialogProp(filme) {
    propfilme.value = filme
    dialogprop.value = true

}

async function excluirFilme(filme){
  await api.delete(`/filmes/${filme.hashid}`)
  OpenDialogDelete.value = false
  await buscarFilmes()
  $q.notify({
    type: 'positive',
    message: 'Filme excluido com sucesso.'
  })
}

function Dialogdelete(filme){
  OpenDialogDelete.value = true
  filmepradeletar.value = filme
}


//função para buscar filmes
watch([search,ano,generos,paginacao], async ([buscanovo,anonovo,generosnovo,paginacaonovo]) => {
  console.log('busca: ',buscanovo)
  console.log('ano: ',anonovo)
  console.log('generos: ',generosnovo)
  console.log('paginacao: ',paginacaonovo)
  if(buscanovo != '' || anonovo != null || generosnovo != null || paginacaonovo.page != 1){
    console.log('generos: ',generosnovo) 
    const resultado =  await api.post('/filmes/filtro',{titulo:buscanovo, 
      ano:anonovo, 
      generos:generosnovo},
    {params:{page:paginacaonovo.page}})
      
    console.log(resultado.data)
    if(resultado.data){
    filmes.value = resultado.data.data
    }
  }
  else{
    buscarFilmes()
  }
},{
  deep: true
})
//a paginaçao nao esta disponivel na index tenho q ver se ela fica aqui ou eu emito la na tabela.vue, teoricamente quando eu aperto no botao a paginaçao ja muda.
</script>
