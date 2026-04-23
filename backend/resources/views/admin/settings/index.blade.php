@extends('admin.layouts.app')

@section('content')
<h2 class="text-xl font-semibold mb-4">Settings</h2>
<form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-3 max-w-lg">@csrf
    <div>
        <label>Commission %</label>
        <input name="commission_percent" type="number" step="0.01" class="w-full bg-slate-800 rounded px-2 py-1" value="{{ $settings['commission_percent'] ?? 10 }}" />
    </div>
    <div>
        <label>Platform Fee</label>
        <input name="platform_fee" type="number" step="0.01" class="w-full bg-slate-800 rounded px-2 py-1" value="{{ $settings['platform_fee'] ?? 0 }}" />
    </div>
    <button class="bg-cyan-700 px-3 py-2 rounded">Save Settings</button>
</form>
@endsection
