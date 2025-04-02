<style>
    /* since nested groupes are not supported we have to use
    regular css for the nested dropdowns
    */
    .MENU li>ul {
        transform: translatex(100%) scale(0);
        z-index: 50;
    }

    .MENU li:hover>ul {
        transform: translatex(101%) scale(1);
        z-index: 50;
    }

    .MENU li>button svg {
        transform: rotate(-90deg);
        z-index: 50;
    }

    .MENU li:hover>button svg {
        transform: rotate(-270deg);
        z-index: 50;
    }

    /* Below styles fake what can be achieved with the tailwind config
    you need to add the group-hover variant to scale and define your custom
    min width style.
        See https://codesandbox.io/s/tailwindcss-multilevel-dropdown-y91j7?file=/index.html
        for implementation with config file
    */
    .MENU .group:hover .group-hover\:scale-100 {
        transform: scale(1);
        z-index: 50;
    }

    .MENU .group:hover .group-hover\:-rotate-180 {
        transform: rotate(180deg);
        z-index: 50;
    }

    .MENU .scale-0 {
        transform: scale(0);
        z-index: 50;
    }

    .MENU .min-w-32 {
        min-width: 8rem;
        z-index: 50;
    }

    .MENU a:link {
        text-decoration: none;
        color: black;
        background-color: white;
        z-index: 50;
    }

    .MENU a:visited {
        text-decoration: none;
        color: black;
        background-color: white;
        z-index: 50;
    }

    .MENU a:hover {
        text-decoration: none;
        color: black;
        background-color: white;
        z-index: 50;
    }

    .MENU a:active {
        text-decoration: none;
        color: black;
        background-color: white;
        z-index: 50;
    }
