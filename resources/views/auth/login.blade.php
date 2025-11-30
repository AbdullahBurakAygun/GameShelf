<x-guest-layout>
    <div
        class="w-full max-w-md rounded-3xl bg-slate-900/95 border border-slate-800
               shadow-[0_0_80px_rgba(88,80,236,0.35)] px-8 py-10 sm:px-10 sm:py-12">

       =
        <h1 class="text-3xl sm:text-4xl font-semibold text-white text-center">
            GameShelf
        </h1>
        <p class="mt-3 text-center text-sm text-slate-400">
            Sign in to manage your game library
        </p>

        
        @if (session('status'))
            <div class="mt-4 text-sm text-green-400">
                {{ session('status') }}
            </div>
        @endif

        
        <x-auth-session-status class="mt-4 mb-2" :status="session('status')" />
        <x-input-error :messages="$errors->all()" class="mt-2" />

        
        <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-6">
            @csrf

            
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-slate-200" />

                <x-text-input id="email"
                              class="mt-1 block w-full bg-slate-900 border-slate-700 text-slate-100
                                     focus:border-indigo-500 focus:ring-indigo-500"
                              type="email"
                              name="email"
                              :value="old('email')"
                              required
                              autofocus
                              autocomplete="username" />
            </div>

           
            <div>
                <x-input-label for="password" :value="__('Password')" class="text-slate-200" />

                <x-text-input id="password"
                              class="mt-1 block w-full bg-slate-900 border-slate-700 text-slate-100
                                     focus:border-indigo-500 focus:ring-indigo-500"
                              type="password"
                              name="password"
                              required
                              autocomplete="current-password" />
            </div>

            
            <div class="flex items-center justify-between text-sm">
                <label for="remember_me" class="flex items-center space-x-2 text-slate-300">
                    <input id="remember_me" type="checkbox"
                           class="rounded border-slate-600 bg-slate-900 text-indigo-500
                                  focus:ring-indigo-500"
                           name="remember">
                    <span>{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-indigo-400 hover:text-indigo-300"
                       href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            
            <div class="pt-2">
                <button type="submit"
                        class="w-full inline-flex justify-center items-center px-4 py-3
                               bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm
                               rounded-full transition shadow-lg shadow-indigo-500/40">
                    {{ __('Sign in') }}
                </button>
            </div>
        </form>

        {{-- Register link --}}
        <p class="mt-6 text-center text-xs text-slate-400">
            No account yet?
            <a href="{{ route('register') }}" class="text-indigo-400 font-semibold hover:text-indigo-300">
                {{ __('Register') }}
            </a>
        </p>
    </div>
</x-guest-layout>
