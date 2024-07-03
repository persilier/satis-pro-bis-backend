<?php

namespace Satis2020\ServicePackage\Models;

use App\Scopes\SortScope;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Satis2020\ServicePackage\Traits\UuidAsId;
use Satis2020\ServicePackage\Traits\SecureDelete;
use Baro\PipelineQueryCollection\Concerns\Filterable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Baro\PipelineQueryCollection\Contracts\CanFilterContract;

class Account extends Model implements CanFilterContract
{
    use HasTranslations, UuidAsId, SoftDeletes, SecureDelete, Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'number', 'account_type_id', 'client_institution_id'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    //protected $dates = ['deleted_at'];

    /**
     * The attributes that are translatable
     *
     * @var array
     */
    public $translatable = [];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    protected $hidden = ['account_number'];

    protected $appends = ['account_number'];

    /**
     * Get the client_institution associated with the Client Institution
     * @return BelongsTo
     */
    public function client_institution()
    {
        return $this->belongsTo(ClientInstitution::class);
    }

    /**
     * Get the accountType associated with the account
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function accountType()
    {
        return $this->belongsTo(AccountType::class, 'account_type_id', 'id');
    }

    /**
     * Get the claims associated with the account
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function claims()
    {
        return $this->hasMany(Claim::class, 'account_targeted_id');
    }

    public function getAccountNumberAttribute()
    {
        return $this->attributes['number'];
    }

    public function getNumberAttribute()
    {
        $len = strlen($this->attributes['number']);
        $middle = intdiv($len,3);

        return substr_replace($this->attributes['number'], $this->getAsterisks($middle), $middle,$middle);
    }

    public function getAsterisks($length)
    {
        $str = "";
        for ($i=0;$i<$length;$i++){
            $str.="*";
        }

        return $str;
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable();
    }

    
}
