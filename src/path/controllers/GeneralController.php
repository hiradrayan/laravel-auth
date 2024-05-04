<?php

namespace Authentication\path\controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\Accounting\CouponService;
use App\Models\App\Coupon;
use App\Models\App\Major;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function getProvinceCities (Request $request) {
        $province_id = $request->province_id;

        $cities = \DB::table('province_cities')
            ->select(['id','title'])
            ->where('parent_id', '=', $province_id)
            ->orderBy('sort','asc')->get();

        return response()->json([
            'code'    => 1,
            'message' => 'با موفقیت انجام شد',
            'result'  => [
                'cities' => $cities
            ]
        ]);
    }
}
