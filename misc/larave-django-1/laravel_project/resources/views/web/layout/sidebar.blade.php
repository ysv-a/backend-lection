<div class="hidden w-28 bg-slate-500 overflow-y-auto md:block">
    <div class="w-full py-6 flex flex-col items-center">
      <div class="flex-1 mt-2 w-full px-2 space-y-1">


        <a href="{{route('books.index')}}" class="{{ request()->routeIs('books.*') ? 'bg-slate-800 text-white' : 'text-indigo-100 hover:bg-slate-800 hover:text-white'}} group w-full p-3 rounded-md flex flex-col items-center text-xs font-medium">
          <svg xmlns="http://www.w3.org/2000/svg"  class="{{request()->routeIs('books.*') ? 'bg-slate-800 text-white' : ' text-white'}} h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
          </svg>
          <span class="mt-2">Books</span>
        </a>

        <a href="{{route('posts.index')}}" class="{{ request()->routeIs('posts.*') ? 'bg-slate-800 text-white' : 'text-indigo-100 hover:bg-slate-800 hover:text-white'}} group w-full p-3 rounded-md flex flex-col items-center text-xs font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="{{request()->routeIs('posts.*') ? 'bg-slate-800 text-white' : ' text-white'}} h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
              </svg>
            <span class="mt-2">Posts</span>
          </a>

      </div>
    </div>
  </div>
