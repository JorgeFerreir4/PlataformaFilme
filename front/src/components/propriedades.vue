<template>
<q-dialog 
  v-model="props.dialogprop"
  backdrop-filter='blur(10px)'
  transition-show="slide-up"
  transition-hide="slide-down"
  transition-duration="400">

  <q-card
  class="bg-grey-10"
  style="width: 900px; max-width: 90vw;"
>

    <q-card-section class="row justify-between items-center">

      <q-item-section class="text-h4">
                {{ props.filmeselect.titulo }}
      </q-item-section>

      <q-btn
      icon="close"
      @click="emit('fechar')"
      flat
      round
      />
    </q-card-section>


    <!-- INFORMAÇÕES -->
     <q-card-section>
    <div class="row">

        <div class="col-4">

          <div class="q-pa-sm">
            <!--<q-img
              :src="`http://localhost/storage/${props.filmeselect.capa}`"
                class="rounded-borders"
              />
            -->

             <q-img v-if="props.filmeselect.capa"
              :src="props.filmeselect.capa"
              class="rounded-borders"
              error-src ='http://localhost/storage/holdplace.jpeg'
            />
          </div>
        </div>


        <div class="col-8">

           <div class="q-pa-md">
            <q-list>
              <q-item>
                <q-item-section avatar>
                  <q-icon name="person"/>
                </q-item-section>

                <q-item-section>
                  <q-item-label caption>Diretor</q-item-label>
                  <q-item-label class="text-subtitle1">
                    {{ props.filmeselect.diretor }}
                </q-item-label>
              </q-item-section>
          </q-item>

          <q-item>
            <q-item-section avatar>
              <q-icon name="calendar_month"/>
            </q-item-section>

            <q-item-section>
              <q-item-label caption >Ano</q-item-label>
              <q-item-label class="text-subtitle1" >
                {{ props.filmeselect.ano }}
              </q-item-label>
            </q-item-section>
          </q-item>

          <q-item>
            <q-item-section avatar>
              <q-icon name="category"/>
            </q-item-section>

            <q-item-section>
              <q-item-label caption>Gênero</q-item-label>
              <q-item-label class="text-subtitle1" >
                {{ props.filmeselect.genero }}
              </q-item-label>
            </q-item-section>
          </q-item>

          <q-item>
            <q-item-section avatar>
              <q-icon name="description"/>
            </q-item-section>

            <q-item-section>
              <q-item-label caption>Sinopse</q-item-label>
              <q-item-label class="text-subtitle1" >
                {{ props.filmeselect.sinopse }}
              </q-item-label>
            </q-item-section>
          </q-item>

        </q-list>
      </div>

    </div>
  </div>
</q-card-section>

  </q-card>
</q-dialog>
</template>

<script setup>
import {ref} from 'vue'

const props = defineProps({
  dialogprop:{
    type: Boolean
  },
  filmeselect:{
    type:Object,
    required:true
  }
})
function teste() {
  console.log('clicou')
  emit('fechar')
}

const emit = defineEmits(['fechar'])
</script>
