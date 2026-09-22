<template>
  <q-page class="bg-grey-10 q-pa-lg">

    <div class="container">

      <!-- CABEÇALHO -->
      <div class="q-mb-xl">
        <div class="text-h3 text-weight-bold text-white">
          FILMES
        </div>

        <div class="text-subtitle1 text-grey-5">
          Lista de filmes cadastrados no sistema
        </div>
      </div>

      <!-- FILTROS -->
      <q-card
        flat
        bordered
        class="bg-grey-9 q-mb-lg"
      >
        <q-card-section>

          <div class="text-h6 text-white q-mb-md">
            Pesquisar filmes
          </div>

          <div class="row q-col-gutter-md">

            <!-- PESQUISA -->
            <div class="col-12 col-md-4">
              <q-input
                v-model="search"
                filled
                debounce="700"
                type="search"
                color="light-blue-3"
                dark
                label="Pesquisar filme"
              >
                <template #prepend>
                  <q-icon name="search" />
                </template>
              </q-input>
            </div>

            <!-- ANO -->
            <div class="col-12 col-sm-6 col-md-2">
              <q-select
                v-model="ano"
                filled
                dark
                clearable
                :options="anos"
                label="Ano"
                color="light-blue-3"
              />
            </div>

            <!-- GÊNEROS -->
            <div class="col-12 col-md-4">
              <q-select
                v-model="generos"
                filled
                dark
                use-input
                use-chips
                multiple
                clearable
                :max-values="3"
                input-debounce="700"
                label="Gêneros"
                color="light-blue-3"
                :options="opcoesGeneros"
              />
            </div>

            <!-- LIMPAR FILTROS -->
            <div class="col-12 col-md-2 flex items-center">
              <q-btn
                outline
                color="white"
                icon="filter_alt_off"
                label="Limpar"
                class="full-width"
                @click="limparFiltros"
              />
            </div>

          </div>

        </q-card-section>
      </q-card>

      <!-- BOTÃO ADICIONAR -->
      <div class="row justify-end q-mb-lg">
        <q-btn
          rounded
          color="teal"
          icon="add"
          label="Adicionar Filme"
          size="md"
          @click="abrirAdicionar"
        />
      </div>

      <!-- CARREGANDO -->
      <div
        v-if="carregando"
        class="row justify-center q-my-xl"
      >
        <q-spinner
          color="primary"
          size="50px"
        />
      </div>

      <!-- NENHUM FILME -->
      <q-card
        v-else-if="filmes.length === 0"
        flat
        class="bg-grey-9 text-center q-pa-xl"
      >
        <q-icon class="inline-block"
          name="movie_off"
          size="70px"
          color="grey-6"
        />

        <div class="text-h6 text-grey-5 q-mt-md">
          Nenhum filme encontrado
        </div>

        <div class="text-caption text-grey-6">
          Tente alterar os filtros ou cadastre um novo filme.
        </div>
      </q-card>

      <!-- FILMES -->
      <div
        v-else
        class="row q-col-gutter-lg"
      >

        <div
          v-for="filme in filmes"
          :key="filme.hashid"
          class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2-4"
        >

          <q-card @click="abrirPropriedades(filme)"
            class="filme-card bg-grey-9 text-white"
            flat
            bordered
          >

            <!-- CAPA -->
            <q-img
              :src="filme.capa"
              :ratio="2 / 3"
              loading="lazy"
              spinner-color="primary"
              class="filme-capa"
            >
            <!-- Exibido automaticamente se :src falhar (404/erro) -->
              <template v-slot:error>
                <q-img
                  src="https://m.media-amazon.com/images/I/21cOE-lrhBL._AC_UF1000,1000_QL80_.jpg"
                  :ratio="2 / 3"
                />
              </template>
              <div class="absolute-bottom text-subtitle2">
                {{ filme.ano }}
              </div>
            </q-img>

            <!-- INFORMAÇÕES -->
            <q-card-section>

              <div
                class="text-h6 text-weight-bold ellipsis"
                :title="filme.titulo"
              >
                {{ filme.titulo }}
              </div>

              <div class="text-caption text-grey-5 q-mt-xs">
                {{ filme.diretor }}
              </div>

              <div class="text-caption text-grey-6 q-mt-sm">
                {{ filme.genero }}
              </div>

            </q-card-section>

            <!-- AÇÕES -->
              <q-card-actions
                align="around"
                class="q-pb-md"
              >

                <q-btn
                  flat
                  round
                  color="white"
                  icon="visibility"
                  @click.stop="abrirPropriedades(filme)"
                >
                  <q-tooltip>
                    Ver detalhes
                  </q-tooltip>
                </q-btn>

                <q-btn
                  flat
                  round
                  color="primary"
                  icon="edit"
                  @click.stop="abrirEditar(filme)"
                >
                  <q-tooltip>
                    Editar
                  </q-tooltip>
                </q-btn>

                <q-btn
                  flat
                  round
                  color="negative"
                  icon="delete"
                  @click.stop="abrirExcluir(filme)"
                >
                  <q-tooltip>
                    Excluir
                  </q-tooltip>
                </q-btn>

              </q-card-actions>

          </q-card>

        </div>

      </div>

      <!-- PAGINAÇÃO -->
      <div
        v-if="totalPaginas > 1"
        class="row justify-center q-mt-xl"
      >
        <q-pagination
          v-model="paginacao.page"
          :max="totalPaginas"
          direction-links
          push
          boundary-links
          color="teal"
          active-design="push"
          active-color="orange"
        />
      </div>

    </div>

    <!-- ADICIONAR -->
    <Adicionar
      :dialog="dialog"
      :FilmeSalvou="FilmeSalvou"
      @cancelar="dialog = false"
      @salvarFilme="EnviarFilme"
      @filmeSalvou="FilmeSalvou = false"
    />

    <!-- EDITAR -->
    <Editar
      :dialog="dialogEditar"
      :filmeselect="filmeselect"
      :FilmeSalvou="FilmeSalvou"
      @cancelar="manterformeditar"
      @editar="editarFilme"
      @filmeSalvou="FilmeSalvou = false"
    />

    <!-- EXCLUIR -->
    <dialogdelete
      :OpenDialogDelete="OpenDialogDelete"
      :filmepradeletar="filmepradeletar"
      @cancelar="OpenDialogDelete = false"
      @excluir="excluirFilme"
    />

    <!-- PROPRIEDADES -->
    <Propriedades
      :filmeselect="propfilme"
      :dialogprop="dialogprop"
      @fechar="dialogprop = false"
    />

  </q-page>
