@props(['team', 'component' => 'dropdown-link'])

<form method="POST" action="{{ route('current-team.update') }}" x-data style="height: fit-content;">
    @method('PUT')
    @csrf

    <!-- Hidden Team ID -->
    <input type="hidden" name="team_id" value="{{ $team->id }}">

    <x-dynamic-component :component="$component" href="#" x-on:click.prevent="$root.submit();">
        <div class="d-flex align-items-center gap-2 px-2" style="height: fit-content !important;">
            @if (Auth::user()->isCurrentTeam($team))
            <svg class="ms-2 h-5 w-5 text-success" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="height: 1.25rem; width: 1.25rem; margin-inline-start: 0.5rem;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            @endif

            <div class="truncate"><p class="m-0 fw-semibold fs-6">{{ $team->name }}</p></div>
        </div>
    </x-dynamic-component>
</form>
