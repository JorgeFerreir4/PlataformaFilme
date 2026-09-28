<template>
  <q-page class="perfil-page">

    <div class="perfil-container">

      <!-- =========================
           TOPO
      ========================== -->

      <div class="perfil-topo">

        <q-btn
          flat
          round
          icon="arrow_back"
          color="white"
          class="botao-voltar"
          @click="$router.back()"
        />

        <div>
          <div class="titulo-principal">
            Meu perfil
          </div>

          <div class="titulo-sub">
            Sua conta e sua coleção
          </div>
        </div>

      </div>


      <!-- =========================
           HERO DO USUÁRIO
      ========================== -->

      <section class="perfil-hero">

        <div class="avatar-grande">
          <q-icon
            name="person"
            size="58px"
          />
        </div>

        <div class="dados-principais">

          <div class="nome-usuario">
            {{ usuario?.nome || 'Usuário' }}
          </div>

          <div class="email-usuario">
            {{ usuario?.email || 'Carregando...' }}
          </div>

          <div class="status-conta">
            <span class="status-ponto"></span>
            Conta ativa
          </div>

        </div>

      </section>


      <!-- =========================
           MINHA COLEÇÃO
      ========================== -->

      <section class="colecao">

        <div class="secao-heading">

          <div>
            <div class="secao-titulo">
              Minha coleção
            </div>

            <div class="secao-subtitulo">
              Seus filmes favoritos e salvos
            </div>
          </div>

        </div>


        <!-- ABAS -->

        <q-tabs
          v-model="aba"
          class="colecao-tabs"
          active-color="teal-3"
          indicator-color="teal"
          align="left"
          no-caps
          narrow-indicator
        >

          <q-tab
            name="favoritos"
            icon="favorite"
            label="Favoritos"
          />

          <q-tab
            name="assistir"
            icon="schedule"
            label="Assistir depois"
          />

          <q-tab
            name="curtidos"
            icon="thumb_up"
            label="Curtidos"
          />

        </q-tabs>


        <!-- CONTEÚDO DAS ABAS -->

        <q-tab-panels
          v-model="aba"
          animated
          transition-prev="slide-right"
          transition-next="slide-left"
          class="colecao-panels"
        >

          <!-- FAVORITOS -->

          <q-tab-panel name="favoritos">

            <div
              v-if="favoritos.length"
              class="filmes-grid"
            >

              <div
                v-for="filme in favoritos"
                :key="filme.id"
                class="filme-card"
                @click="abrirFilme(filme)"
              >

                <div class="capa-wrapper">

                  <img
                    :src="filme.capa"
                    :alt="filme.titulo"
                    class="filme-capa"
                  />

                  <div class="capa-overlay"></div>

                  <div class="nota">
                    <q-icon
                      name="star"
                      size="15px"
                    />

                    {{ filme.nota }}
                  </div>

                  <div class="tipo-filme favorito">
                    <q-icon
                      name="favorite"
                      size="15px"
                    />
                  </div>

                </div>

                <div class="filme-info">

                  <div class="filme-titulo">
                    {{ filme.titulo }}
                  </div>

                  <div class="filme-genero">
                    {{ filme.genero }}
                  </div>

                </div>

              </div>

            </div>


            <div
              v-else
              class="estado-vazio"
            >

              <div class="icone-vazio">
                <q-icon
                  name="favorite_border"
                  size="42px"
                />
              </div>

              <div class="vazio-titulo">
                Nenhum favorito ainda
              </div>

              <div class="vazio-texto">
                Adicione filmes aos favoritos para encontrá-los aqui.
              </div>

              <q-btn
                flat
                no-caps
                color="teal-3"
                label="Explorar filmes"
                icon="movie"
                class="botao-explorar"
                @click="$router.push('/')"
              />

            </div>

          </q-tab-panel>


          <!-- ASSISTIR DEPOIS -->

          <q-tab-panel name="assistir">

            <div
              v-if="assistirDepois.length"
              class="filmes-grid"
            >

              <div
                v-for="filme in assistirDepois"
                :key="filme.id"
                class="filme-card"
                @click="abrirFilme(filme)"
              >

                <div class="capa-wrapper">

                  <img
                    :src="filme.capa"
                    :alt="filme.titulo"
                    class="filme-capa"
                  />

                  <div class="capa-overlay"></div>

                  <div class="nota">
                    <q-icon
                      name="star"
                      size="15px"
                    />

                    {{ filme.nota }}
                  </div>

                  <div class="tipo-filme assistir">
                    <q-icon
                      name="schedule"
                      size="15px"
                    />
                  </div>

                </div>

                <div class="filme-info">

                  <div class="filme-titulo">
                    {{ filme.titulo }}
                  </div>

                  <div class="filme-genero">
                    {{ filme.genero }}
                  </div>

                </div>

              </div>

            </div>


            <div
              v-else
              class="estado-vazio"
            >

              <div class="icone-vazio">
                <q-icon
                  name="schedule"
                  size="42px"
                />
              </div>

              <div class="vazio-titulo">
                Sua lista está vazia
              </div>

              <div class="vazio-texto">
                Salve filmes para assistir depois e eles aparecerão aqui.
              </div>

              <q-btn
                flat
                no-caps
                color="teal-3"
                label="Explorar filmes"
                icon="movie"
                class="botao-explorar"
                @click="$router.push('/')"
              />

            </div>

          </q-tab-panel>


          <!-- CURTIDOS -->

          <q-tab-panel name="curtidos">

            <div
              v-if="curtidos.length"
              class="filmes-grid"
            >

              <div
                v-for="filme in curtidos"
                :key="filme.id"
                class="filme-card"
                @click="abrirFilme(filme)"
              >

                <div class="capa-wrapper">

                  <img
                    :src="filme.capa"
                    :alt="filme.titulo"
                    class="filme-capa"
                  />

                  <div class="capa-overlay"></div>

                  <div class="nota">
                    <q-icon
                      name="star"
                      size="15px"
                    />

                    {{ filme.nota }}
                  </div>

                  <div class="tipo-filme curtido">
                    <q-icon
                      name="thumb_up"
                      size="15px"
                    />
                  </div>

                </div>

                <div class="filme-info">

                  <div class="filme-titulo">
                    {{ filme.titulo }}
                  </div>

                  <div class="filme-genero">
                    {{ filme.genero }}
                  </div>

                </div>

              </div>

            </div>


            <div
              v-else
              class="estado-vazio"
            >

              <div class="icone-vazio">
                <q-icon
                  name="thumb_up_off_alt"
                  size="42px"
                />
              </div>

              <div class="vazio-titulo">
                Você ainda não curtiu nenhum filme
              </div>

              <div class="vazio-texto">
                Os filmes que você curtir aparecerão nesta coleção.
              </div>

              <q-btn
                flat
                no-caps
                color="teal-3"
                label="Explorar filmes"
                icon="movie"
                class="botao-explorar"
                @click="$router.push('/')"
              />

            </div>

          </q-tab-panel>

        </q-tab-panels>

      </section>


      <!-- =========================
           INFORMAÇÕES DA CONTA
      ========================== -->

      <section class="conta-section">

        <div class="secao-heading">

          <div>
            <div class="secao-titulo">
              Sua conta
            </div>

            <div class="secao-subtitulo">
              Gerencie suas informações
            </div>
          </div>

        </div>


        <div class="informacoes-grid">

          <div class="informacao-item">

            <div class="informacao-icone">
              <q-icon name="person_outline" />
            </div>

            <div>
              <div class="informacao-label">
                Nome
              </div>

              <div class="informacao-valor">
                {{ usuario?.nome || '—' }}
              </div>
            </div>

          </div>


          <div class="informacao-item">

            <div class="informacao-icone">
              <q-icon name="mail_outline" />
            </div>

            <div>
              <div class="informacao-label">
                E-mail
              </div>

              <div class="informacao-valor">
                {{ usuario?.email || '—' }}
              </div>
            </div>

          </div>

        </div>


        <div class="acoes-conta">

          <q-item
            clickable
            class="acao-item"
            @click="editarPerfil"
          >

            <q-item-section avatar>

              <div class="acao-icone">
                <q-icon name="edit" />
              </div>

            </q-item-section>

            <q-item-section>

              <q-item-label class="acao-titulo">
                Editar perfil
              </q-item-label>

              <q-item-label caption>
                Altere suas informações pessoais
              </q-item-label>

            </q-item-section>

            <q-item-section side>
              <q-icon name="chevron_right" />
            </q-item-section>

          </q-item>


          <q-item
            clickable
            class="acao-item acao-sair"
            @click="logout"
          >

            <q-item-section avatar>

              <div class="acao-icone">
                <q-icon name="logout" />
              </div>

            </q-item-section>

            <q-item-section>

              <q-item-label class="acao-titulo">
                Sair da conta
              </q-item-label>

              <q-item-label caption>
                Encerrar sua sessão neste dispositivo
              </q-item-label>

            </q-item-section>

            <q-item-section side>
              <q-icon name="chevron_right" />
            </q-item-section>

          </q-item>

        </div>

      </section>

    </div>

  </q-page>
