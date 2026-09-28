<template>

  <q-page class="pagina-filmes">

    <div class="container">

      <!-- =========================
           CABEÇALHO
      ========================== -->

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

          <!-- USUÁRIO NÃO LOGADO -->

          <q-btn
            v-if="!usuario"
            flat
            no-caps
            class="usuario-btn"
            @click="$router.push('/login')"
          >

            <q-icon
              name="person_outline"
              size="22px"
              class="q-mr-sm"
            />

            <span>Entrar</span>

          </q-btn>


          <!-- USUÁRIO LOGADO -->

          <q-btn
            v-else
            flat
            no-caps
            class="usuario-btn usuario-logado"
          >

            <q-avatar
              size="34px"
              class="usuario-avatar"
            >

              <q-icon
                name="person"
                size="20px"
              />

            </q-avatar>


            <div class="usuario-info">

              <span class="usuario-nome">
                {{ usuario.nome }}
              </span>

              <span class="usuario-status">
                Minha conta
              </span>

            </div>


            <q-icon
              name="expand_more"
              size="20px"
              class="usuario-seta"
            />


            <q-menu
              anchor="bottom right"
              self="top right"
              :offset="[0, 10]"
              class="menu-usuario"
            >

              <q-list style="min-width: 210px">

                <q-item class="menu-header">

                  <q-item-section>

                    <div class="text-weight-bold">
                      {{ usuario.nome }}
                    </div>

                    <div class="text-caption text-grey-6">
                      Minha conta
                    </div>

                  </q-item-section>

                </q-item>


                <q-separator />


                <q-item
                  clickable
                  v-close-popup
                  @click="$router.push('/perfil')"
                >

                  <q-item-section avatar>
                    <q-icon name="person_outline" />
                  </q-item-section>

                  <q-item-section>
                    Perfil
                  </q-item-section>

                </q-item>


                <q-item
                  clickable
                  v-close-popup
                  @click="logout"
                >

                  <q-item-section avatar>
                    <q-icon name="logout" />
                  </q-item-section>

                  <q-item-section>
                    Sair
                  </q-item-section>

                </q-item>

              </q-list>

            </q-menu>

          </q-btn>

        </div>

      </header>


      <!-- =========================
           FILTROS
      ========================== -->

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


      <!-- =========================
           CARREGANDO
      ========================== -->

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


      <!-- =========================
           NENHUM FILME
      ========================== -->

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


      <!-- =========================
           FILMES
      ========================== -->

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


            <!-- =========================
                 AÇÕES
            ========================== -->

            <q-card-actions
              class="acoes-filme"
              align="between"
            >

              <!-- LIKE -->

              <q-btn
                flat
                round
                size="sm"
                :color="
                  curtidas.includes(filme.hashid)
                    ? 'red-5'
                    : 'grey-5'
                "
                :icon="
                  curtidas.includes(filme.hashid)
                    ? 'favorite'
                    : 'favorite_border'
                "
                @click.stop="darLike(filme)"
              >

                <q-tooltip>
                  {{
                    curtidas.includes(filme.hashid)
                      ? 'Remover like'
                      : 'Curtir'
                  }}
                </q-tooltip>

              </q-btn>


              <!-- DISLIKE -->

              <q-btn
                flat
                round
                size="sm"
                :color="
                  dislikes.includes(filme.hashid)
                    ? 'blue-4'
                    : 'grey-5'
                "
                :icon="
                  dislikes.includes(filme.hashid)
                    ? 'thumb_down'
                    : 'thumb_down_off_alt'
                "
                @click.stop="darDislike(filme)"
              >

                <q-tooltip>
                  {{
                    dislikes.includes(filme.hashid)
                      ? 'Remover dislike'
                      : 'Não gostei'
                  }}
                </q-tooltip>

              </q-btn>


              <!-- ASSISTIR DEPOIS -->

              <q-btn
                flat
                round
                size="sm"
                :color="
                  assistirDepois.includes(filme.hashid)
                    ? 'teal-4'
                    : 'grey-5'
                "
                :icon="
                  assistirDepois.includes(filme.hashid)
                    ? 'bookmark'
                    : 'bookmark_border'
                "
                @click.stop="adicionarAssistirDepois(filme)"
              >

                <q-tooltip>
                  {{
                    assistirDepois.includes(filme.hashid)
                      ? 'Remover da lista'
                      : 'Assistir depois'
                  }}
                </q-tooltip>

              </q-btn>


              <!-- COMENTAR -->

              <q-btn
                flat
                round
                size="sm"
                color="grey-5"
                icon="chat_bubble_outline"
                @click.stop="abrirComentarios(filme)"
              >

                <q-tooltip>
                  Comentar
                </q-tooltip>

              </q-btn>


              <!-- DETALHES -->

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

            </q-card-actions>

          </q-card>

        </div>

      </div>


      <!-- =========================
           PAGINAÇÃO
      ========================== -->

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


    <!-- =========================
         ADICIONAR
    ========================== -->

    <Adicionar
      :dialog="dialog"
      :FilmeSalvou="FilmeSalvou"
      @cancelar="dialog = false"
      @salvarFilme="EnviarFilme"
      @filmeSalvou="FilmeSalvou = false"
    />


    <!-- =========================
         EDITAR
    ========================== -->

    <Editar
      :dialog="dialogEditar"
      :filmeselect="filmeselect"
      :FilmeSalvou="FilmeSalvou"
      @cancelar="manterformeditar"
      @editar="editarFilme"
      @filmeSalvou="FilmeSalvou = false"
    />


    <!-- =========================
         EXCLUIR
    ========================== -->

    <dialogdelete
      :OpenDialogDelete="OpenDialogDelete"
      :filmepradeletar="filmepradeletar"
      @cancelar="OpenDialogDelete = false"
      @excluir="excluirFilme"
    />


    <!-- =========================
         PROPRIEDADES
    ========================== -->

    <Propriedades
      :filmeselect="propfilme"
      :dialogprop="dialogprop"
      @fechar="dialogprop = false"
    />


    <!-- =========================
         COMENTÁRIOS
    ========================== -->

    <q-dialog v-model="dialogComentarios">

      <q-card
        class="dialog-comentarios"
        dark
      >

        <q-card-section>

          <div class="text-h6">
            Comentar sobre o filme
          </div>

          <div
            class="text-caption text-grey-6 q-mt-xs"
          >
            {{ filmeComentario?.titulo }}
          </div>

        </q-card-section>


        <q-card-section>

          <q-input
            v-model="comentario"
            filled
            dark
            color="teal"
            type="textarea"
            autogrow
            label="Escreva seu comentário..."
            maxlength="500"
            counter
          />

        </q-card-section>


        <q-card-actions
          align="right"
          class="q-px-md q-pb-md"
        >

          <q-btn
            flat
            no-caps
            label="Cancelar"
            color="grey-5"
            v-close-popup
          />

          <q-btn
            unelevated
            no-caps
            label="Comentar"
            color="teal"
            icon="send"
            @click="enviarComentario"
          />

        </q-card-actions>

      </q-card>

    </q-dialog>

  </q-page>

