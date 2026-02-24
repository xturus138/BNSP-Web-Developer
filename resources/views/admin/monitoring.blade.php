@extends('layouts.admin')

@section('title', 'System Monitoring - INBISKOM')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">System Monitoring</h1>
    <p class="text-sm text-gray-500 mt-1">Pemantauan resource dan status kesehatan aplikasi secara real-time.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    {{-- App Status --}}
    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <span class="text-sm font-medium text-gray-500">Status Aplikasi</span>
            <div class="w-3 h-3 rounded-full bg-{{ $status['app']['color'] }}-500 animate-pulse"></div>
        </div>
        <div class="flex items-baseline gap-2">
            <h3 class="text-2xl font-bold text-{{ $status['app']['color'] }}-600">{{ $status['app']['message'] }}</h3>
        </div>
        <p class="text-xs text-gray-400 mt-2">Checking endpoint: /up</p>
    </div>

    {{-- DB Status --}}
    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <span class="text-sm font-medium text-gray-500">Database</span>
            <svg class="w-5 h-5 text-{{ $status['db']['color'] }}-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
            </svg>
        </div>
        <div class="flex items-baseline gap-2">
            <h3 class="text-2xl font-bold text-{{ $status['db']['color'] }}-600">{{ $status['db']['message'] }}</h3>
        </div>
        <p class="text-xs text-gray-400 mt-2">Connection via Eloquent ORM</p>
    </div>

    {{-- Memory Usage --}}
    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <span class="text-sm font-medium text-gray-500">Memory Usage</span>
            <svg class="w-5 h-5 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
            </svg>
        </div>
        <div class="flex items-baseline gap-2">
            <h3 class="text-2xl font-bold text-gray-900">{{ $status['resources']['memory'] ?? 'N/A' }}</h3>
        </div>
        <p class="text-xs text-gray-400 mt-2">Peak usage of current script</p>
    </div>

    {{-- Storage --}}
    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <span class="text-sm font-medium text-gray-500">Storage</span>
            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2z" />
            </svg>
        </div>
        <div class="flex items-baseline gap-2">
            <h3 class="text-2xl font-bold text-gray-900">{{ $status['resources']['disk_free'] ?? 'N/A' }} Free</h3>
        </div>
        <div class="w-full bg-gray-100 rounded-full h-1.5 mt-3">
            <div class="bg-amber-500 h-1.5 rounded-full" style="width: {{ $status['resources']['disk_usage'] ?? 0 }}%"></div>
        </div>
        <p class="text-[10px] text-gray-400 mt-1">Usage: {{ $status['resources']['disk_usage'] ?? '0' }}%</p>
    </div>
</div>

<div class="grid grid-cols-1 gap-6">
    {{-- System Info --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h2 class="text-base font-bold text-gray-900">System Information</h2>
        </div>
        <div class="p-6">
            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-gray-500">PHP Version</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $status['system']['php_version'] }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Laravel Version</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $status['system']['laravel_version'] }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Operating System</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $status['system']['os'] }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Server Environment</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $status['system']['server'] }}</dd>
                </div>
            </dl>
        </div>
    </div>
</div>
@endsection