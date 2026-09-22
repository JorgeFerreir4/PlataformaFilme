<template>
<q-dialog v-model="props.dialog" persistent
backdrop-filter='blur(10px)'>

  <q-card style="min-width:500px">

    <q-card-section>
      <div class="text-h6">
        Editar Filme
      </div>
    </q-card-section>
    <q-form @submit="editar">
    <q-card-section>

      <q-input
        v-model="filme.titulo"
        label="Título"
        :rules="[value => !!value || 'O Título é obrigatório']"
      />

      <q-input
        v-model="filme.diretor"
        label="Diretor"
        :rules="[value => !!value || 'O Diretor é obrigatório']"
      />

      <q-input
        v-model="filme.ano"
        label="Ano"
        mask="####"
        :rules="[
        val => (val > 1000 && val < 2030) || 'Digirte um ano'
      ]"
      />

      <q-select
        filled
        v-model="filme.genero"
        multiple
        :options="['Ação','Aventura','Comédia','Drama','Fantasia','Terror','Mistério','Romance','Ficção Científica','Suspense','Animação','Família','Biografia','Crime']"
        label="Gênero"
        style="width: 250px"
        :rules="[value => !!value || 'O gênero é obrigatório']"
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

    <q-card-actions align="right">

      <q-btn
        flat
        label="Cancelar"
        @click="cancelar"
      />

      <q-btn
        color="primary"
        label="editar"
        type="submit"
      />

    </q-card-actions>
  </q-form>
  </q-card>

</q-dialog>
</template>
<script setup>
import {ref, watch, reactive} from 'vue'
import { useQuasar } from 'quasar'
const $q = useQuasar()

const props = defineProps({
  dialog:{
    type: Boolean
  },
  filmeselect:{
    type:Object,
    required:true
  },
  FilmeSalvou:{
    type:Boolean,
    required:true
  }
})
const emit = defineEmits(['editar','cancelar'])



const form = ref(null)


function FileRejeitado(rejectedEntries) {
  console.log(rejectedEntries)
  if(rejectedEntries[0].file.type != 'image/jpeg' && rejectedEntries[0].file.type != 'image/webp' && rejectedEntries[0].file.type != 'image/png'){
    $q.notify({
      type: 'negative',
      message: `${rejectedEntries[0].file.name} não é do tipo JPG, PNG ou WEBP`
    })
  }

  if(rejectedEntries[0].file.size > 2048){
    $q.notify({
      type: 'negative',
      message: `O arquivo é maior que 2 MB`
    })
  }

}
  

const filme = reactive({
  titulo:'',
  diretor:'',
  ano:'',
  genero:[],
  sinopse:'',
})
const capa = ref(null)

function cancelar() {
  emit('cancelar')
  filme.titulo = ''
  filme.diretor = ''
  filme.ano = ''
  filme.genero = ''
  filme.sinopse = ''
  capa.value = null 
}


function editar(){
console.log('funçao editar')
  emit('editar', {
    filme,
    capa: capa.value
  })
}


watch(() => props.filmeselect, (novovalor) => {
  
  Object.assign(filme, novovalor)

  filme.genero = filme.genero.split(', ')

})


</script>