</template>


<script setup>

import {
  ref,
  onMounted,
  watch
} from 'vue'

import {
  useQuasar,
  Dark
} from 'quasar'

import '@/css/filmes.css'

import { api } from '../boot/axios'

import Adicionar from '@/components/adicionar.vue'

import Editar from '@/components/editar.vue'

import dialogdelete from '@/components/dialog/deletedialog.vue'

import Propriedades from '@/components/propriedades.vue'



/* =========================
   QUASAR
========================= */

const $q = useQuasar()

Dark.set(true)


/* =========================
   USUÁRIO
========================= */

const usuario = ref(null)


async function buscarUsuario() {

  try {

    const response = await api.get('/user')

    console.log(
      'Usuário:',
      response.data
    )

    usuario.value = response.data

  } catch (error) {

    console.log(
      'Usuário não autenticado'
    )

    usuario.value = null

  }

}


/* =========================
   FILMES
========================= */

const filmes = ref([])

const carregando = ref(false)


/* =========================
   AÇÕES DO USUÁRIO
========================= */

const curtidas = ref([])

const dislikes = ref([])

const assistirDepois = ref([])


/* =========================
   COMENTÁRIOS
========================= */

const filmeComentario = ref(null)

const dialogComentarios = ref(false)

const comentario = ref('')