</template>


<script setup>

import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useQuasar } from 'quasar'
import { api } from '../boot/axios'

const router = useRouter()
const $q = useQuasar()


// =========================
// USUÁRIO
// =========================

const usuario = ref(null)


// =========================
// ABA ATUAL
// =========================

const aba = ref('favoritos')


// =========================
// FILMES
// =========================

// Dados temporários.
// Depois vamos substituir pelos dados vindos da API.

const favoritos = ref([])

const assistirDepois = ref([])

const curtidos = ref([])


// =========================
// BUSCAR USUÁRIO
// =========================

async function buscarUsuario() {

  try {

    const response = await api.get('/user')

    usuario.value = response.data

  } catch (error) {

    usuario.value = null

    router.push('/login')

  }

}


// =========================
// ABRIR FILME
// =========================

function abrirFilme(filme) {

  console.log('Filme selecionado:', filme)

}


// =========================
// EDITAR PERFIL
// =========================

function editarPerfil() {

  $q.notify({
    type: 'info',
    message: 'Edição de perfil em desenvolvimento.'
  })

}


// =========================
// LOGOUT
// =========================

async function logout() {

  try {

    await api.post('/logout')

    usuario.value = null

    $q.notify({
      type: 'positive',
      message: 'Você saiu da sua conta.'
    })

    router.push('/')

  } catch (error) {

    $q.notify({
      type: 'negative',
      message: 'Não foi possível sair da conta.'
    })

  }

}