</style>
<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex w-full justify-between h-min flex-col p-1">
            <div class="flex w-full justify-between items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('inventarios.inicio') }}">
                        <x-jet-application-mark class="block h-9 w-auto" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="MENU w-min md:w-full">
                        <div class="hidden space-x-2 md:flex md:items-center sm:ml-10 justify-between h-16">
                            <div class="w-full md:flex flex-wrap">
                                <!-- Administracion -->
                                @can('users.index')
                                <div class="group inline-block" align="left" width="48">
                                    <button
                                        class="outline-none focus:outline-none px-3 py-1 bg-white rounded-sm flex items-center min-w-32">
                                        <span class="pr-1 font-semibold flex-1">Administracion</span>
                                        <span>
                                            <svg class="fill-current h-4 w-4 transform group-hover:-rotate-180
                                                transition duration-150 ease-in-out"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                            </svg>
                                        </span>
                                    </button>
                                    <ul
                                        class="bg-white border rounded-sm transform scale-0 group-hover:scale-100 absolute
                                        transition duration-150 ease-in-out origin-top min-w-32">
                                        <!-- Usuarios -->
                                        @can('users.index')
                                            <li class="rounded-sm relative px-3 py-1 hover:bg-gray-100">
                                                <button class="w-full text-left flex items-center outline-none focus:outline-none">
                                                    <span class="pr-1 flex-1">Usuarios</span>
                                                    <span class="mr-auto">
                                                        <svg class="fill-current h-4 w-4
                                                    transition duration-150 ease-in-out"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                            <path
                                                                d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                                        </svg>
                                                    </span>
                                                </button>
        
                                                <ul
                                                    class="bg-white border rounded-sm absolute top-0 right-0
                                                    transition duration-150 ease-in-out origin-top-left
                                                    min-w-32
                                                    ">
                                                    <a href="{{ route('users.inicio') }}">
                                                        <li class="px-3 py-1 hover:bg-gray-100">Inicio</li>
                                                    </a>
                                                    <a href="{{ route('users.index') }}">
                                                        <li class="px-3 py-1 hover:bg-gray-100">Gestión</li>
                                                    </a>
                                                    <a href="{{ route('roles.index') }}">
                                                        <li class="px-3 py-1 hover:bg-gray-100">Roles</li>
                                                    </a>
                                                    @can('users.create')
                                                        <a href="{{ route('users.create') }}">
                                                            <li class="px-3 py-1 hover:bg-gray-100">Crear</li>
                                                        </a>
                                                    @endcan
                                                    @can('users.baja')
                                                        <a href="{{ route('users.usuariosBaja') }}">
                                                            <li class="px-3 py-1 hover:bg-gray-100">Baja</li>
                                                        </a>
                                                    @endcan
                                                    <a href="{{ route('users.centros') }}">
                                                        <li class="px-3 py-1 hover:bg-gray-100">Plantas</li>
                                                    </a>
                                                </ul>
                                            </li>
                                        @endcan   
                                    </ul>
                                </div>
                                @endcan
                                <!-- Inicio -->
                                @can('inventario')
                                <div class="group inline-block" align="left" width="48">
        
                                    <button class="outline-none focus:outline-none px-3 py-1 bg-white rounded-sm flex items-center min-w-32">
                                        <a href="{{ route('inventarios.inicio') }}">
                                            <span class="pr-1 font-semibold flex-1">Inicio MERLA</span>
                                        </a>
                                    </button>
                                </div>
                                
                                <!-- Pedidos -->
                                
                                <div class="group inline-block" align="left" width="48">
                                    <button class="outline-none focus:outline-none px-3 py-1 bg-white rounded-sm flex items-center min-w-32">
                                        <span class="font-semibold flex-1">Pedidos</span>
                                        <span>
                                            <svg class="fill-current h-4 w-4 transform group-hover:-rotate-180
                                                transition duration-150 ease-in-out"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                            </svg>
                                        </span>  
                                    </button>
                                    <ul
                                        class="bg-white border rounded-sm transform scale-0 group-hover:scale-100 absolute
                                        transition duration-150 ease-in-out origin-top min-w-32">
                                        <!-- Solicitar Producto -->
                                        <li class="rounded-sm relative px-3 py-1 hover:bg-gray-100">
                                            <a href="{{ route('inventarios.create') }}">
                                                <ul class="pr-1 flex-1">Solicitar Producto</ul> 
                                            </a>
                                        </li>
                                        @can('inventario.proximosAgotar')
                                        <li class="rounded-sm relative px-3 py-1 hover:bg-gray-100">
                                            <a href="{{ route('inventarios.proximosAgotar') }}">
                                                <ul class="pr-1 flex-1">Productos proximos a agotar</ul> 
                                            </a>
                                        </li>
                                        @endcan
                                        <li class="rounded-sm relative px-3 py-1 hover:bg-gray-100">
                                            <a href="{{route('inventarios.index')}}">
                                                <ul class="pr-1 flex-1">Consultar Pedidos</ul> 
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('inventarios.pedidoespecial') }}">
                                                <ul class="px-3 py-1 hover:bg-gray-100">Pedido Especial</ul>
                                            </a>
                                        </li>
                                        @can('inventario.autorizar')
                                        <li>
                                            <a href="{{ route('inventarios.autorizar') }}">
                                                <ul class="px-3 py-1 hover:bg-gray-100">Autorizar Pedidos</ul>
                                            </a>
                                        </li>
                                        @endcan
                                        @can('inventario.authPedidoEspecial')
                                        <li>
                                            <a href="{{ route('inventarios.indexPedidoEspecial') }}">
                                                <ul class="px-3 py-1 hover:bg-gray-100">Autorizar Pedidos Especiales</ul>
                                            </a>
                                        </li>   
                                        @endcan 
                                        @can('inventario.entregar')
                                        <li>
                                        
                                            <a href="{{ route('inventarios.entregar') }}">
                                                <ul class="px-3 py-1 hover:bg-gray-100">Entregar Pedidos</ul>
                                            </a>
                                            <a href="{{ route('inventarios.entregados') }}">
                                                <ul class="px-3 py-1 hover:bg-gray-100">Pedidos Entregados</ul>
                                            </a>
                                        </li>
                                        @endcan
                                    </ul>
                                </div>
                                  <!-- Inventario -->
                                @if(
                                    @Auth::user()->can('producto.todosalmacenes') ||
                                    @Auth::user()->can('inventarios.categoria') ||
                                    @Auth::user()->can('producto.existencias'))
                                <div class="group inline-block" align="left" width="48">
                                    <button class="outline-none focus:outline-none px-3 py-1 bg-white rounded-sm flex items-center min-w-32">    
                                        <span class="font-semibold flex-1">Inventario</span>
                                        <span>
                                            <svg class="fill-current h-4 w-4 transform group-hover:-rotate-180
                                                transition duration-150 ease-in-out"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                            </svg>
                                        </span>  
                                    </button>
                                    <ul
                                        class="bg-white border rounded-sm transform scale-0 group-hover:scale-100 absolute
                                        transition duration-150 ease-in-out origin-top min-w-32">
                                        <!-- Solicitar Producto -->
                                        @if (@Auth::user()->eid == '9JJGM' || @Auth::user()->can('producto.todosalmacenes'))
                                        <li class="rounded-sm relative px-3 py-1 hover:bg-gray-100">
                                            <a href="{{ route('productos.indexTotal') }}">
                                                <ul class="pr-1 flex-1">Inventario general</ul> 
                                            </a>
                                        </li>
                                        @endif
                                        <!-- 
