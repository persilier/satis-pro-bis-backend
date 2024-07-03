<?php

namespace Satis2020\ClientFromAnyInstitution\Http\Controllers\Accounts;

use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Satis2020\ServicePackage\Exceptions\CustomException;
use Satis2020\ServicePackage\Http\Controllers\ApiController;
use Satis2020\ServicePackage\Models\ClientInstitution;
use Satis2020\ServicePackage\Models\Account;
use Illuminate\Http\Request;
use Satis2020\ServicePackage\Services\ActivityLog\ActivityLogService;
use Satis2020\ServicePackage\Traits\ClientTrait;

/**
 * Class AccountClientController
 * @package Satis2020\ClientFromAnyInstitution\Http\Controllers\Accounts
 */
class AccountClientController extends ApiController
{
    use ClientTrait;

    protected $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        parent::__construct();

        $this->middleware('auth:api');

        $this->middleware('permission:store-client-from-any-institution')->only(['store']);

        $this->activityLogService = $activityLogService;
    }

    /**
     * Store a newly created resource in storage
     * @param Request $request
     * @param $clientId
     * @return JsonResponse
     * @throws ValidationException
     * @throws CustomException
     */
    public function store(Request $request, $clientId)
    {
        $this->validate($request, $this->rulesAccount(true));

        $clientInstitution = ClientInstitution::where('institution_id', $request->institution_id)->where('client_id', $clientId)->firstOrFail();

        // Account Number Verification
        $verifyAccount = $this->handleAccountClient($request->number);

        if (!$verifyAccount['status']) {

            throw new CustomException($verifyAccount, 409);
        }


        $account = $this->storeAccount($request, $clientInstitution->id);

        return response()->json($account, 201);
    }

}