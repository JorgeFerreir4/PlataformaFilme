<template>
  <div class="q-pa-md">

    <q-table
      class="tabela-filmes"
      color="red"
      card-class="bg-grey-10 text-white"
      table-header-class="text-white text-bold"
      flat
      :filter="props.search"
      :filter-method="filtrarFilmes"
      bordered
      :rows="props.rows"
      :columns="columns"
      row-key="id"
      style="width: 1200px;"
      v-model:pagination="paginacao"
      @request="RequestTabela"
    >
      <template v-slot:body-cell-capa="props">

    <q-td :props="props">

      <q-img
        :src="`http://localhost/storage/${props.row.capa}`"
        style="width: 80px; height: 120px"
        fit="cover"
      />
    </q-td>
    </template>
      <template v-slot:body-cell-acoes="dados">
        <q-td :props="dados">

          <q-btn
            icon="edit"
            color="primary"
            flat
            @click="emit('editar', dados.row)"
          />

          <q-btn
            icon="delete"
            color="negative"
            flat
            @click="emit('excluir', dados.row)"
          />

          <q-btn
            icon="description"
            color="negative"
            flat
            @click="emit('propriedades', dados.row)"
          />

        <template v-slot:pagination="scope">
      
        <q-btn
          icon="chevron_left"
          color="grey-8"
          round
          dense
          flat
          @click="scope.prevPage"
        />

        <q-btn
          icon="chevron_right"
          color="grey-8"
          round
          dense
          flat
          @click="scope.nextPage"
        />
      </template>
          </q-td>
      </template>
    </q-table>

  </div>
</template>






<script setup>
import { ref, onMounted, watch } from 'vue'

const props = defineProps({
  rows: {
    type: Array,
    required: true
  },
  search: {
    type: String,
    default: ''
  }
})


const emit = defineEmits(['editar', 'excluir', 'propriedades'])

const paginacao = ref({
  page: 1,
  rowsPerPage: 5,
  rowsNumber: 0,
  
})


function filtrarFilmes(rows, terms, cols, getCellValue) {
  const texto = terms.toLowerCase().trim()

  if (!texto) {
    return rows
  }

  return rows.filter(row =>
    row.titulo.toLowerCase().includes(texto)
  )
}
function RequestTabela(props){
  console.log('request: ',props)
}


const columns = [
{
    name: 'capa',
    label: 'CAPA',
    align: 'left',
    field: 'capa',
  },
{
    name: 'titulo',
    label: 'TÍTULO',
    align: 'left',
    field: 'titulo',

  },
  {
    name: 'diretor',
    align: 'center',
    label: 'DIRETOR',
    field: 'diretor',
  },

  {
    name: 'ano',
    label: 'ANO',
    field: 'ano',
    sortable: true,
    sort: (a, b) => Number.parseInt(a, 10) - Number.parseInt(b, 10)
  },
  {
    name: 'genero',
    label: 'GÊNERO',
    field: 'genero',
  },
  {
    name: 'acoes',
    label: 'AÇÕES',
    field: 'acoes',
    align: 'center'
  },
  {

  },

]
</script>