======= Section =======
                                        @can('producto.existencias')
                                        <li class="rounded-sm relative px-3 py-1 hover:bg-gray-100">
                                            {{-- <a href="{{ route('productos.indexI') }}">
                                                <ul class="pr-1 flex-1">Agregar Existencias</ul> 
                                            </a> --}}
                                            <a href="{{ route('productos.eliminarExistenciasIndex') }}">
                                                <ul class="pr-1 flex-1">Gestionar Existencias</ul> 
                                            </a>
                                        </li>
                                        @endcan
                                        ======= End  =======-->
                                        @can('inventario.categoria')
                                        <li>
                                            <a href="{{ route('categorias.create') }}">
                                                <ul class="px-3 py-1 hover:bg-gray-100">Crear Categoría</ul>
                                            </a>
                                            <a href="{{ route('categorias.index') }}">
                                                <ul class="px-3 py-1 hover:bg-gray-100">Consultar Categorías</ul>
                                            </a>
                                        </li>
                                        @endcan   
                                    </ul>
                                </div>
                                @endif   
        
                                <!-- Productos -->
                                @if(
                                    @Auth::user()->can('producto.crear') ||                                                    
                                    @Auth::user()->can('producto.existencias'))
                                <div class="group inline-block" align="left" width="48">
                                    <button class="outline-none focus:outline-none px-3 py-1 bg-white rounded-sm flex items-center min-w-32">
                                        <span class="font-semibold flex-1">Productos</span>
                                        <span>
                                            <svg class="fill-current h-4 w-4 transform group-hover:-rotate-180
                                                transition duration-150 ease-in-out"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                            </svg>
                                        </span>  
                                    </button>
                                    <ul
                                        class="bg-white border rounded-sm transform scale-0 group-hover:scale-100 absolute
                                        transition duration-150 ease-in-out origin-top min-w-32">
                                        @can('producto.crear')
                                        <li>
                                            <a href="{{ route('productos.create') }}">
                                                <ul class="px-3 py-1 hover:bg-gray-100">Crear Producto</ul> 
                                            </a>
                                            <a href="{{ route('productos.index') }}">
                                                <ul class="px-3 py-1 hover:bg-gray-100">Consultar Productos</ul>
                                            </a>
                                            
                                            @if (
                                                !Auth::user()->can('producto.todosalmacenes') and
                                                    !Auth::user()->hasRole('usuario') and
                                                    App\Models\Almacen::where('jefe_eid', auth()->user()->datos->eid)->where('habilitado', 1)->count() !=
                                                        0)
                                                <a href="{{ route('productos.indexSubareas') }}">
                                                    <li class="px-3 py-1 hover:bg-gray-100">Consultar Productos por Subárea</li>
                                                </a>
                                            @endif
                                            {{-- @can('inventarios.reponer')
                                                <a href="{{ route('inventarios.reponer') }}">
                                                    <li class="px-3 py-1 hover:bg-gray-100">Reponer Producto</li>
                                                </a>
                                            @endcan --}}
                                        </li>
                                        @endcan  
                                    </ul>
                                </div>
                                @endif
                                
                                <!-- Mermas -->
                                @can('inventario.mermas')
                                <div class="group inline-block items-center" align="left" width="48">
        
                                    <button class="outline-none focus:outline-none px-3 py-1 bg-white rounded-sm flex items-center min-w-32">
                                        <span class="font-semibold flex-1">Mermas</span>
                                        <span>
                                            <svg class="fill-current h-4 w-4 transform group-hover:-rotate-180
                                                transition duration-150 ease-in-out"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                            </svg>
                                        </span>  
                                    </button>
                                    <ul
                                        class="bg-white border rounded-sm transform scale-0 group-hover:scale-100 absolute
                                        transition duration-150 ease-in-out origin-top min-w-32">
                                        <!-- Solicitar Producto -->
                                        <li>
                                            <a href="{{ route('mermas.index') }}">
                                                <ul class="px-3 py-1 hover:bg-gray-100">Mermas</ul>
                                            </a>
                                            <a href="{{ route('mermas.indexHistorial') }}">
                                                <ul class="px-3 py-1 hover:bg-gray-100">Historial Mermas</ul>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                @endcan
                                <!-- Almacenes -->
                                @can('inventario.almacen')
                                <div class="group inline-block" align="left" width="48">
                                    <button class="outline-none focus:outline-none px-3 py-1 bg-white rounded-sm flex items-center min-w-32">
                                        <a href="{{ route('almacenes.index')}}">
                                            <span class="pr-1 font-semibold flex-1">Almacenes </span>
                                        </a>
                                    </button>
                                </div>
                                @endcan
                                @endcan
                                
                                <!-- MERLA 1 -->
                                {{-- <div class="group inline-block" align="left" width="48">
                                    <button class="outline-none focus:outline-none px-3 py-1 bg-white rounded-sm flex items-center min-w-32">
                                        <a href="{{ route('inventarios.inicio') }}">
                                            <span class="pr-1 font-semibold flex-1">Inicio </span>
                                        </a>
                                        <span>
                                            <svg class="fill-current h-4 w-4 transform group-hover:-rotate-180
                                                transition duration-150 ease-in-out"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                            </svg>
                                        </span>
                                        
                                    </button> 
                                </div>--}}
                        </div>
                            
                <!-- Settings Dropdown -->
                <div class="ml-3 relative">
                    <x-jet-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button
                                    class="text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-150 transition align-middle  flex justify-between items-center">
                                    <img class="h-8 w-8 mr-2 rounded-full object-cover"
                                        src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->eid }}" />
                                    {{ Auth::user()->eid }}
                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                        {{ Auth::user()->eid }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Administracion') }}
                            </div>

                            <x-jet-dropdown-link href="{{ route('users.datosPersonales') }}">
                                {{ __('Datos personales') }}
                            </x-jet-dropdown-link>

                            <x-jet-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Configuracion') }}
                            </x-jet-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-jet-dropdown-link>
                            @endif

                            <div class="border-t border-gray-100"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-jet-dropdown-link href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Cerrar') }}
                                </x-jet-dropdown-link>
                            </form>
                        </x-slot>
                    </x-jet-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-jet-responsive-nav-link href="{{ route('inventarios.inicio') }}" :active="request()->routeIs('inventarios.inicio')">
                {{ __('Inicio') }}
            </x-jet-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 divide-y-2">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="shrink-0 mr-3">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                            alt="{{ Auth::user()->name }}" />
                    </div>
                @endif

                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-jet-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Profile') }}
                </x-jet-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-jet-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-jet-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-jet-responsive-nav-link href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                    this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-jet-responsive-nav-link>
                </form>

                <!-- Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="border-t border-gray-200"></div>

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Manage Team') }}
                    </div>

                    <!-- Team Settings -->
                    <x-jet-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}"
                        :active="request()->routeIs('teams.show')">
                        {{ __('Team Settings') }}
                    </x-jet-responsive-nav-link>

                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                        <x-jet-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                            {{ __('Create New Team') }}
                        </x-jet-responsive-nav-link>
                    @endcan

                    <div class="border-t border-gray-200"></div>

                    <!-- Team Switcher -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Switch Teams') }}
                    </div>

                    @foreach (Auth::user()->allTeams() as $team)
                        <x-jet-switchable-team :team="$team" component="jet-responsive-nav-link" />
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</nav>
