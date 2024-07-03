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

class Treatment extends Model implements CanFilterContract
{
    use HasTranslations, UuidAsId, SoftDeletes, SecureDelete, Filterable;

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
        'treatments' => 'array',
        'transferred_to_targeted_institution_at' => 'datetime',
        'transferred_to_unit_at' => 'datetime',
        'assigned_to_staff_at' => 'datetime',
        'declared_unfounded_at' => 'datetime',
        'solved_at' => 'datetime',
        'validated_at' => 'datetime',
        'satisfaction_measured_at' => 'datetime'
    ];

    // /**
    //  * The attributes that should be mutated to dates.
    //  *
    //  * @var array
    //  */
    // protected $dates = [
    //     'transferred_to_targeted_institution_at', 'transferred_to_unit_at', 'assigned_to_staff_at',
    //     'declared_unfounded_at', 'solved_at', 'validated_at', 'satisfaction_measured_at'
    // ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'claim_id',
        'responsible_unit_id',
        'assigned_to_staff_by',
        'responsible_staff_id',
        'unfounded_reason',
        'solution',
        'preventive_measures',
        'solution_communicated',
        'is_claimer_satisfied',
        'amount_returned',
        'unsatisfied_reason',
        'transferred_to_targeted_institution_at',
        'transferred_to_unit_at',
        'satisfaction_measured_by',
        'declared_unfounded_at',
        'solved_at',
        'validated_at',
        'satisfaction_measured_at',
        'assigned_to_staff_at',
        'rejected_at',
        'rejected_reason',
        'comments',
        'invalidated_reason',
        'number_reject',
        'treatments',
        'note'
    ];

    /**
     * Get the claim associated with the treatment
     * @return BelongsTo
     */
    public function claim()
    {
        return $this->belongsTo(Claim::class);
    }

    /**
     * Get the responsibleUnit associated with the treatment
     * @return BelongsTo
     */
    public function responsibleUnit()
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * Get the staff who assign the claim associated with the treatment
     * @return BelongsTo
     */
    public function assignedToStaffBy()
    {
        return $this->belongsTo(Staff::class, 'assigned_to_staff_by');
    }

    /**
     * Get the staff who is responsible for the treatment
     * @return BelongsTo
     */
    public function responsibleStaff()
    {
        return $this->belongsTo(Staff::class);
    }

    /**
     * @return BelongsTo
     */
    public function satisfactionMeasuredBy()
    {
        return $this->belongsTo(Staff::class, 'satisfaction_measured_by');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable();
    }

    
}
