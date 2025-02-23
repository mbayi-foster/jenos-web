<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="flex items-center justify-center mx-auto my-5 px-12">
            <div class="flex flex-col md:flex-row w-full max-w-4xl bg-gray-200 overflow-hidden items-center">
                <div class="md:w-1/2 w-full">
                    <figure class="relative max-w-sm transition-all duration-300 cursor-pointer filter ">
                        <a href="#">
                            <img class="w-full h-full object-cover" src="@/assets/img/jp.jpg" alt="Bonnie image" />
                        </a>
                        <figcaption class="absolute px-4 text-lg text-white left-4 top-40">
                            <h1
                                class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-white md:text-5xl lg:text-6xl dark:text-white">
                                Welcom Back !</h1>
                        </figcaption>
                    </figure>
                </div>
                <div class="md:w-1/2 p-8 w-full">
                    <div>
                        <!--     <a href="/">
                            <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                        </a> -->
                    </div>
                    <h2 class="text-2xl font-bold mb-6">Connectez vous</h2>

                    <form method="POST" @submit.prevent="submitForm">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700" for="email">Email</label>
                            <input type="email" id="email" v-model="data.email"
                                class="mt-1 block w-full border border-gray-300  p-2 rounded-full" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700" for="password">Mot de passe</label>
                            <input type="password" id="password" v-model="data.password"
                                class="mt-1 block w-full border border-gray-300 p-2 rounded-full" required>
                        </div>
                        <!--    <div class="flex items-center mb-4">
                            <input type="checkbox" id="remember" class="mr-2 rounded-full" name="remember">
                            <label for="remember" class="text-sm text-gray-600">Rester connecté</label>
                        </div> -->
                        <div role="status" class="flex justify-center items-center" v-if="load">
                            <svg aria-hidden="true"
                                class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-yellow-500"
                                viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                    fill="currentColor" />
                                <path
                                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                    fill="currentFill" />
                            </svg>
                            <span class="sr-only">Loading...</span>
                        </div>
                        <button v-else type="submit"
                            class="rounded-full w-full bg-orange-500 text-white font-bold py-2">Se
                            connecter</button>

                        <p class="text-sm mt-4 text-gray-600">Mot de passe oublier ? <a href="#"
                                class="text-blue-500">Contacter l'administrateur</a></p>

                    </form>
                </div>

            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import api from '@/api/api'
import { useRouter } from 'vue-router';
import { useUserStore } from '@/stores/store'

const store = useUserStore()
const data = ref(
    {
        email: "",
        password: ""
    }
)
const router = useRouter()
const user = ref([])
const load = ref(false)
const hasError = ref(false)

const submitForm = async () => {
    load.value = true
    hasError.value = false
    try {
        user.value = await api.post('/login/users', data.value)
        load.value = false
        store.login(user.value)
        router.push('/')
        console.log("les donnees de l'utilisateur : ", user.value)
    } catch (error) {
        load.value = false
        hasError.value = true
        console.log("une erreur s'est produite ", error)
    }
}
</script>