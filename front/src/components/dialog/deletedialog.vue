<template>
 <q-dialog v-model="prosp.OpenDialogDelete" persistent>
    <q-card>
      <q-card-section class="row items-center">
        <span class="q-ml-sm"
          >Tem certeza que deseja excluir esse filme?</span>
      </q-card-section>

      <q-card-actions align="right">
        <q-btn flat label="Cancelar" color="primary"
        @click="emit('cancelar')" />

        <q-btn flat label="Excluir"
        color="primary"
        @click="emit('excluir', filmepradeletar)" />

      </q-card-actions>
    </q-card>
  </q-dialog>
</template>
<script setup>

const prosp = defineProps({
  OpenDialogDelete:{
    type: Boolean
  },
  filmepradeletar:{
    type:Object
  }

})

const emit = defineEmits(['excluir','cancelar'])

</script>
