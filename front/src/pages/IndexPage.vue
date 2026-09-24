<template>

  <q-page class="pagina-filmes">

    <div class="container">

      <!-- CABEÇALHO -->
      <header class="cabecalho">

        <div class="cabecalho-esquerda">

          <div class="marca-filmes">
            FILMES
          </div>

          <div class="subtitulo-filmes">
            Descubra, explore e encontre seu próximo filme favorito.
          </div>

        </div>

        <div class="cabecalho-direita">

          <q-btn
            flat
            no-caps
            color="white"
            class="usuario-btn"
            @click="$router.push('/login')"
          >
            <q-avatar size="36px" class="q-mr-sm">
              <q-icon name="person" size="24px" />
            </q-avatar>

            <span>Entrar</span>
          </q-btn>

        </div>

      </header>


      <!-- FILTROS -->
      <section class="filtros-linha">

        <q-card
          flat
          class="filtro-card"
        >

          <q-card-section>

            <div class="filtros">

              <!-- PESQUISA -->
              <div class="filtro-pesquisa">

                <q-input
                  v-model="search"
                  filled
                  dense
                  debounce="700"
                  type="search"
                  dark
                  color="teal"
                  label="Pesquisar filme"
                  class="campo-filtro"
                >

                  <template #prepend>
                    <q-icon name="search" />
                  </template>

                </q-input>

              </div>


              <!-- ANO -->
              <div class="filtro-ano">

                <q-select
                  v-model="ano"
                  filled
                  dense
                  dark
                  clearable
                  :options="anos"
                  label="Ano"
                  color="teal"
                  class="campo-filtro"
                />

              </div>


              <!-- GÊNEROS -->
              <div class="filtro-generos">

                <q-select
                  v-model="generos"
                  filled
                  dense
                  dark
                  use-input
                  use-chips
                  multiple
                  clearable
                  :max-values="3"
                  input-debounce="700"
                  label="Gêneros"
                  color="teal"
                  :options="opcoesGeneros"
                  class="campo-filtro"
                />

              </div>


              <!-- LIMPAR -->
              <div class="filtro-botao">

                <q-btn
                  flat
                  icon="filter_alt_off"
                  label="Limpar"
                  class="botao-limpar"
                  @click="limparFiltros"
                />

              </div>

            </div>

          </q-card-section>

        </q-card>


        <!-- ADICIONAR -->
        <q-btn
          rounded
          unelevated
          color="teal"
          icon="add"
          label="Adicionar filme"
          class="botao-adicionar"
          @click="abrirAdicionar"
        />

      </section>


      <!-- CARREGANDO -->
      <div
        v-if="carregando"
        class="estado-carregando"
      >

        <q-spinner
          color="teal"
          size="48px"
        />

        <div class="texto-carregando">
          Carregando filmes...
        </div>

      </div>


      <!-- NENHUM FILME -->
      <q-card
        v-else-if="filmes.length === 0"
        flat
        class="estado-vazio"
      >

        <q-icon
          name="movie_off"
          size="72px"
          color="grey-7"
        />

        <div class="titulo-vazio">
          Nenhum filme encontrado
        </div>

        <div class="descricao-vazio">
          Tente alterar os filtros ou cadastre um novo filme.
        </div>

      </q-card>


      <!-- FILMES -->
      <div
        v-else
        class="grid-filmes"
      >

        <div
          v-for="filme in filmes"
          :key="filme.hashid"
          class="coluna-filme"
        >

          <q-card
            class="filme-card"
            flat
            @click="abrirPropriedades(filme)"
          >

            <!-- CAPA -->
            <div class="capa-container">

              <q-img
                :src="filme.capa"
                :ratio="2 / 3"
                loading="lazy"
                spinner-color="teal"
                class="filme-capa"
              />

              <div class="capa-overlay"></div>

              <div class="ano-filme">
                {{ filme.ano }}
              </div>

              <div class="icone-play">
                <q-icon
                  name="play_arrow"
                  size="32px"
                />
              </div>

            </div>


            <!-- INFORMAÇÕES -->
            <q-card-section class="informacoes-filme">

              <div
                class="titulo-filme"
                :title="filme.titulo"
              >
                {{ filme.titulo }}
              </div>

              <div class="diretor-filme">
                {{ filme.diretor }}
              </div>

              <div class="genero-filme">
                {{ filme.genero }}
              </div>

            </q-card-section>


            <!-- AÇÕES -->
            <q-card-actions
              class="acoes-filme"
              align="right"
            >

              <q-btn
                flat
                round
                size="sm"
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
                size="sm"
                color="teal"
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
                size="sm"
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
        class="paginacao-container"
      >

        <q-pagination
          v-model="paginacao.page"
          :max="totalPaginas"
          direction-links
          boundary-links
          color="grey-7"
          active-color="teal"
          active-design="unelevated"
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

import '@/css/filmes.css'

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
  page: 1
})

const totalPaginas = ref()


/* BUSCAR FILMES */

async function buscarFilmes() {

  try {

    carregando.value = true

    const response = await api.get(
      '/filmes',
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

    if (response.data?.data) {

      filmes.value = response.data.data

      totalPaginas.value = response.data.last_page ?? 1

    } else {

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