</template>


<script setup>

import { ref, onMounted, watch } from 'vue'
import { useQuasar, Dark } from 'quasar'

import { api } from '../boot/axios'

import Adicionar from '@/components/adicionar.vue'
import Editar from '@/components/editar.vue'
import dialogdelete from '@/components/dialog/deletedialog.vue'
import Propriedades from '@/components/propriedades.vue'


/* QUASAR */

const $q = useQuasar()

Dark.set(true)


/* FILMES */

const filmes = ref([])

const carregando = ref(false)


/* ADICIONAR */

const dialog = ref(false)

const FilmeSalvou = ref(false)


/* EDITAR */

const dialogEditar = ref(false)

const filmeselect = ref({})


/* EXCLUIR */

const OpenDialogDelete = ref(false)

const filmepradeletar = ref({})


/* PROPRIEDADES */

const propfilme = ref({})

const dialogprop = ref(false)


/* FILTROS */

const search = ref('')

const ano = ref(null)

const generos = ref([])

const opcoesGeneros = [
  'Ação',
  'Aventura',
  'Comédia',
  'Drama',
  'Fantasia',
  'Terror',
  'Mistério',
  'Romance',
  'Ficção Científica',
  'Suspense',
  'Animação',
  'Família',
  'Biografia',
  'Crime'
]


/* ANOS */

const anos = Array.from(
  { length: 100 },
  (_, i) => new Date().getFullYear() - i
)


/* PAGINAÇÃO */

const paginacao = ref({
  page:1
})

const totalPaginas = ref()

/* BUSCAR FILMES */

async function buscarFilmes() {

  try {

    carregando.value = true

    const response = await api.get('/filmes',
      {
        params: {
          page: paginacao.value.page
        }
      }
    )

    filmes.value = response.data.data

    totalPaginas.value = response.data.last_page

  } catch (error) {

    console.log(error)

    $q.notify({
      type: 'negative',
      message: 'Não foi possível carregar os filmes.'
    })

  } finally {

    carregando.value = false

  }

}


/* BUSCAR FILMES COM FILTRO */

async function buscarFilmesComFiltro() {

  try {

    carregando.value = true

    const response = await api.post(
      '/filmes/filtro',
      {
        titulo: search.value,
        ano: ano.value,
        generos: generos.value
      },
      {
        params: {
          page: paginacao.value.page
        }
      }
    )

    /*
     * Se a API retornar uma resposta paginada:
     */

    if (response.data?.data) {

      filmes.value = response.data.data

      totalPaginas.value = response.data.last_page ?? 1

    } else {

      /*
       * Caso a API retorne diretamente um array.
       */

      filmes.value = response.data

      totalPaginas.value = 1

    }

  } catch (error) {

    console.log(error)

    console.log(error.response?.data)

    $q.notify({
      type: 'negative',
      message: 'Erro ao buscar filmes.'
    })

  } finally {

    carregando.value = false

  }

}


/* ADICIONAR FILME */

function abrirAdicionar() {

  FilmeSalvou.value = false

  dialog.value = true

}