// =========================
// INICIALIZAÇÃO
// =========================

onMounted(() => {

  buscarUsuario()

})

</script>


<style scoped>

.perfil-page {
  min-height: 100vh;

  background:
    radial-gradient(
      circle at 50% -10%,
      rgba(0, 150, 136, 0.16),
      transparent 38%
    ),
    #1d1d1d;

  color: white;
}


.perfil-container {
  width: 100%;
  max-width: 1100px;

  margin: 0 auto;

  padding: 34px 30px 80px;
}


/* =================================
   TOPO
================================= */

.perfil-topo {
  display: flex;
  align-items: center;

  gap: 16px;

  margin-bottom: 38px;
}


.botao-voltar {
  color: rgba(255, 255, 255, 0.75);
}


.titulo-principal {
  font-size: 28px;

  font-weight: 700;

  letter-spacing: -0.5px;
}


.titulo-sub {
  margin-top: 4px;

  color: rgba(255, 255, 255, 0.45);

  font-size: 13px;
}


/* =================================
   PERFIL HERO
================================= */

.perfil-hero {
  display: flex;
  align-items: center;

  gap: 25px;

  padding: 8px 0 38px;

  border-bottom: 1px solid rgba(255, 255, 255, 0.07);
}


.avatar-grande {
  width: 104px;
  height: 104px;

  flex-shrink: 0;

  display: flex;
  align-items: center;
  justify-content: center;

  border-radius: 50%;

  background:
    linear-gradient(
      145deg,
      rgba(0, 150, 136, 0.30),
      rgba(0, 150, 136, 0.08)
    );

  color: #80cbc4;

  box-shadow:
    0 0 0 1px rgba(128, 203, 196, 0.12),
    0 15px 40px rgba(0, 0, 0, 0.25);
}


