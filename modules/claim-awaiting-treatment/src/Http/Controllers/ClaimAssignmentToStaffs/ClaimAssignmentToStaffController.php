<?php

namespace Satis2020\ClaimAwaitingTreatment\Http\Controllers\ClaimAssignmentToStaffs;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Validation\Rules\RequiredIf;
use Illuminate\Validation\ValidationException;
use Satis2020\ServicePackage\Exceptions\CustomException;
use Satis2020\ServicePackage\Exceptions\RetrieveDataUserNatureException;
use Satis2020\ServicePackage\Http\Controllers\ApiController;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Satis2020\ServicePackage\Models\Claim;
use Satis2020\ServicePackage\Models\Metadata;
use Satis2020\ServicePackage\Models\Staff;
use Satis2020\ServicePackage\Notifications\TreatAClaim;
use Satis2020\ServicePackage\Services\ActivityLog\ActivityLogService;
use Satis2020\ServicePackage\Traits\ClaimAwaitingTreatment;
use Satis2020\ServicePackage\Traits\Notification;

/**
 * Class ClaimAssignmentToStaffController
 * @package Satis2020\ClaimAwaitingTreatment\Http\Controllers\ClaimAssignmentToStaffs
 */
class ClaimAssignmentToStaffController extends ApiController
{
    use ClaimAwaitingTreatment;

    protected $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        parent::__construct();

        $this->middleware('auth:api');

        $this->middleware('permission:list-claim-assignment-to-staff')->only(['index']);
        $this->middleware('permission:show-claim-assignment-to-staff')->only(['show', 'treatmentClaim', 'unfoundedClaim']);

        $this->activityLogService = $activityLogService;
    }


    /**
     * @return JsonResponse
     * @throws RetrieveDataUserNatureException
     */
    public function index()
    {
        $institution = $this->institution();
        $staff = $this->staff();

        $claims = $this->getClaimsTreat($institution->id, $staff->unit_id, $staff->id)->sortable()->get()->map(function ($item, $key) {
            $item = Claim::with($this->getRelationsAwitingTreatment())->find($item->id);
            $item->activeTreatment->load(['responsibleUnit', 'assignedToStaffBy.identite', 'responsibleStaff.identite']);
            $item->isInvalidTreatment = (!is_null($item->activeTreatment->invalidated_reason) && !is_null($item->activeTreatment->validated_at)) ? TRUE : FALSE;
            return $item;
        });
        return response()->json($claims, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Claim $claim
     * @return JsonResponse
     * @throws RetrieveDataUserNatureException
     * @throws CustomException
     */
    public function show($claim)
    {
        $institution = $this->institution();
        $staff = $this->staff();

        $claim = $this->getOneClaimQueryTreat($institution->id, $staff->unit_id, $staff->id, $claim);
        $claim->isInvalidTreatment = (!is_null($claim->activeTreatment->invalidated_reason) && !is_null($claim->activeTreatment->validated_at)) ? TRUE : FALSE;
        return response()->json($claim, 200);
    }


    /**
     * @param Request $request
     * @param $claim
     * @return JsonResponse
     * @throws CustomException
     * @throws RetrieveDataUserNatureException
     * @throws ValidationException
     */
    protected function treatmentClaim(Request $request, $claim)
    {

        $institution = $this->institution();

        $staff = $this->staff();

        $claim = $this->getOneClaimQueryTreat($institution->id, $staff->unit_id, $staff->id, $claim);

        $rules = [
            'amount_returned' => [
                'nullable',
                'filled',
                'integer',
                Rule::requiredIf(!is_null($claim->amount_disputed) && !is_null($claim->amount_currency_slug)),
                'min:0'
            ],
            'solution' => ['required', 'string'],
            'comments' => ['nullable', 'string'],
            'preventive_measures' => ['string',
                Rule::requiredIf(!is_null(Metadata::where('name', 'measure-preventive')->firstOrFail()->data)
                && Metadata::where('name', 'measure-preventive')->firstOrFail()->data == 'true')
            ]
        ];

        $this->validate($request, $rules);

        $claim->activeTreatment->update([
            'amount_returned' => $request->amount_returned,
            'solution' => $request->solution,
            'comments' => $request->comments,
            'preventive_measures' => $request->preventive_measures,
            'solved_at' => Carbon::now(),
            'unfounded_reason' => NULL
        ]);

        $claim->update(['status' => 'treated']);

        $this->activityLogService->store("Traitement d'une réclamation",
            $this->institution()->id,
            $this->activityLogService::TREATMENT_CLAIM,
            'claim',
            $this->user(),
            $claim
        );

        if(!is_null($this->getInstitutionPilot($institution))){
            $this->getInstitutionPilot($institution)->notify(new TreatAClaim($claim));
        }

        return response()->json($claim, 200);

    }


    /**
     * @param Request $request
     * @param $claim
     * @return JsonResponse
     * @throws CustomException
     * @throws RetrieveDataUserNatureException
     * @throws ValidationException
     */
    protected function unfoundedClaim(Request $request, $claim)
    {

        $institution = $this->institution();
        $staff = $this->staff();

        $this->validate($request, $this->rules($staff, 'unfounded'));

        $claim = $this->getOneClaimQueryTreat($institution->id, $staff->unit_id, $staff->id, $claim);

        $claim->activeTreatment->update([
            'unfounded_reason' => $request->unfounded_reason,
            'declared_unfounded_at' => Carbon::now(),
            'amount_returned' => NULL,
            'solution' => NULL,
            'comments' => NULL,
            'preventive_measures' => NULL,
        ]);

        $claim->update(['status' => 'treated']);

        $this->activityLogService->store("Une réclamation a été déclarée non fondée",
            $this->institution()->id,
            $this->activityLogService::UNFOUNDED_CLAIM,
            'claim',
            $this->user(),
            $claim
        );

        if(!is_null($this->getInstitutionPilot($institution))){
            $this->getInstitutionPilot($institution)->notify(new TreatAClaim($claim));
        }

        return response()->json($claim, 200);

    }


}
