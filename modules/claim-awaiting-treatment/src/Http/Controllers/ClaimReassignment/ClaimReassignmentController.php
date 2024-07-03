<?php

namespace Satis2020\ClaimAwaitingTreatment\Http\Controllers\ClaimReassignment;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Satis2020\ServicePackage\Exceptions\CustomException;
use Satis2020\ServicePackage\Exceptions\RetrieveDataUserNatureException;
use Satis2020\ServicePackage\Http\Controllers\ApiController;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Satis2020\ServicePackage\Models\Staff;
use Satis2020\ServicePackage\Services\ActivityLog\ActivityLogService;
use Satis2020\ServicePackage\Traits\ClaimAwaitingTreatment;
use Satis2020\ServicePackage\Traits\SeveralTreatment;

/**
 * Class ClaimReassignmentController
 * @package Satis2020\ClaimAwaitingTreatment\Http\Controllers\ClaimReassignment
 */
class ClaimReassignmentController extends ApiController
{
    use ClaimAwaitingTreatment, SeveralTreatment;

    protected $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        parent::__construct();

        $this->middleware('auth:api');
        $this->middleware('permission:assignment-claim-awaiting-treatment')->except(['store', 'destroy']);
        $this->activityLogService = $activityLogService;
    }


    /**
     * @return JsonResponse
     */
    protected function index(){

        $this->checkLeadReassignment();
        return response()->json($this->queryClaimReassignment()->sortable()->get(), 200);
    }


    /**
     * @param $claim
     * @return JsonResponse
     */
    protected function show($claim){

        $this->checkLeadReassignment();
        return response()->json($this->queryClaimReassignment()->find($claim), 200);
    }


    /**
     * @param $claim
     * @return JsonResponse
     */
    protected function edit($claim){

        $staff = $this->staff();
        $this->checkLeadReassignment();
        $claimToReassign = $this->queryClaimReassignment()->find($claim);
        $staffs = $claimToReassign->activeTreatment->responsible_staff_id!=null?
            $this->getTargetedStaffFromUnit($staff->unit_id,true,$claimToReassign->activeTreatment->responsible_staff_id):$this->getTargetedStaffFromUnit($staff->unit_id);
        return response()->json([
            'claim' => $claimToReassign,
            'staffs' => $staffs,
        ], 200);
    }


    /**
     * @param Request $request
     * @param $claim
     * @return JsonResponse
     * @throws CustomException
     * @throws RetrieveDataUserNatureException
     * @throws ValidationException
     */
    protected function update(Request $request, $claim){

        $this->checkLeadReassignment();
        $claim = $this->queryClaimReassignment()->find($claim);
        $this->validate($request, $this->rules($this->staff()));
        $claim->activeTreatment->update([
            'responsible_staff_id' => $request->staff_id,
        ]);

        $this->activityLogService->store("Une réclamation a été réaffecté à un autre staff",
            $this->institution()->id,
            $this->activityLogService::REASSIGNMENT_CLAIM,
            'claim',
            $this->user(),
            $claim
        );

        return response()->json($claim, 201);
    }


}