.dados-principais {
  display: flex;
  flex-direction: column;
}


.nome-usuario {
  font-size: 30px;

  font-weight: 700;

  letter-spacing: -0.5px;
}


.email-usuario {
  margin-top: 4px;

  color: rgba(255, 255, 255, 0.48);

  font-size: 14px;
}


.status-conta {
  display: flex;
  align-items: center;

  gap: 7px;

  margin-top: 12px;

  color: #80cbc4;

  font-size: 12px;
}


.status-ponto {
  width: 7px;
  height: 7px;

  border-radius: 50%;

  background: #4db6ac;

  box-shadow:
    0 0 8px rgba(77, 182, 172, 0.7);
}


/* =================================
   SEÇÕES
================================= */

.colecao,
.conta-section {
  margin-top: 42px;
}


.secao-heading {
  display: flex;
  justify-content: space-between;
  align-items: flex-end;

  margin-bottom: 20px;
}


.secao-titulo {
  font-size: 20px;

  font-weight: 700;
}


.secao-subtitulo {
  margin-top: 4px;

  color: rgba(255, 255, 255, 0.42);

  font-size: 13px;
}


/* =================================
   TABS
================================= */

.colecao-tabs {
  min-height: 48px;

  border-bottom: 1px solid rgba(255, 255, 255, 0.07);
}


.colecao-tabs :deep(.q-tab) {
  min-height: 48px;

  padding: 0 18px;

  color: rgba(255, 255, 255, 0.48);

  font-size: 13px;

  transition: color 0.2s ease;
}


.colecao-tabs :deep(.q-tab--active) {
  color: #80cbc4 !important;
}


.colecao-tabs :deep(.q-tab__icon) {
  font-size: 19px;

  margin-right: 6px;
}


.colecao-panels {
  background: transparent;
}


.colecao-panels :deep(.q-tab-panel) {
  padding: 28px 0 0;
}


/* =================================
   GRID DE FILMES
================================= */

.filmes-grid {
  display: grid;

  grid-template-columns:
    repeat(4, minmax(0, 1fr));

  gap: 22px;
}


.filme-card {
  cursor: pointer;

  min-width: 0;

  transition:
    transform 0.25s ease,
    opacity 0.25s ease;
}


.filme-card:hover {
  transform: translateY(-5px);
}


.capa-wrapper {
  position: relative;

  aspect-ratio: 2 / 3;

  overflow: hidden;

  border-radius: 11px;

  background: #292929;
}


.filme-capa {
  width: 100%;
  height: 100%;

  object-fit: cover;

  display: block;

  transition: transform 0.4s ease;
}


.filme-card:hover .filme-capa {
  transform: scale(1.045);
}


.capa-overlay {
  position: absolute;

  inset: 0;

  background:
    linear-gradient(
      to top,
      rgba(0, 0, 0, 0.72),
      transparent 45%
    );

  pointer-events: none;
}


.nota {
  position: absolute;

  top: 10px;
  left: 10px;

  display: flex;
  align-items: center;

  gap: 4px;

  padding: 5px 8px;

  border-radius: 7px;

  background: rgba(0, 0, 0, 0.68);

  backdrop-filter: blur(8px);

  color: #ffd54f;

  font-size: 12px;

  font-weight: 600;
}


.tipo-filme {
  position: absolute;

  top: 10px;
  right: 10px;

  width: 32px;
  height: 32px;

  display: flex;
  align-items: center;
  justify-content: center;

  border-radius: 50%;

  background: rgba(0, 0, 0, 0.68);

  backdrop-filter: blur(8px);
}


.tipo-filme.favorito {
  color: #ef9a9a;
}


.tipo-filme.assistir {
  color: #80cbc4;
}


.tipo-filme.curtido {
  color: #90caf9;
}


.filme-info {
  padding: 10px 2px 0;
}


