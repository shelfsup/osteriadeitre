@assets
    <style>
        .bi-list::before {
            content: "\f479";
            font-size: 2.5rem;
            color: var(--color-text) !important;
        }
    </style>
@endassets

<nav class="nopcshow">
    <div class="d-flex justify-content-between align-items-center mt-1 mx-2 p-1">
        <button class="" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions" style="border:none; background-color: rgba(255, 255, 255, 0);"><i class="bi bi-list"></i></button>

        <div class="d-flex">
            @livewire('toggle.dark-mode')
        </div>

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
                    <hr class="dropdown-divider">
                </li>

                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
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

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                @endif
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

    <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel" style="background-image: var(--bg-sidebar) ; border-top-right-radius:20px; border-bottom-right-radius:20px; box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;">
        <div class="offcanvas-header d-flex align-items-center">
            <div class="d-flex justify-content-center align-items-center me-1" style="width: 1.5rem">
                <div class="logo-sidebar" style="background-image: var(--logo-sidebar);" aria-label="Logo"></div>
            </div>
            <h5 class=" offcanvas-title fw-bold " style="text-wrap: nowrap;color: var(--color-text) !important;">
                {{ env('APP_RISTORANTE') }} Menu
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close" style="color: var(--color-text) !important;"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="p-0" style="list-style: none; ">
                <li class="py-2 px-2 sidebar-link">
                    <a class="fs-5 my-3 me-5 sidebar-link" href="{{ route('dashboard') }}"><i class="bi bi-graph-up-arrow me-2"></i>Dashboard</a>
                </li>
                <hr class="m-0">
                <div class="accordion accordion-flush" id="accordionFlushExample2">
                    <div class="accordion-item" style="border-radius: 0 !important; background-color: rgba(255, 255, 255, 0) !important;">
                        <h2 class="accordion-header" style="border-radius: 0 !important; background-color: rgba(255, 255, 255, 0) !important;">
                            <button class="accordion-button collapsed sidebar-link fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne2" aria-expanded="false" aria-controls="flush-collapseOne" style="padding: 10px 6px 0 6px !important; border-radius: 0 !important; background-color: rgba(255, 255, 255, 0) !important;text-wrap: nowrap !important; opacity: 1 !important;">
                                <i class="bi bi-file-text me-2"></i>Gestisci il menù
                            </button>
                        </h2>
                        <div id="flush-collapseOne2" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample2" style="border-radius: 0 !important; background-color: rgba(255, 255, 255, 0) !important; ">
                            <div class="accordion-body px-0" style="border: none !important; border-radius: 0 !important; background-color: rgba(255, 255, 255, 0) !important;padding: 0 !important;">
                                <ul class="p-0" style="list-style: none; border: none !Important;">
                                    <li class="py-2 px-2 sidebar-link">
                                        <a class="fs-6 my-1 me-5 sidebar-link" href="{{ route('Il Mio Menù') }}"><i class="bi bi-file-text me-2"></i>Il Mio Menù</a>
                                    </li>
                                    <li class="py-2 px-2 sidebar-link">
                                        <a class="fs-6 my-1 me-5 sidebar-link" href="{{ route('Gli Special') }}"><i class="bi bi-star me-2"></i>Gli Special</a>
                                    </li>
                                    {{-- <li class="py-2 px-2 sidebar-link">
                                        <a class="fs-6 my-1 me-5 sidebar-link" href="{{ route('Le Promozioni') }}"><i class="bi bi-piggy-bank me-2"></i>Promozioni</a>
                                    </li> --}}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="m-0">



            </ul>
        </div>
    </div>
</nav>
