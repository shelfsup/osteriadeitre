{{-- <navbar class="d-flex justify-content-between align-items-center px-3" style="position:absolute; top:0; left: 0; right:0; height: 80px; border-bottom: 2px solid rgba(255, 255, 255, 0.457);">
    <h2 class="m-0">{{ ucfirst(Route::currentRouteName()) }}</h2>
</navbar> --}}

<nav class="navbar navbar-expand-lg ">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <x-application-mark class="h-9" />
        </a>

        <!-- Hamburger -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Links -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <h2 class="m-0">
                        @if (Route::currentRouteName() == 'profile.show')
                            Profilo
                        @else
                            {{ ucfirst(Route::currentRouteName()) }}
                        @endif
                    </h2>
                    {{-- <a class="nav-link {{ request()->routeIs('Home') ? 'active' : '' }}" href="{{ route('home') }}">{{ __('Home') }}</a> --}}
                </li>
            </ul>



            <div class="d-flex">
                @livewire('toggle.dark-mode2')
            </div>

            <!-- Teams Dropdown -->
            @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                <div class="ms-3 dropdown">
                    <div class="ms-3 dropdown">
                        <button class="btn-profilo dropdown-toggle" type="button" id="settingsDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="width: fit-content !important; border-radius: 13px !important;">
                            <svg class="ms-2 me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                            </svg>
                            {{ Auth::user()->currentTeam->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="settingsDropdown">

                            @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                <!-- Create New Team -->
                                <li><a class="dropdown-item" href="{{ route('teams.create') }}">{{ __('Crea Team') }}</a></li>
                            @endcan

                            <!-- Teams Dropdown -->
                            @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                                <li><a class="dropdown-item" href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">{{ __('Impostazioni Team') }}</a></li>
                            @endif




                            <!-- Team Switcher -->
                            @if (Auth::user()->allTeams()->count() > 1)
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <div class="dropdown-item">
                                    <p class="m-0 fw-bold" style="color: var(--color-text);">{{ __('Cambia Team') }}</p>
                                </div>
                                @foreach (Auth::user()->allTeams() as $team)
                                    <x-switchable-team :team="$team" />
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            @endif



            <!-- Settings Dropdown -->
            <div class="ms-3 dropdown">
                <button class="btn-profilo dropdown-toggle" type="button" id="settingsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                        <img class="rounded-circle me-1" width="30" height="30" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    @endif
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="settingsDropdown">
                    <!-- Profile -->
                    <li><a class="dropdown-item" href="{{ route('profile.show') }}">{{ __('Account') }}</a></li>

                    @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                        <!-- API Tokens -->
                        <li><a class="dropdown-item" href="{{ route('api-tokens.index') }}">{{ __('API Tokens') }}</a></li>
                    @endif

                    <li>
                        <!-- Teams Dropdown -->
                        {{-- @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <li><a class="dropdown-item" href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">{{ __('Team Settings') }}</a></li>
                    @endif --}}
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <!-- Logout -->
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item" type="submit" style="color: var(--color-text);">{{ __('Esci') }}</button>
                        </form>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</nav>
