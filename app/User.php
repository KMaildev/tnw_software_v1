<?php

namespace App;

use App\Models\Department;
use App\Models\MarketingTeam;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

use DarkGhostHunter\Larapass\Contracts\WebAuthnAuthenticatable;
use DarkGhostHunter\Larapass\WebAuthnAuthentication;


class User extends Authenticatable implements WebAuthnAuthenticatable
{
    use Notifiable, HasRoles, WebAuthnAuthentication;

    use LogsActivity;
    protected static $logName = 'users_log';
    protected static $logAttributes = ['name', 'email', 'employee_id', 'phone', 'nrc_number', 'address', 'department_id', 'created_at', 'updated_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'last_login_at',
        'last_login_ip',
        'agent'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function marketing_teams_table()
    {
        return $this->hasMany(MarketingTeam::class);
    }
}
