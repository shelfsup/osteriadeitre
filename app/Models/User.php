<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

        // METODI PER ROLE AND PERMISSIONS ----------------------------------------------------------------------------------------------------------//

    // METODI DI SET
    public function setAuthorization ($role = null, $mod = true)
    {
        if ($role != 'admin')
        {
            $this->authorized = $mod == true ? Auth::user()->hasTeamRole(Auth::user()->currentTeam, $role) : !Auth::user()->hasTeamRole(Auth::user()->currentTeam, $role);
        }
    }

    // Auth::user()->setTeamOwnerId();
    //     dd(Auth::user());

    public function setTeamOwnerId()
    {
        $this->teamOwnerId = Auth::user()->currentTeam->user_id;
    }

    // METODI DI GET
    public function getTeamOwnerId() : int
    {
        $this->setTeamOwnerId();
        return $this->teamOwnerId;
    }

    public function getAuthorizedVar() : bool
    {
        return $this->authorized;
    }

    public function getTeamRole()
    {
        $teamRole = DB::table('team_user')->select('role')->where('user_id', Auth::user()->id)->first();

        return $teamRole ? $teamRole->role : null;
    }

    public function getTeamObj()
    {
        return Team::find(Auth::user()->currentTeam->id);
    }

    // ---  TO DO SECTION APP ----------------------------------------------------------------------------------------------------------------------------
    public function board()
    {
        return $this->hasOne(Board::class);
    }



    // -------- SECRET MANAGER APP -----------------------------------------------------------------------------------------------------------------------
    public function managerElements()
    {
        return $this->hasMany(ManagerElement::class, 'user_id');
    }

    public function hasSecretNotification()
    {
        $hasSecretNotification = SecretNotification::where('user_id', Auth::user()->id)->exists();

        return $hasSecretNotification;
    }


}
