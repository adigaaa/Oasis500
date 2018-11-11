<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalculateTaxRequest;
use Illuminate\Http\Request;
use Validator;

class TaxController extends Controller
{
    public function index()
    {
    	return view('tax');
    }

    public function calculate(CalculateTaxRequest $request)
    {
        $data = $request->only(
            'total_income',
            'resident',
            'married',
            'tot_spo_income',
            'spo_resident'
        );

        $total = $data['total_income'];
        $exemption = $this->getExemption();

        if ($data['married']) {

            $total += $data['tot_spo_income'];

            if ($data['spo_resident']) {
                $total -= $exemption;
            }
        }

        if ($data['resident']) {
            $total -= $exemption;
        }

        $result = 0;

        if ($total > 0) {
            $result = $this->calculateTax($total);
        }
		
    	return response()->json([
            'data' => [
                'result' => $result,
            ],
		]);
    }

    public function calculateTax($total)
    {
        $tax1 = 0.1;
        $tax2 = 0.2;
        if ($total < 10000) {
            return $total * $tax1;
        }
        $total_tax = 10000 * $tax1;
        $total -= 10000;
        $total_tax += $total * $tax2;

        return $total_tax;
    }

    public function getExemption()
    {
        return 9000;
    }
}
