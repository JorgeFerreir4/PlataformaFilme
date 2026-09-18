<template>
    <q-dialog v-model="props.dialog" persistent>

      <q-card style="min-width: 500px">

        <q-card-section>
          <div class="text-h6">
            Cadastrar Filme
          </div>
        </q-card-section>


      <q-form 
      @submit="salvarFilme">
        <q-card-section>
          
          <q-input
            autofocus
            v-model="filme.titulo"
            label="Título"
            :rules="[
              val=> !!val || 'O título é obrigatório'
            ]"
          />

          <q-input
            v-model="filme.diretor"
            label="Diretor"
            :rules="[
              val => !!val || 'O diretor é obrigatório'
            ]"
          />

          <q-input
            v-model="filme.ano"
            label="Ano"
            mask="####"
            :rules="[
              val => (val > 1895 && val < 2030)
                || 'Digite um ano válido'
            ]"
          />

          <q-select
            filled
            v-model="filme.genero"
            multiple
            :options="[
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
            ]"
            label="Gênero"
            style="width: 250px"
            :rules="[
              val => val.length > 0 || 'O gênero é obrigatório'
            ]"
            max-values="3"
            hint="Escolha até 3 gêneros"
          />

          <q-input
            v-model="filme.sinopse"
            label="Sinopse"
          />

          <q-file
            v-model="capa"
            label="Capa do filme"
            accept="image/jpeg, image/png, image/webp"
            max-file-size="2000000"
            filled
            hint="JPG, PNG ou WEBP. Tamanho máximo: 2 MB"
            @rejected="FileRejeitado"
            >
            <template v-slot:append>
              <q-icon name="attach_file" />
            </template>
          </q-file>
        </q-card-section>

        <q-card-section align="right">

          <q-btn
            flat
            label="Cancelar"
            @click="cancelar"
          />

          <q-btn
            color="primary"
            label="Salvar"
            type="submit"
          />

        </q-card-section>
        </q-form>
      </q-card>
    </q-dialog>
</template>


<script setup>

import { reactive, watch, ref } from 'vue'
import { useQuasar } from 'quasar'
const $q = useQuasar()


const emit = defineEmits([
  'salvarFilme',
  'cancelar',
  'FilmeSalvou'
])


const props = defineProps({

  dialog: {
    type: Boolean,
    required: true
  },

  FilmeSalvou: {
    type: Boolean,
    required: true
  }

})


const form = ref(null)



const filme = reactive({

  titulo: '',
  diretor: '',
  ano: '',
  genero: [],
  sinopse: ''

})


const capa = ref()


function cancelar() {

  filme.titulo = ''
  filme.diretor = ''
  filme.ano = ''
  filme.genero = []
  filme.sinopse = ''

  capa.value = null

  form.value?.resetValidation()

  emit('cancelar')

}


function salvarFilme() {

  emit('salvarFilme', {
    filme,
    capa: capa.value
  })

}

function FileRejeitado(rejectedEntries) {
  console.log(rejectedEntries)
  if(rejectedEntries[0].file.type != 'image/jpeg' && rejectedEntries[0].file.type != 'image/webp' && rejectedEntries[0].file.type != 'image/png'){
    $q.notify({
      type: 'negative',
      message: `${rejectedEntries[0].file.name} não é do tipo JPG, PNG ou WEBP`
    })
  }

  if(rejectedEntries[0].failedPropValidation === "max-file-size"){
    $q.notify({
      type: 'negative',
      message: `O arquivo ${rejectedEntries[0].file.name} é maior que 2 MB`
    })
  }

}



// Quando o pai avisar que o filme foi salvo
watch(
  () => props.FilmeSalvou,
  (novoValor) => {

    if (novoValor === true) {

      filme.titulo = ''
      filme.diretor = ''
      filme.ano = ''
      filme.genero = []
      filme.sinopse = ''

      capa.value = null

      form.value?.resetValidation()

      emit('FilmeSalvou')
    }

  }
)

</script>