.filme-titulo {
  overflow: hidden;

  white-space: nowrap;

  text-overflow: ellipsis;

  font-size: 14px;

  font-weight: 600;
}


.filme-genero {
  margin-top: 4px;

  color: rgba(255, 255, 255, 0.4);

  font-size: 12px;
}


/* =================================
   ESTADO VAZIO
================================= */

.estado-vazio {
  min-height: 290px;

  display: flex;
  flex-direction: column;

  align-items: center;
  justify-content: center;

  text-align: center;

  padding: 40px 20px;
}


.icone-vazio {
  width: 76px;
  height: 76px;

  display: flex;
  align-items: center;
  justify-content: center;

  margin-bottom: 17px;

  border-radius: 50%;

  background: rgba(255, 255, 255, 0.035);

  color: rgba(128, 203, 196, 0.7);
}


.vazio-titulo {
  font-size: 17px;

  font-weight: 600;
}


.vazio-texto {
  max-width: 380px;

  margin-top: 7px;

  color: rgba(255, 255, 255, 0.42);

  font-size: 13px;

  line-height: 1.5;
}


.botao-explorar {
  margin-top: 18px;
}


/* =================================
   CONTA
================================= */

.informacoes-grid {
  display: grid;

  grid-template-columns:
    repeat(2, minmax(0, 1fr));

  gap: 14px;
}


.informacao-item {
  display: flex;
  align-items: center;

  gap: 14px;

  padding: 18px;

  border-radius: 11px;

  background: rgba(255, 255, 255, 0.035);
}


.informacao-icone {
  width: 40px;
  height: 40px;

  flex-shrink: 0;

  display: flex;
  align-items: center;
  justify-content: center;

  border-radius: 10px;

  background: rgba(0, 150, 136, 0.10);

  color: #80cbc4;
}


.informacao-label {
  color: rgba(255, 255, 255, 0.4);

  font-size: 11px;
}


.informacao-valor {
  margin-top: 3px;

  font-size: 14px;

  font-weight: 500;
}


.acoes-conta {
  margin-top: 14px;
}


.acao-item {
  min-height: 72px;

  margin-bottom: 8px;

  border-radius: 11px;

  background: rgba(255, 255, 255, 0.035);

  transition:
    background 0.2s ease,
    transform 0.2s ease;
}


.acao-item:hover {
  background: rgba(255, 255, 255, 0.065);

  transform: translateX(3px);
}


.acao-icone {
  width: 38px;
  height: 38px;

  display: flex;
  align-items: center;
  justify-content: center;

  border-radius: 9px;

  background: rgba(0, 150, 136, 0.10);

  color: #80cbc4;
}


.acao-titulo {
  font-size: 14px;

  font-weight: 600;
}


.acao-sair .acao-icone {
  background: rgba(239, 154, 154, 0.08);

  color: #ef9a9a;
}


/* =================================
   RESPONSIVO
================================= */

@media (max-width: 850px) {

  .filmes-grid {
    grid-template-columns:
      repeat(3, minmax(0, 1fr));

    gap: 18px;
  }

}


@media (max-width: 650px) {

  .perfil-container {
    padding: 25px 17px 60px;
  }


  .perfil-topo {
    margin-bottom: 28px;
  }


  .titulo-principal {
    font-size: 23px;
  }


  .perfil-hero {
    gap: 18px;
  }


  .avatar-grande {
    width: 78px;
    height: 78px;
  }


  .avatar-grande .q-icon {
    font-size: 42px !important;
  }


  .nome-usuario {
    font-size: 22px;
  }


  .filmes-grid {
    grid-template-columns:
      repeat(2, minmax(0, 1fr));

    gap: 16px;
  }


  .colecao-tabs {
    overflow-x: auto;
  }


  .colecao-tabs :deep(.q-tab) {
    padding: 0 12px;

    min-width: max-content;
  }


  .informacoes-grid {
    grid-template-columns: 1fr;
  }

}


@media (max-width: 380px) {

  .filmes-grid {
    gap: 12px;
  }


  .filme-titulo {
    font-size: 13px;
  }


  .filme-genero {
    font-size: 11px;
  }

}

</style>