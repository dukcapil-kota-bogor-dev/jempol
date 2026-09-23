<nav x-data="{ open: false }" class="bg-white border-r border-gray-200 h-screen flex flex-col w-64">
    <div class="flex items-center px-6 h-20">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <x-application-logo class="h-9 w-auto text-indigo-600" />
        </a>
    </div>

    <div class="flex-1 px-4 py-4 space-y-1">
        <p class="px-4 text-[10px] font-semibold text-gray-400 uppercase tracking-widest mb-2">Main Menu</p>
        
        <a href="{{ route('dashboard') }}" 
           class="{{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-700' }} group flex items-center px-4 py-2.5 text-sm font-medium rounded-xl transition-all duration-200">
            <i class="fas fa-home w-5 mr-3 text-lg {{ request()->routeIs('dashboard') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
            {{ __('Dashboard') }}
        </a>

        <a href="{{ route('pemohon.index') }}" 
   class="{{ request()->routeIs('pemohon.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-700' }} group flex items-center px-4 py-2.5 text-sm font-medium rounded-xl transition-all duration-200">
    <i class="fas fa-thumbs-up w-5 mr-3 text-lg {{ request()->routeIs('pemohon.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
    {{ __('Jempol Bahagia') }}
</a>

          <a href="{{ route('goes_to_school.index') }}" 
   class="{{ request()->routeIs('goes_to_school.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-700' }} group flex items-center px-4 py-2.5 text-sm font-medium rounded-xl transition-all duration-200">
    <i class="fas fa-school w-5 mr-3 text-lg {{ request()->routeIs('goes_to_school.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
    {{ __('goes to school') }}
</a>

<a href="{{ route('lsm.index') }}" 
   class="{{ request()->routeIs('lsm.*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-700' }} group flex items-center px-4 py-2.5 text-sm font-medium rounded-xl transition-all duration-200">
    <span class="relative w-5 mr-3 inline-flex items-center justify-center">
        <i class="fas fa-sun text-sm {{ request()->routeIs('lsm.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
        <i class="fas fa-moon text-[10px] absolute -bottom-1 -right-1 {{ request()->routeIs('lsm.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
    </span>
    {{ __('LSM') }}
</a>
        <p class="px-4 text-[10px] font-semibold text-gray-400 uppercase tracking-widest mb-2 mt-4">Pengaturan</p>
        
        <a href="{{ route('profile.edit') }}" 
           class="{{ request()->routeIs('profile.edit') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-700' }} group flex items-center px-4 py-2.5 text-sm font-medium rounded-xl transition-all duration-200">
            <i class="fas fa-user-cog w-5 mr-3 text-lg {{ request()->routeIs('profile.edit') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
            {{ __('Kelola Akun') }}
        </a>
    </div>
</nav>