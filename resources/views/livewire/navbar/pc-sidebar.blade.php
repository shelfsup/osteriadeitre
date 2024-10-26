<sidebar class=" mx-2 py-5 px-2" style="display: block; height: 95% !important; width:100%; background-image: var(--bg-sidebar) ; border-radius:20px; box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;">
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    {{-- <div style="position: absolute; top: 30px;">
        @livewire('toggle.dark-mode')
    </div> --}}
    <div class="d-flex flex-column" style="height: 100%;">
        <div class="d-flex flex-column align-items-center">
            <div class="logo-sidebar" style="background-image: var(--logo-sidebar);" aria-label="Logo"></div>
        </div>


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
        <div class="mt-auto" style="">
            @livewire('widget.digital-clock')
        </div>

    </div>

</sidebar>
