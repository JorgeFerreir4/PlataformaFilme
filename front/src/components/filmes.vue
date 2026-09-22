
<template>


    <div class="text-h4 text-weight-bold text-white q-mb-lg">
      Filmes
    </div>

    <div class="row q-col-gutter-lg">

      <div
        v-for="filme in filmes"
        :key="filme.id"
        class="col-6 col-sm-4 col-md-3 col-lg-2-4"
      >
        <q-card class="filme-card bg-grey-10">

          <q-img
            :src="filme.capa"
            :ratio="2 / 3"
            loading="lazy"
            spinner-color="white"
          />

          <q-card-section>
            <div class="text-subtitle1 text-weight-bold text-white ellipsis">
              {{ filme.titulo }}
            </div>

            <div class="text-caption text-grey-5">
              {{ filme.ano }} • {{ filme.genero }}
            </div>
          </q-card-section>

          <q-card-actions align="center">
            <q-btn
              flat
              color="primary"
              label="Editar"
              @click="editarFilme(filme)"
            />

            <q-btn
              flat
              color="negative"
              label="Excluir"
              @click="excluirFilme(filme)"
            />
          </q-card-actions>

        </q-card>
      </div>

    </div>yy
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
  filmes: {
    type: Array,
    required: true
  },
  search: {
    type: String,
    default: ''
  }
})
console.log(props.filmes)

function editarFilme(filme) {
  console.log('Editar:', filme)
}

function excluirFilme(filme) {
  console.log('Excluir:', filme)
}
</script>

<style scoped>
.filme-card {
  height: 100%;
  transition: transform 0.2s;
}

.filme-card:hover {
  transform: translateY(-5px);
}

.col-lg-2-4 {
  width: 20%;
}

@media (max-width: 1199px) {
  .col-lg-2-4 {
    width: auto;
  }
}
</style>
