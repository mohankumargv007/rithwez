<?php

namespace App\Modules\Hierarchy\Controllers;

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
use App\Modules\Hierarchy\Models\H1Model as H1Model;
use App\Modules\Hierarchy\Models\H2Model as H2Model;
use App\Modules\Hierarchy\Models\H3Model as H3Model;
use App\Modules\Hierarchy\Models\H4Model as H4Model;

class Hierarchy extends Controller
{

	public static function add(Request $request) {
		//$UserLoans = UserLoans::get();
		$UserLoans = [];
		return view('Loans::ViewLoansList', ['UserLoans' => $UserLoans]);
	}

	public static function ApplyLoanTemplate(Request $request) {
		$UserLoans = UserLoans::get();
		return view('Loans::ApplyLoan', 
						[
							'loansInfo' 		=> Config::get('constants.loans'),
							'interestInfo' 		=> Config::get('constants.interests'),
							'emis'				=> Config::get('constants.emi'),
							'UserLoans' 		=> []
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

	public static function h1(Request $request) {
		$H1List = H1Model::get();
		return view('Hierarchy::H1',
		[
			'loansInfo' 		=> Config::get('constants.loans'),
			'interestInfo' 		=> Config::get('constants.interests'),
			'emis'				=> Config::get('constants.emi'),
			'H1List' 			=> $H1List
		]
		);
	}

	public static function h2(Request $request) {
		$H1List = H1Model::get();
		$H2List = H2Model::get();
		return view('Hierarchy::H2',
		[
			'loansInfo' 		=> Config::get('constants.loans'),
			'interestInfo' 		=> Config::get('constants.interests'),
			'emis'				=> Config::get('constants.emi'),
			'H1List' 			=> $H1List,
			'H2List' 			=> $H2List
		]
		);
	}

	public static function h3(Request $request) {
		$H1List = H1Model::get();
		$H2List = H2Model::get();
		$H3List = H3Model::get();
		return view('Hierarchy::H3',
		[
			'loansInfo' 		=> Config::get('constants.loans'),
			'interestInfo' 		=> Config::get('constants.interests'),
			'emis'				=> Config::get('constants.emi'),
			'H1List' 			=> $H1List,
			'H2List' 			=> $H2List,
			'H3List' 			=> $H3List
		]
		);
	}

	public static function h4(Request $request) {
		$H1List = H1Model::get();
		$H2List = H2Model::get();
		$H3List = H3Model::get();
		$H4List = H4Model::get();
		return view('Hierarchy::H4',
		[
			'loansInfo' 		=> Config::get('constants.loans'),
			'interestInfo' 		=> Config::get('constants.interests'),
			'emis'				=> Config::get('constants.emi'),
			'H1List' 			=> $H1List,
			'H2List' 			=> $H2List,
			'H3List' 			=> $H3List,
			'H4List' 			=> $H4List
		]
		);
	}

	public static function Output(Request $request) {
		$H4List = H4Model::get();
		return view('Hierarchy::Output',
			[
				'H4List' 			=> $H4List
			]
		);
	}

	public static function addH1(Request $request) {
		$inputs = $request->all();
		$user_loans = H1Model::insert([
									'h1_name' => $inputs['h1_name'],
									'created_at' => date('Y-m-d H:i:s'),
									'updated_at' => date('Y-m-d H:i:s')
								]);
		if($user_loans){
            return Response::json(array('status' => true));
        }else{
            return Response::json(array('status' => false));
        }
	}

	public static function addH2(Request $request) {
		$inputs = $request->all();
		$user_loans = H2Model::insert([
									'h1_id' => $inputs['h1_name'],
									'h2_name' => $inputs['h2_name'],
									'created_at' => date('Y-m-d H:i:s'),
									'updated_at' => date('Y-m-d H:i:s')
								]);
		if($user_loans){
            return Response::json(array('status' => true));
        }else{
            return Response::json(array('status' => false));
        }
	}

	public static function addH3(Request $request) {
		$inputs = $request->all();
		$user_loans = H3Model::insert([
									'h2_id' => $inputs['h2_name'],
									'h3_name' => $inputs['h3_name'],
									'created_at' => date('Y-m-d H:i:s'),
									'updated_at' => date('Y-m-d H:i:s')
								]);
		if($user_loans){
            return Response::json(array('status' => true));
        }else{
            return Response::json(array('status' => false));
        }
	}

	public static function addH4(Request $request) {
		$inputs = $request->all();
		$user_loans = H4Model::insert([
									'h3_id' => $inputs['h3_name'],
									'h4_name' => $inputs['h4_name'],
									'wall_type' => $inputs['wall_type'],
									'no_of_stories' => $inputs['no_of_stories'],
									'roof_type' => $inputs['roof_type'],
									'created_at' => date('Y-m-d H:i:s'),
									'updated_at' => date('Y-m-d H:i:s')
								]);
		if($user_loans){
            return Response::json(array('status' => true));
        }else{
            return Response::json(array('status' => false));
        }
	}
}