/* =========================
   ADICIONAR
========================= */

const dialog = ref(false)

const FilmeSalvou = ref(false)


/* =========================
   EDITAR
========================= */

const dialogEditar = ref(false)

const filmeselect = ref({})


/* =========================
   EXCLUIR
========================= */

const OpenDialogDelete = ref(false)

const filmepradeletar = ref({})


/* =========================
   PROPRIEDADES
========================= */

const propfilme = ref({})

const dialogprop = ref(false)


/* =========================
   FILTROS
========================= */

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


/* =========================
   ANOS
========================= */

const anos = Array.from(
  {
    length: 100
  },

  (_, i) =>
    new Date().getFullYear() - i

)


/* =========================
   PAGINAÇÃO
========================= */

const paginacao = ref({
  page: 1
})

const totalPaginas = ref()


/* =========================
   BUSCAR FILMES
========================= */

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

    filmes.value =
      response.data.data

    totalPaginas.value =
      response.data.last_page

  } catch (error) {

    console.log(error)

    $q.notify({
      type: 'negative',
      message:
        'Não foi possível carregar os filmes.'
    })

  } finally {

    carregando.value = false

  }

}


/* =========================
   BUSCAR COM FILTRO
========================= */

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

      filmes.value =
        response.data.data

      totalPaginas.value =
        response.data.last_page ?? 1

    } else {

      filmes.value =
        response.data

      totalPaginas.value = 1

    }

  } catch (error) {

    console.log(error)

    console.log(
      error.response?.data
    )

    $q.notify({
      type: 'negative',
      message:
        'Erro ao buscar filmes.'
    })

  } finally {

    carregando.value = false

  }

}


/* =========================
   LIKE
========================= */

function darLike(filme) {

  if (!usuario.value) {

    $q.notify({
      type: 'warning',
      message:
        'Faça login para curtir filmes.'
    })

    return

  }


  const id = filme.hashid

  const index =
    curtidas.value.indexOf(id)


  if (index === -1) {

    curtidas.value.push(id)


    // Remove dislike
    const dislikeIndex =
      dislikes.value.indexOf(id)

    if (dislikeIndex !== -1) {

      dislikes.value.splice(
        dislikeIndex,
        1
      )

    }


    $q.notify({
      type: 'positive',
      message:
        'Filme curtido.'
    })

  } else {

    curtidas.value.splice(
      index,
      1
    )

  }

}


/* =========================
   DISLIKE
========================= */

function darDislike(filme) {

  if (!usuario.value) {

    $q.notify({
      type: 'warning',
      message:
        'Faça login para avaliar filmes.'
    })

    return

  }


  const id = filme.hashid

  const index =
    dislikes.value.indexOf(id)


  if (index === -1) {

    dislikes.value.push(id)


    // Remove like
    const likeIndex =
      curtidas.value.indexOf(id)

    if (likeIndex !== -1) {

      curtidas.value.splice(
        likeIndex,
        1
      )

    }


    $q.notify({
      type: 'info',
      message:
        'Você não gostou deste filme.'
    })

  } else {

    dislikes.value.splice(
      index,
      1
    )

  }

}


/* =========================
   ASSISTIR DEPOIS
========================= */

function adicionarAssistirDepois(
  filme
) {

  if (!usuario.value) {

    $q.notify({
      type: 'warning',
      message:
        'Faça login para salvar filmes.'
    })

    return

  }


  const id = filme.hashid

  const index =
    assistirDepois.value.indexOf(id)


  if (index === -1) {

    assistirDepois.value.push(id)

    $q.notify({
      type: 'positive',
      message:
        'Filme adicionado à sua lista.'
    })

  } else {

    assistirDepois.value.splice(
      index,
      1
    )

    $q.notify({
      type: 'info',
      message:
        'Filme removido da sua lista.'
    })

  }

}


/* =========================
   COMENTÁRIOS
========================= */

