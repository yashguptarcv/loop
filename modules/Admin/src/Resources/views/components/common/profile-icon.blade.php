<img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::guard('admin')->user()->name ?? 'User') }}&background=024A3F&color=FFB90C"
    alt="Avatar" class="w-10 h-10 rounded-full mr-3 border-2 border-amber-100">
<div>

    <p class="font-medium text-amber-100"> {{ Str::limit(Auth::guard('admin')->user()->name ?? 'User', 15) }}</p>
    <p class="text-xs text-amber-100">{{ Auth::guard('admin')->user()->role->name ?? 'Admin' }}</p>
</div>