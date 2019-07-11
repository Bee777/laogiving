<?php

namespace App;

use App\Http\Controllers\Helpers\Helpers;
use App\Models\OrganizeProfile;
use App\Models\Role;
use App\Models\UserType;
use App\Models\VolunteeringActivity;
use App\Models\VolunteerProfile;
use App\Traits\UserRoleTrait;
use App\Traits\PersonalAccessTokenTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;
use Laravel\Passport\Passport;
use \Illuminate\Database\Eloquent\Relations\HasMany,
    \Illuminate\Database\Eloquent\Relations\BelongsToMany,
    \Illuminate\Database\Eloquent\Relations\HasOne;
use App\Notifications\UserResetPasswordNotification;
use phpDocumentor\Reflection\Types\Self_;


class User extends Authenticatable
{
    use PersonalAccessTokenTrait, HasApiTokens, Notifiable, UserRoleTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'receive_news', 'email', 'status', 'image', 'password',
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

    public $userInfo = ['imagePath' => '/assets/images/user_profiles/', 'preThumb' => '96x96-'];
    protected static $defaultStatus = ['pending', 'approved', 'disabled'];

    public function isUser(string $title)
    {
        $check_type_user_id = $this->getTypeUserId($title);
        return $this->userType->type_user_id === $check_type_user_id;
    }

    /**
     * @StartActions
     */

    public function hasActions($name): bool
    {
        //the value of an array means user type id
        $actions = [

        ];
        return (isset($actions[$name]) && in_array($this->userType->type_user_id, $actions[$name], true));
    }

    /**
     * @todo delete user all related user information
     * @return bool
     */
    public function destroyInfo(): bool
    {
        if ($this->image === 'logo.png') {
            return true;
        }
        $deleted = Helpers::removeFile($this->userInfo['imagePath'] . $this->userInfo['preThumb'] . $this->image);
        return $deleted && Helpers::removeFile($this->userInfo['imagePath'] . $this->image);
    }

    /**
     * @todo change user status
     * @param $status
     * @return bool
     */
    public function setStatus($status): bool
    {
        if ($this->status !== $status && in_array($status, self::$defaultStatus, true)) {
            $this->status = $status;
            $this->save();
            //check if status changed to disabled and sign user out
            if ($status === 'disabled') {
                $this->revokeAllValidTokens();
            }
            //end check if status changed to disabled and sign user out
            return true;
        }
        return false;
    }

    /**
     * @EndActions
     */

    /**
     * @Model relationship
     */

    /**@Department */

    /**@Relationship */
    public function userProfile($type)
    {
        $func = $type . 'Profile';
        return $this->$func;
    }

    public function saveUserProfile($type, $profile): void
    {
        $func = $type . 'Profile';
        $this->$func()->save($profile);
    }

    public function volunteerProfile()
    {
        return $this->hasOne(VolunteerProfile::class);
    }

    public function organizeProfile()
    {
        return $this->hasOne(OrganizeProfile::class);
    }

    public function volunteerings()
    {
        return $this->hasMany(VolunteeringActivity::class);
    }


    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function userType(): HasOne
    {
        return $this->hasOne(UserType::class);
    }
    //ony web guard
    public function getTypeOfUserAttribute()
    {
        $user = self::find(Auth::user()->id)->userType;
        if (isset($user)) {
            return $user->typeUser;
        }
        return null;
    }

    public function hasRole($role)
    {
        return $this->roles->pluck('name')->contains($role);
    }

    /**@Relationship */

    public function getTokenName()
    {
        return config('app.name', 'Laravel') . '_trusted_token';
    }

    public function getPersonalTokenExpiresDaysInSeconds(): int
    {
        return Helpers::days_to_seconds(config('auth.days_tokens_expire_in'));
    }

    public function transformUser(): array
    {
        $type = $this->userType->typeUser->name;
        return [
            'id' => $this->id,
            'name' => $this->name,
            'thumb_image' => $this->userInfo['imagePath'] . $this->userInfo['preThumb'] . $this->image,
            'image' => $this->userInfo['imagePath'] . $this->image,
            'email' => $this->email,
            'type' => base64_encode($type),
            'profile' => $this->userProfile($type),
        ];
    }

    public function revokeAllValidTokens()
    {
        $validTokens = Passport::$tokenModel::where('user_id', $this->id)
            ->where('client_id', 1)->where('revoked', 0)
            ->update(['revoked' => 1]);

        return $validTokens;
    }

    /**
     * Send mail to the user who request to forgot password
     * @param string $token
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new UserResetPasswordNotification($token));
    }

}
