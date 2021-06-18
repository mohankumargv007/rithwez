@extends('layouts.app')

@section('content')
<div class="container">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" align="center"><b>Your {{$UserLoans['loan_type']}} {{ __('EMI History') }}</b></div>

                <div class="card-body">
                    <div class="row justify-content-center" style="margin-top: 1%">
                        <div class="col-lg-2 col-md-2"><b>Loan Amount</b></div>
                        <div class="col-lg-2 col-md-2">: Rs.{{$UserLoans['loan_amount']}}</div>
                    </div>
                    <div class="row justify-content-center" style="margin-top: 3%">
                        <div class="col-lg-2 col-md-2"><b>Interest Rate</b></div>
                        <div class="col-lg-2 col-md-2">: {{$UserLoans['interest_rate']}} %</div>
                    </div>
                    <div class="row justify-content-center" style="margin-top: 3%">
                        <div class="col-lg-2 col-md-2"><b>Weekly EMI</b></div>
                        <div class="col-lg-2 col-md-2">: {{$UserLoans['weekly_pay']}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center" style="margin-top: 5%">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><b>Your {{$UserLoans['loan_type']}} {{ __('EMI History') }}</b></div>

                <div class="card-body">
                    @if(true)
                        <div class="row" align="center" style="margin-top: 2%">
                            <div class="col-lg-3 col-md-3">
                                <b>Week</b>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <b>EMI Amount</b>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <b>Status</b>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <b>Action</b>
                            </div>
                        </div>
                        @foreach($finalRresult as $key => $emi)
                            <div class="row" align="center" style="margin-top: 2%">
                                <div class="col-lg-3 col-md-3">
                                    {{$emi['week']}}
                                </div>
                                <div class="col-lg-3 col-md-3">
                                    {{$emi['amount_to_be_paid']}}
                                </div>
                                <div class="col-lg-3 col-md-3">
                                    {{$emi['is_paid'] == 1 ? 'Paid' : 'Has To Pay'}}
                                </div>
                                <div class="col-lg-3 col-md-3">
                                    @if($emi['is_paid'])
                                        <button class="btn btn-md btn-success">
                                            Paid
                                        </button>
                                    @elseif($emi['is_repay'])
                                        <button class="btn btn-md btn-danger" style="color: white" onclick="payEmi({{$emi['week']}}, {{$emi['loan_id']}});">
                                            Repay        
                                        </button> 
                                    @else
                                        @if($key == 1)
                                            <button class="btn btn-md btn-primary" style="color: white" onclick="payEmi({{$emi['week']}}, {{$emi['loan_id']}});">
                                                Pay        
                                            </button>
                                        @else
                                            <button class="btn btn-md btn-primary" disabled="disabled">
                                                Pay        
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        {{ __('You didnt apply any loan') }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('BasicJs')
<script type="text/javascript">
    function payEmi(week, loan_id) {
        $(document).find('.divLoading').removeClass('hidden');

        var payload = {
            'week'         : week,
            'loan_id'      : loan_id
        }

        $.ajax({
                    url: api_url+"/loans/pay",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data:  payload,
                    success: function(result){
                        if(result.status) {
                            alert('Loan paid successfully.');
                            location.reload();
                        } else {
                            alert('Paying loan failed.Please try again after sometime')
                        }
                    }
                })
    }
</script>
@endsection