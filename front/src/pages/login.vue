<template>
  <q-page class="bg-grey-10 flex flex-center q-pa-md">

    <q-card
      flat
      bordered
      class="login-card bg-grey-9 text-white"
    >

      <q-card-section class="text-center q-pb-none">

        <q-avatar
          size="70px"
          color="teal"
          text-color="white"
          class="q-mb-md"
        >
          <q-icon name="person" size="40px" />
        </q-avatar>

        <div class="text-h4 text-weight-bold">
          Bem-vindo
        </div>

        <div class="text-subtitle2 text-grey-5 q-mt-sm">
          Entre na sua conta para continuar
        </div>

      </q-card-section>


      <q-card-section>

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


        <q-btn
          unelevated
          color="teal"
          text-color="white"
          label="Entrar"
          icon="login"
          class="full-width q-mt-lg"
          size="md"
          @click="login"
        />

      </q-card-section>


      <q-card-section class="text-center q-pt-none">

        <div class="text-grey-5">
          Ainda não possui uma conta?
        </div>

        <q-btn
          flat
          no-caps
          color="light-blue-3"
          label="Criar conta"
          class="q-mt-xs"
          @click="$router.push('/cadastro')"
        />

      </q-card-section>

    </q-card>

  </q-page>
</template>


<script setup>

import { ref } from 'vue'
import { useQuasar } from 'quasar'
import { api } from '../boot/axios'

const $q = useQuasar()

const email = ref('')
const password = ref('')
const mostrarSenha = ref(false)


async function login() {

  try {

    const response = await api.post('/login', {
      email: email.value,
      password: password.value
    })

    console.log(response.data)

    $q.notify({
      type: 'positive',
      message: 'Login realizado com sucesso.'
    })

  } catch (error) {

    console.log(error)
    console.log(error.response?.data)

    $q.notify({
      type: 'negative',
      message: 'E-mail ou senha inválidos.'
    })

  }

}


function criarConta() {

  console.log('Criar conta')

}

</script>


<style scoped>

.login-card {
  width: 100%;
  max-width: 430px;
  border-radius: 14px;
}

</style>