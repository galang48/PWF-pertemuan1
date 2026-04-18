<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm uppercase tracking-[0.25em] text-cyan-300">Account</p>
                <h2 class="text-2xl font-semibold text-white">{{ __('Profile') }}</h2>
            </div>
            <p class="text-sm text-slate-400">Kelola informasi akun, keamanan, dan penghapusan akun.</p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <div class="grid gap-6 xl:grid-cols-[0.7fr,1.3fr]">
                <aside class="rounded-[28px] border border-white/10 bg-slate-950/50 p-6 shadow-xl shadow-black/20 backdrop-blur-xl">
                    <div class="flex items-center gap-4">
                        <div class="flex h-16 w-16 items-center justify-center rounded-3xl bg-cyan-400/15 text-xl font-bold uppercase text-cyan-200">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-white">{{ $user->name }}</h3>
                            <p class="text-sm text-slate-400">{{ $user->email }}</p>
                        </div>
                    </div>

                    <div class="mt-6 space-y-3 text-sm text-slate-300">
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                            Simpan profil agar data akun tetap akurat dan mudah dikenali.
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                            Gunakan password baru yang kuat untuk menjaga keamanan akun.
                        </div>
                        <div class="rounded-2xl border border-rose-400/20 bg-rose-500/10 p-4 text-rose-200">
                            Penghapusan akun bersifat permanen dan tidak dapat dibatalkan.
                        </div>
                    </div>
                </aside>

                <div class="space-y-6">
                    <div class="rounded-[28px] border border-white/10 bg-white/10 p-6 shadow-xl shadow-black/20 backdrop-blur-xl sm:p-8">
                        <div class="max-w-2xl">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    <div class="rounded-[28px] border border-white/10 bg-white/10 p-6 shadow-xl shadow-black/20 backdrop-blur-xl sm:p-8">
                        <div class="max-w-2xl">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                    <div class="rounded-[28px] border border-rose-400/20 bg-rose-500/10 p-6 shadow-xl shadow-black/20 backdrop-blur-xl sm:p-8">
                        <div class="max-w-2xl">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
