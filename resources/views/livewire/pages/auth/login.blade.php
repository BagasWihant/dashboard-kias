<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />



    <!-- Background Gambar Perusahaan Full -->
    <div class="absolute inset-0 z-0">
        <img src="{{asset('/assets/bg.jpg')}}" alt="Company Background"
            class="w-full h-full object-cover aspect-video brightness-90 saturate-125" />
        <div class="absolute inset-0 bg-gradient-to-tr from-slate-500/50 via-blue-500/40 to-blue-600/20 backdrop-blur-sm">
        </div>
    </div>

    <!-- Konten Login -->
    <div class="relative z-10 flex items-center justify-center min-h-screen px-4 py-10">
        <div
            class="relative z-10 w-full max-w-md bg-white/30 backdrop-blur-sm border border-white/10 shadow-2xl rounded-2xl p-8 space-y-8 animate-slideFade">


            <div class="text-center">
                <x-application-logo class="w-16 h-16 mx-auto " />
                <h2 class="mt-6 text-3xl font-bold tracking-tight text-black">Login ke SKIS</h2>
                {{-- <p class="text-sm text-black">Gunakan akun perusahaan Anda</p> --}}
            </div>

            <form  wire:submit="login" class="space-y-6">
                <div>
                    <label for="nik" class="block text-sm font-medium text-black">NIK</label>
                    <input wire:model="form.nik" id="nik" name="nik" type="text" required autofocus
                        class="mt-1 w-full rounded-3xl bg-white/70 text-black border border-indigo-300/20
                                  placeholder-black px-4 py-2 transition-all duration-300
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-400
                                  shadow focus:shadow-[0_0_0_3px_rgba(236,72,153,0.2)]"
                        placeholder="Masukkan NIK Anda" />
                    <x-input-error :messages="$errors->get('form.nik')" class="mt-2 text-sm text-red-600" />
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-black">Password</label>
                    <input wire:model="form.password" id="password" name="password" type="password" required
                        class="mt-1 block w-full rounded-3xl bg-white/70 text-black border border-indigo-300/20 
                    focus:ring-2 focus:ring-blue-500 focus:border-blue-400 focus:outline-none 
                    transition-all duration-200 shadow-sm placeholder-black"
                        placeholder="••••••••" />
                    <x-input-error :messages="$errors->get('form.password')" class="mt-2 text-sm text-red-600" />
                </div>

                <div class="flex items-center justify-between text-sm text-black">
                  

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="hover:underline" wire:navigate>
                            Lupa password?
                        </a>
                    @endif
                </div>

                <button type="submit"
                    class="w-full py-2 rounded-3xl text-sm font-semibold text-indigo-200
                   bg-gradient-to-r from-blue-500 via-blue-700 to-blue-500
                   shadow-lg shadow-blue-500/30 transition-all duration-300
                   hover:brightness-125 hover:shadow-blue-500/50
                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Masuk
                </button>
            </form>

            <p class="text-center text-xs text-black">&copy; {{ date('Y') }} {{ config('app.name') }}. All
                rights reserved.</p>

        </div>
    </div>

</div>
