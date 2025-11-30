<x-guest-layout>
    <div
        class="w-full max-w-md rounded-3xl bg-slate-900/95 border border-slate-800
               shadow-[0_0_80px_rgba(88,80,236,0.35)] px-8 py-10 sm:px-10 sm:py-12">

        
        <h1 class="text-3xl sm:text-4xl font-semibold text-white text-center">
            GameShelf
        </h1>
        <p class="mt-3 text-center text-sm text-slate-400">
            Create an account to start your game library
        </p>

       
        <x-input-error :messages="$errors->all()" class="mt-4" />

        
        <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-6">
            @csrf

           
            <div>
                <x-input-label for="name" :value="__('Name')" class="text-slate-200" />

                <x-text-input id="name"
                              class="mt-1 block w-full bg-slate-900 border-slate-700 text-slate-100
                                     focus:border-indigo-500 focus:ring-indigo-500"
                              type="text"
                              name="name"
                              :value="old('name')"
                              required
                              autofocus
                              autocomplete="name" />
            </div>

           
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-slate-200" />

                <x-text-input id="email"
                              class="mt-1 block w-full bg-slate-900 border-slate-700 text-slate-100
                                     focus:border-indigo-500 focus:ring-indigo-500"
                              type="email"
                              name="email"
                              :value="old('email')"
                              required
                              autocomplete="username" />
            </div>

            {{-- Password --}}
            <div>
                <x-input-label for="password" :value="__('Password')" class="text-slate-200" />

                <x-text-input id="password"
                              class="mt-1 block w-full bg-slate-900 border-slate-700 text-slate-100
                                     focus:border-indigo-500 focus:ring-indigo-500"
                              type="password"
                              name="password"
                              required
                              autocomplete="new-password" />
            </div>

            {{-- Confirm Password --}}
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm password')" class="text-slate-200" />

                <x-text-input id="password_confirmation"
                              class="mt-1 block w-full bg-slate-900 border-slate-700 text-slate-100
                                     focus:border-indigo-500 focus:ring-indigo-500"
                              type="password"
                              name="password_confirmation"
                              required
                              autocomplete="new-password" />
            </div>

            {{-- Sign up butonu --}}
            <div class="pt-2">
                <button type="submit"
                        class="w-full inline-flex justify-center items-center px-4 py-3
                               bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm
                               rounded-full transition shadow-lg shadow-indigo-500/40">
                    {{ __('Sign up') }}
                </button>
            </div>
        </form>

        {{-- Login link --}}
        <p class="mt-6 text-center text-xs text-slate-400">
            Already have an account?
            <a href="{{ route('login') }}" class="text-indigo-400 font-semibold hover:text-indigo-300">
                {{ __('Sign in') }}
            </a>
        </p>
    </div>
</x-guest-layout>
