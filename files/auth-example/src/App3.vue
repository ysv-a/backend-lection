<script setup>
import fileDownload from 'js-file-download';

function startGetRequest()
{
    fetch('http://localhost:9999/', {

    })
    .then(response => response.json())
    .then((resp) => {
        console.log(resp)
    });

// headers: {
//     'X-Authorization': 'asfdsdfgfdgf4tsdgs'
// },

}
function startPostRequest()
{
    const user = {
        firstName: 'John',
        email: 'test@gm.com',
    }

    const form = new FormData()
    form.append('firstName', 'John')
    form.append('email', 'test@gm.com')

    fetch('http://localhost:9999/posts.php', {
      method: 'POST',
      body: form,
    // headers: {
    //     'Content-Type': 'application/json;charset=utf-8'
    // },
    //   body: JSON.stringify(user)
    }).then(response => response.json())
    .then((resp) => {
        console.log(resp)
    });

}

function startCookieRequest()
{
    fetch('http://localhost:9999/cookie.php', {
        credentials: 'include'
    })
    .then(response => response.json())
    .then((resp) => {
        console.log(resp)
    });
}
function startCookieRequestRead()
{
    fetch('http://localhost:9999/readCookie.php', {
        credentials: 'include'
    })
    .then(response => response.json())
    .then((resp) => {
        console.log(resp)
    });
}

function startReadHeaders()
{


    fetch('http://localhost:9999/file.php')
    .then(response => {
        return response.blob().then(blob => {
            return {
                contentType: response.headers.get("Content-Type"),
                contentDisposition: response.headers.get("Content-Disposition"),
                fileName: response.headers.get("X-File-Name"),
                raw: blob
            }
        })
    })
  .then(data => {
    console.log(data)
    fileDownload(data.raw, 'example.pdf')
  });


}

</script>

<template>

    <div class="container">
        <div class="py-5 my-5">
            <button type="button" @click="startGetRequest" class="bg-slate-900 hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2 focus:ring-offset-slate-50 text-white font-semibold h-12 px-6 rounded-lg w-full flex items-center justify-center sm:w-auto dark:bg-sky-500 dark:highlight-white/20 dark:hover:bg-sky-400">Start GET Request</button>
        </div>
        <div class="py-5 my-5">
            <button type="submit" @click="startPostRequest" class="bg-slate-900 hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2 focus:ring-offset-slate-50 text-white font-semibold h-12 px-6 rounded-lg w-full flex items-center justify-center sm:w-auto dark:bg-sky-500 dark:highlight-white/20 dark:hover:bg-sky-400">Start POST Request</button>
        </div>
        <div class="py-5 my-5 flex gap-5">
            <button type="submit" @click="startCookieRequest" class="bg-slate-900 hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2 focus:ring-offset-slate-50 text-white font-semibold h-12 px-6 rounded-lg w-full flex items-center justify-center sm:w-auto dark:bg-sky-500 dark:highlight-white/20 dark:hover:bg-sky-400">Add Cookie</button>
            <button type="submit" @click="startCookieRequestRead" class="bg-slate-900 hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2 focus:ring-offset-slate-50 text-white font-semibold h-12 px-6 rounded-lg w-full flex items-center justify-center sm:w-auto dark:bg-sky-500 dark:highlight-white/20 dark:hover:bg-sky-400">Read Cookie</button>
        </div>

        <div class="py-5 my-5 flex gap-5">

            <button type="submit" @click="startReadHeaders" class="bg-slate-900 hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2 focus:ring-offset-slate-50 text-white font-semibold h-12 px-6 rounded-lg w-full flex items-center justify-center sm:w-auto dark:bg-sky-500 dark:highlight-white/20 dark:hover:bg-sky-400">Read Headers</button>
        </div>

    </div>

</template>
