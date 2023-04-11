<script setup>
import axios from "axios";
import { ref } from "vue";

axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
axios.defaults.headers.common["Content-Type"] = "application/json";
axios.defaults.headers.common["Accept"] = "application/json";
axios.defaults.withCredentials = true;

const email = ref('')
const password = ref('')
const remember = ref('')

axios.get("http://127.0.0.1:8000/sanctum/csrf-cookie");

async function send() {
    const resp = await axios.post("http://127.0.0.1:8000/api-fortify/login", {
        'email': email.value,
        'password': password.value,
        'remember': remember.value,
    });
    console.log(resp)
}

async function getData() {
    const resp = await axios.get("http://127.0.0.1:8000/api/user");
    console.log(resp)
}

</script>

<template>

    <div class="mt-10 max-w-xl mx-auto">
        <div class="flex flex-col gap-6">
            <input v-model="email" type="email" name="email" placeholder="Email">
            <input v-model="password" type="password" name="password" placeholder="Password">
            <div class="flex gap-3 items-center">
                <input v-model="remember" id="remember" type="checkbox" name="remember">
                <label for="remember">Remember me?</label>
            </div>
            <button @click="send" type="submit" class="bg-slate-900 hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2 focus:ring-offset-slate-50 text-white font-semibold h-12 px-6 rounded-lg w-full flex items-center justify-center sm:w-auto dark:bg-sky-500 dark:highlight-white/20 dark:hover:bg-sky-400">Login</button>
        </div>

        <div class="mt-10">
            <button @click="getData" type="submit" class="bg-slate-900 hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2 focus:ring-offset-slate-50 text-white font-semibold h-12 px-6 rounded-lg w-full flex items-center justify-center sm:w-auto dark:bg-sky-500 dark:highlight-white/20 dark:hover:bg-sky-400">Get User</button>
        </div>

    </div>

</template>
