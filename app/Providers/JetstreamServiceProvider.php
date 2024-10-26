<?php

namespace App\Providers;

use App\Actions\Jetstream\AddTeamMember;
use App\Actions\Jetstream\CreateTeam;
use App\Actions\Jetstream\DeleteTeam;
use App\Actions\Jetstream\DeleteUser;
use App\Actions\Jetstream\InviteTeamMember;
use App\Actions\Jetstream\RemoveTeamMember;
use App\Actions\Jetstream\UpdateTeamName;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;
use App\Models\Spese;
use App\Policies\SpesePolicy;
use Illuminate\Support\Facades\Gate;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configurePermissions();

        Jetstream::createTeamsUsing(CreateTeam::class);
        Jetstream::updateTeamNamesUsing(UpdateTeamName::class);
        Jetstream::addTeamMembersUsing(AddTeamMember::class);
        Jetstream::inviteTeamMembersUsing(InviteTeamMember::class);
        Jetstream::removeTeamMembersUsing(RemoveTeamMember::class);
        Jetstream::deleteTeamsUsing(DeleteTeam::class);
        Jetstream::deleteUsersUsing(DeleteUser::class);
    }

    /**
     * Configure the roles and permissions that are available within the application.
     */
    protected function configurePermissions(): void
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::role('admin', 'Amministratore', [
            'administrate',
            'update_secret_data',
            'delete_secret_data',
            'create_secret_data',
            'copy_secret_data',
            'view_secret_data',
            'create',
            'read',
            'update',
            'delete',
        ])->description('L\'amministratore puo compiere tutte le azioni comprese quelle nei secret.');

        Jetstream::role('helper', 'Aiutante', [
            'create',
            'read',
            'update',
            'delete',
        ])->description('L\'aiutante puo\' creare aggiornare ed eliminare i dati ma non può vedere i tuoi secret.');

        Jetstream::role('helperPlus', 'Gestore', [
            'create',
            'update_secret_data',
            'delete_secret_data',
            'create_secret_data',
            'copy_secret_data',
            'view_secret_data',
            'read',
            'update',
            'delete',
        ])->description('L\'aiutante puo\' creare aggiornare ed eliminare i dati e può modificare ed eliminare i tuoi secret.');

        Jetstream::role('viewer', 'Visualizzatore', [
            'read',
        ])->description('Può solo visualizzare i dati tranne i tuoi secret.');

        Jetstream::role('viewerPlus', 'Visualizzatore Avanzato', [
            'read',
            'copy_secret_data',
            'view_secret_data',
        ])->description('Può solo visualizzare i dati e può copiare i secret ma non modificarli.');

        Jetstream::role('disabled', 'Disabilitato', [
        ])->description('L\'utente non sarà in grado di visualizzare e compiere azioni.');
    }
}
