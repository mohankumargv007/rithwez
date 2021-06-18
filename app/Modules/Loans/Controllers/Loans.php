<?php

namespace App\Modules\Loans\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

use Auth;
use View;
use Session;
use Config;
use Response;

use App\Modules\Loans\Models\UserLoans as UserLoans;
use App\Modules\Loans\Models\UserLoanEmi as UserLoanEmi;

class Loans extends Controller
{

	public static function ShowLoansTemplate(Request $request) {
		$UserLoans = UserLoans::get();
		return view('Loans::ViewLoansList', ['UserLoans' => $UserLoans]);
	}

	public static function ApplyLoanTemplate(Request $request) {
		$UserLoans = UserLoans::get();
		return view('Loans::ApplyLoan', 
						[
							'loansInfo' 		=> Config::get('constants.loans'),
							'interestInfo' 		=> Config::get('constants.interests'),
							'emis'				=> Config::get('constants.emi'),
							'UserLoans' 		=> $UserLoans
						]
					);
	}

	public static function ViewLoanDetails($id) {
		$UserLoans = UserLoans::where('id', '=', $id)->get();
		if(!count($UserLoans)) {
			return redirect('/loans/apply');
		}
		$UserLoans = $UserLoans[0];

		$UserLoanEmis = UserLoanEmi::where('loan_id', '=', $id)->get();

		$finalRresult = [];

		$loanEmiPlan = $UserLoans['emi_plan'];

		for ($i=1; $i <= $loanEmiPlan; $i++) { 
			$finalRresult[$i] = [
				'loan_id'			=> $UserLoans['id'],
				'week' 				=> $i,
				'week_name' 		=> 'week '.$i,
				'amount_to_be_paid' => $UserLoans['weekly_pay'],
				'is_paid'			=> $i > count($UserLoanEmis) ? 0 : 1,
				'is_repay'			=> 0
			];	
		}

		for ($i=1; $i <= $loanEmiPlan; $i++) { 
			if($i < $loanEmiPlan) {
				$finalRresult[$i+1]['is_repay'] = $finalRresult[$i]['is_paid'] == 1 ? 1 : 0;
			}
		}

		return view('Loans::ViewLoanDetails', ['UserLoans' => $UserLoans, 'finalRresult' => $finalRresult]);
	}

	public static function ApplyLoan(Request $request) {
		$inputs = $request->all();
		$user_loans = UserLoans::insert([
									'user_id' 		=> Auth::user()->id,
									'loan_type' 	=> $inputs['loan_type'],
									'interest_rate' => $inputs['intererest_rate'],
									'loan_amount'	=> $inputs['loan_amount'],
									'emi_plan'		=> $inputs['emi_plan'],
									'weekly_pay'	=> $inputs['weekly_pay']
								]);
		if($user_loans){
            return Response::json(array('status' => true));
        }else{
            return Response::json(array('status' => false));
        }
	}

	public static function ApproveLoan(Request $request) {
		$inputs = $request->all();
		$update = UserLoans::where('id', '=', $inputs ['loan_id'])
							->update([
								'approved_by' 	=> Auth::user()->id,
								'status'		=> 'Approved'	
							]);
		if($update){
            return Response::json(array('status' => true));
        }else{
            return Response::json(array('status' => false));
        }			
	}

	public static function PayLoan(Request $request) {
		$inputs = $request->all();
		$update = UserLoanEmi::insert([
								'emi_week' 	=> $inputs['week'],
								'user_id'	=> Auth::user()->id,
								'loan_id'	=> $inputs['loan_id'],
								'status'	=> 1,
							]);


		if($update){
            return Response::json(array('status' => true));
        }else{
            return Response::json(array('status' => false));
        }
	}
}