@if(session('success'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
    class="mb-6 px-4 py-3 rounded-xl bg-green-50 border border-green-100 flex items-center justify-between gap-3 shadow-sm shadow-green-100/50 transition-all duration-300">
    <div class="flex items-center gap-3">
        <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-white shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <p class="text-sm font-bold text-green-800">{{ session('success') }}</p>
    </div>
    <button @click="show = false" class="text-green-400 hover:text-green-600 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>
@endif

@if(session('error'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
    class="mb-6 px-4 py-3 rounded-xl bg-red-50 border border-red-100 flex items-center justify-between gap-3 shadow-sm shadow-red-100/50 transition-all duration-300">
    <div class="flex items-center gap-3">
        <div class="w-8 h-8 rounded-full bg-red-500 flex items-center justify-center text-white shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
            </svg>
        </div>
        <p class="text-sm font-bold text-red-800">{{ session('error') }}</p>
    </div>
    <button @click="show = false" class="text-red-400 hover:text-red-600 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>
@endif

@if(session('info'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
    class="mb-6 px-4 py-3 rounded-xl bg-sky-50 border border-sky-100 flex items-center justify-between gap-3 shadow-sm shadow-sky-100/50 transition-all duration-300">
    <div class="flex items-center gap-3">
        <div class="w-8 h-8 rounded-full bg-sky-500 flex items-center justify-center text-white shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12v-.008z" />
            </svg>
        </div>
        <p class="text-sm font-bold text-sky-800">{{ session('info') }}</p>
    </div>
    <button @click="show = false" class="text-sky-400 hover:text-sky-600 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>
@endif