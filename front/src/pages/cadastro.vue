<template>
  <q-page class="bg-grey-10 flex flex-center q-pa-md">

    <q-card
      flat
      bordered
      class="cadastro-card bg-grey-9 text-white"
    >

      <q-card-section class="text-center q-pb-none">

        <q-avatar
          size="70px"
          color="teal"
          text-color="white"
          class="q-mb-md"
        >
          <q-icon name="person_add" size="40px" />
        </q-avatar>

        <div class="text-h4 text-weight-bold">
          Criar conta
        </div>

        <div class="text-subtitle2 text-grey-5 q-mt-sm">
          Cadastre-se para continuar
        </div>

      </q-card-section>


      <q-card-section>

        <q-input
          v-model="nome"
          filled
          dark
          label="Nome de usuário"
          color="teal"
          class="q-mb-md"
        >
          <template #prepend>
            <q-icon name="person" />
          </template>
        </q-input>


        <q-input
          v-model="email"
          filled
          dark
          type="email"
          label="E-mail"
          color="teal"
          class="q-mb-md"
        >
          <template #prepend>
            <q-icon name="email" />
          </template>
        </q-input>


        <q-input
          v-model="password"
          filled
          dark
          :type="mostrarSenha ? 'text' : 'password'"
          label="Senha"
          color="teal"
          class="q-mb-md"
        >
          <template #prepend>
            <q-icon name="lock" />
          </template>

          <template #append>
            <q-icon
              :name="mostrarSenha ? 'visibility_off' : 'visibility'"
              class="cursor-pointer"
              @click="mostrarSenha = !mostrarSenha"
            />
          </template>
        </q-input>


        <q-input
          v-model="passwordConfirmation"
          filled
          dark
          :type="mostrarConfirmacao ? 'text' : 'password'"
          label="Confirmar senha"
          color="teal"
        >
          <template #prepend>
            <q-icon name="lock_outline" />
          </template>

          <template #append>
            <q-icon
              :name="mostrarConfirmacao ? 'visibility_off' : 'visibility'"
              class="cursor-pointer"
              @click="mostrarConfirmacao = !mostrarConfirmacao"
            />
          </template>
        </q-input>


        <q-btn
          unelevated
          color="teal"
          text-color="white"
          label="Cadastrar"
          icon="person_add"
          class="full-width q-mt-lg"
          size="md"
          @click="cadastrar"
        />

      </q-card-section>


      <q-card-section class="text-center q-pt-none">

        <div class="text-grey-5">
          Já possui uma conta?
        </div>

        <q-btn
          flat
          no-caps
          color="light-blue-3"
          label="Fazer login"
          class="q-mt-xs"
          @click="$router.push('/login')"
        />

      </q-card-section>

    </q-card>

  </q-page>
</template>


<script setup>

import { ref } from 'vue'
import { useQuasar } from 'quasar'
import { api } from '../boot/axios'
import { useRouter } from 'vue-router'

const router = useRouter()

const $q = useQuasar()

const nome = ref('')
const email = ref('')
const password = ref('')
const passwordConfirmation = ref('')

const mostrarSenha = ref(false)
const mostrarConfirmacao = ref(false)


async function cadastrar() {

  if (
    !nome.value ||
    !email.value ||
    !password.value ||
    !passwordConfirmation.value
  ) {
    $q.notify({
      type: 'warning',
      message: 'Preencha todos os campos.'
    })

    return
  }


  if (password.value !== passwordConfirmation.value) {

    $q.notify({
      type: 'negative',
      message: 'As senhas não coincidem.'
    })

    return
  }

  if (password.value.length < 8) {

    $q.notify({
      type: 'negative',
      message: 'A senha deve ter pelo menos 8 caracteres.'
    })

    return
  }

  
  try {

    await api.post('/cadastrar', {
      nome: nome.value,
      email: email.value,
      senha: password.value,
    })

    $q.notify({
      type: 'positive',
      message: 'Conta criada com sucesso. Agora faça login'
    })

    router.push('/login')

  } catch (error) {
    if(error.response){
        let erros = error.response?.data.errors
        for(const erro in erros){

          for(const erro2 of erros[erro]){

            $q.notify({
            type: 'negative',
            message: erro2   })
          }
        }
    }
  }

}

</script>


<style scoped>

.cadastro-card {
  width: 100%;
  max-width: 430px;
  border-radius: 14px;
}

</style>