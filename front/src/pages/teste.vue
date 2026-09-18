<template>
  <q-page class="bg-grey-2 q-pa-lg">

    <!-- Card principal -->
    <q-card  style="max-width: 80%;" align="right" flat bordered>

      <!-- Cabeçalho -->
      <q-card-section  class="row items-center justify-between">

        <div>
          <div class="text-h5 text-weight-bold">
            Filmes
          </div>

          <div class="text-grey">
            Lista de filmes cadastrados no sistema
          </div>
        </div>

        <q-btn
          color="primary"
          icon="add"
          label="Novo Filme"
          @click="novoFilme"
        />

      </q-card-section>

      <!-- Campo de busca -->
      <q-card-section class="q-pt-none">

        <q-input
          outlined
          dense
          v-model="filter"
          placeholder="Buscar filme..."
          style="max-width:300px"
        >
          <template v-slot:prepend>
            <q-icon name="search"/>
          </template>
        </q-input>

      </q-card-section>

      <!-- Tabela -->
      <q-table
        :rows="filmes"
        :columns="columns"
        row-key="id"
        :filter="filter"
        flat
        separator="horizontal"
        hide-bottom
      >

        <!-- Coluna de ações -->
        <template v-slot:body-cell-acoes="props">

          <q-td align="left">

            <q-btn
              flat
              round
              dense
              color="blue"
              icon="edit"
              @click="editar(props.row)"
            />

            <q-btn
              flat
              round
              dense
              color="red"
              icon="delete"
              @click="excluir(props.row)"
            />

          </q-td>

        </template>

      </q-table>

      <!-- Rodapé -->
      <q-card-section class="row justify-between items-center">

        <div class="text-grey text-caption">
          Exibindo {{ filmes.length }} registros
        </div>

        <div class="text-grey text-caption">
          Página 1 de 1
        </div>

      </q-card-section>

    </q-card>

  </q-page>
</template>

<script setup>
import { ref } from 'vue'

const filter = ref('')

const columns = [

  {
    name: 'id',
    label: 'ID',
    field: 'id',
    align: 'left'
  },

  {
    name: 'titulo',
    label: 'TÍTULO',
    field: 'titulo',
    align: 'left'
  },

  {
    name: 'diretor',
    label: 'DIRETOR',
    field: 'diretor',
    align: 'left'
  },

  {
    name: 'ano',
    label: 'ANO',
    field: 'ano',
    align: 'left'
  },

  {
    name: 'genero',
    label: 'GÊNERO',
    field: 'genero',
    align: 'left'
  },

  {
    name: 'acoes',
    label: 'AÇÕES',
    field: 'acoes',
    align: 'left'
  }

]

const filmes = ref([

  {
    id: 1,
    titulo: 'Interestelar',
    diretor: 'Christopher Nolan',
    ano: 2014,
    genero: 'Ficção Científica'
  },

  {
    id: 2,
    titulo: 'O Poderoso Chefão',
    diretor: 'Francis Ford Coppola',
    ano: 1972,
    genero: 'Drama'
  },

  {
    id: 3,
    titulo: 'Matrix',
    diretor: 'Lana e Lilly Wachowski',
    ano: 1999,
    genero: 'Ação'
  },

  {
    id: 4,
    titulo: 'Parasita',
    diretor: 'Bong Joon-ho',
    ano: 2019,
    genero: 'Suspense'
  },

  {
    id: 5,
    titulo: 'Cidade de Deus',
    diretor: 'Fernando Meirelles',
    ano: 2002,
    genero: 'Drama'
  }

])

function novoFilme() {
  console.log('Novo Filme')
}

function editar(filme) {
  console.log(filme)
}

function excluir(filme) {
  console.log(filme)
}
</script>

<style scoped>

.q-table thead tr {
  background: #f5f5f5;
}

.q-table th {
  font-weight: bold;
}

</style>