function abrirComentarios(filme) {

  if (!usuario.value) {

    $q.notify({
      type: 'warning',
      message:
        'Faça login para comentar.'
    })

    return

  }


  filmeComentario.value =
    filme

  comentario.value = ''

  dialogComentarios.value =
    true

}


function enviarComentario() {

  if (
    !comentario.value.trim()
  ) {

    $q.notify({
      type: 'warning',
      message:
        'Digite um comentário.'
    })

    return

  }


  console.log({
    filme:
      filmeComentario.value,

    comentario:
      comentario.value,

    usuario:
      usuario.value
  })


  $q.notify({
    type: 'positive',
    message:
      'Comentário enviado.'
  })


  dialogComentarios.value =
    false

}


/* =========================
   ADICIONAR FILME
========================= */

function abrirAdicionar() {

  FilmeSalvou.value =
    false

  dialog.value =
    true

}


async function EnviarFilme(dados) {

  try {

    dialog.value = false

    const formData =
      new FormData()


    const genero =
      Array.isArray(
        dados.filme.genero
      )

        ? dados.filme.genero.join(
            ', '
          )

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


    FilmeSalvou.value =
      true


    $q.notify({
      type: 'positive',
      message:
        'Filme adicionado com sucesso.'
    })


    paginacao.value.page =
      1


    await buscarFilmes()

  } catch (error) {

    console.log(error)

    console.log(
      error.response?.data
    )

    $q.notify({
      type: 'negative',
      message:
        'Erro ao adicionar o filme.'
    })

  }

}


/* =========================
   EDITAR
========================= */

function abrirEditar(filme) {

  filmeselect.value =
    filme

  dialogEditar.value =
    true

}


function manterformeditar() {

  filmeselect.value = {}

  dialogEditar.value =
    false

}


async function editarFilme(dados) {

  try {

    dialogEditar.value =
      false


    const formData =
      new FormData()


    const genero =
      Array.isArray(
        dados.filme.genero
      )

        ? dados.filme.genero.join(
            ', '
          )

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


    FilmeSalvou.value =
      true


    $q.notify({
      type: 'positive',
      message:
        'Filme editado com sucesso.'
    })


    await buscarFilmes()

  } catch (error) {

    console.log(error)

    console.log(
      error.response?.data
    )

    $q.notify({
      type: 'negative',
      message:
        'Erro ao editar o filme.'
    })

  }

}


/* =========================
   PROPRIEDADES
========================= */

function abrirPropriedades(
  filme
) {

  propfilme.value =
    filme

  dialogprop.value =
    true

}


/* =========================
   EXCLUIR
========================= */

function abrirExcluir(filme) {

  filmepradeletar.value =
    filme

  OpenDialogDelete.value =
    true

}


async function excluirFilme(
  filme
) {

  try {

    await api.delete(
      `/filmes/${filme.hashid}`
    )


    OpenDialogDelete.value =
      false


    await buscarFilmes()


    $q.notify({
      type: 'positive',
      message:
        'Filme excluído com sucesso.'
    })

  } catch (error) {

    console.log(error)

    console.log(
      error.response?.data
    )

    $q.notify({
      type: 'negative',
      message:
        'Erro ao excluir o filme.'
    })

  }

}


/* =========================
   LIMPAR FILTROS
========================= */

function limparFiltros() {

  search.value = ''

  ano.value = null

  generos.value = []

  paginacao.value.page = 1

}


/* =========================
   LOGOUT
========================= */

async function logout() {

  try {

    await api.post(
      '/logout'
    )


    usuario.value =
      null


    console.log(
      'Logout realizado'
    )


    $q.notify({
      type: 'positive',
      message:
        'Logout realizado com sucesso.'
    })

  } catch (error) {

    console.log(
      error.response?.data
    )

  }

}


/* =========================
   OBSERVAR FILTROS
========================= */

watch(

  [
    search,
    ano,
    generos,
    () => paginacao.value.page
  ],

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


/* =========================
   INICIALIZAÇÃO
========================= */

onMounted(() => {

  buscarFilmes()

  buscarUsuario()

})

</script>