async function EnviarFilme(dados) {

  try {

    dialog.value = false

    const formData = new FormData()

    const genero = Array.isArray(dados.filme.genero)
      ? dados.filme.genero.join(', ')
      : dados.filme.genero

    formData.append(
      'titulo',
      dados.filme.titulo
    )

    formData.append(
      'diretor',
      dados.filme.diretor
    )

    formData.append(
      'ano',
      dados.filme.ano
    )

    formData.append(
      'genero',
      genero
    )

    formData.append(
      'sinopse',
      dados.filme.sinopse ?? ''
    )

    if (dados.capa) {

      formData.append(
        'capa',
        dados.capa
      )

    }

    await api.post(
      '/filmes',
      formData
    )

    FilmeSalvou.value = true

    $q.notify({
      type: 'positive',
      message: 'Filme adicionado com sucesso.'
    })

    paginacao.value.page = 1

    await buscarFilmes()

  } catch (error) {

    console.log(error)

    console.log(error.response?.data)

    $q.notify({
      type: 'negative',
      message: 'Erro ao adicionar o filme.'
    })

  }

}


/* EDITAR FILME */

function abrirEditar(filme) {

  filmeselect.value = filme

  dialogEditar.value = true

}


function manterformeditar() {

  filmeselect.value = {}

  dialogEditar.value = false

}


async function editarFilme(dados) {

  try {

    dialogEditar.value = false

    const formData = new FormData()

    const genero = Array.isArray(dados.filme.genero)
      ? dados.filme.genero.join(', ')
      : dados.filme.genero

    formData.append(
      'titulo',
      dados.filme.titulo
    )

    formData.append(
      'diretor',
      dados.filme.diretor
    )

    formData.append(
      'ano',
      dados.filme.ano
    )

    formData.append(
      'genero',
      genero
    )

    formData.append(
      'sinopse',
      dados.filme.sinopse ?? ''
    )

    if (dados.capa) {

      formData.append(
        'capa',
        dados.capa
      )

    }

    await api.put(
      `/filmes/${dados.filme.hashid}`,
      formData
    )

    FilmeSalvou.value = true

    $q.notify({
      type: 'positive',
      message: 'Filme editado com sucesso.'
    })

    await buscarFilmes()

  } catch (error) {

    console.log(error)

    console.log(error.response?.data)

    $q.notify({
      type: 'negative',
      message: 'Erro ao editar o filme.'
    })

  }

}


/* PROPRIEDADES */

function abrirPropriedades(filme) {

  propfilme.value = filme

  dialogprop.value = true

}


/* EXCLUIR FILME */

function abrirExcluir(filme) {

  filmepradeletar.value = filme

  OpenDialogDelete.value = true

}


async function excluirFilme(filme) {

  try {

    await api.delete(
      `/filmes/${filme.hashid}`
    )

    OpenDialogDelete.value = false

    await buscarFilmes()

    $q.notify({
      type: 'positive',
      message: 'Filme excluído com sucesso.'
    })

  } catch (error) {

    console.log(error)

    console.log(error.response?.data)

    $q.notify({
      type: 'negative',
      message: 'Erro ao excluir o filme.'
    })

  }

}


/* LIMPAR FILTROS */

function limparFiltros() {

  search.value = ''

  ano.value = null

  generos.value = []

  paginacao.value.page = 1

}


/* OBSERVAR FILTROS */

watch(
  [search, ano, generos, () => paginacao.value.page],

  async () => {

    const possuiFiltro =
      search.value !== '' ||
      ano.value !== null ||
      generos.value.length > 0

    console.log('pagina no watch', paginacao.value.page);
    if (possuiFiltro) {
    
      await buscarFilmesComFiltro()

    } else {

      await buscarFilmes()

    }

  }
)


/* INICIALIZAÇÃO */

onMounted(() => {

  buscarFilmes()

})

</script>


<style scoped>

.container {
  width: 100%;
  max-width: 1600px;
  margin: 0 auto;
}


/* CARDS */

.filme-card {
  height: 100%;
  overflow: hidden;

  transition:
    transform 0.2s ease,
    box-shadow 0.2s ease;
}

.filme-card:hover {
  transform: translateY(-6px);

  box-shadow:
    0 8px 25px rgba(0, 0, 0, 0.5);
}


.filme-capa {
  background: #222;
}


/*
| 5 FILMES POR LINHA
*/

.col-xl-2-4 {
  width: 20%;
}


/*
| RESPONSIVIDADE
*/

@media (max-width: 1199px) {

  .col-xl-2-4 {
    width: 25%;
  }

}


@media (max-width: 899px) {

  .col-xl-2-4 {
    width: 33.3333%;
  }

}


@media (max-width: 599px) {

  .col-xl-2-4 {
    width: 50%;
  }

}


@media (max-width: 399px) {

  .col-xl-2-4 {
    width: 100%;
  }

}

</style>