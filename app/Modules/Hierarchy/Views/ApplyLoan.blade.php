@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12" align="center">
            <div class="card">
                <div class="card-header"><b>{{Auth()->user()->first_name}} {{Auth()->user()->last_name}}'s {{ __(' Dashboard') }}</b></div>

                <div class="card-body">
                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center" style="margin-top: 5%">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><b>{{ __('Apply Loan Here') }}</b></div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-md-3">
                            <label>Select Loan Type : </label>
                            <select class="form-control loanType" id="loanType">
                                <option value="">-- Select --</option>
                                @foreach($loansInfo as $key => $loan)
                                    <option value="{{$loan['NAME']}}">{{$loan['NAME']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-3">
                            <label>Interest Rate(%) : </label>
                            <input type="text" class="intererest_rate form-control" name="intererest_rate" id="intererest_rate" readonly/>
                        </div>
                        <div class="col-lg-3 col-md-3">
                            <label>Enter Required Loan Amount : </label>
                            <input type="number" class="loan_amount form-control" name="loan_amount" id="loan_amount" min="1000" value="1000" />
                        </div>
                        <div class="col-lg-3 col-md-3">
                            <label>Select EMI Plan (in weekly) : </label>
                            <select class="form-control emiPlan" id="emiPlan">
                                <option value="">-- Select --</option>
                                @foreach($emis as $key => $emi)
                                    <option value="{{$emi}}">{{$emi}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="EmiInfo hidden">
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <div class="row justify-content-center" style="margin-top: 5%">
                            <div class="col-lg-3">Loan Type</div>
                            <div class="col-lg-4">: <span class="emiInfoLoanType emiInfoVal"></span></div>
                        </div>
                        <div class="row justify-content-center" style="margin-top: 5%">
                            <div class="col-lg-3">Loan Amount</div>
                            <div class="col-lg-4">: <span class="emiInfoLoanAmount emiInfoVal"></span></div>
                        </div>
                        <div class="row justify-content-center" style="margin-top: 5%">
                            <div class="col-lg-3">Interest Rate</div>
                            <div class="col-lg-4">: <span class="emiInfoInterestRate emiInfoVal"></span></div>
                        </div>
                        <div class="row justify-content-center" style="margin-top: 5%">
                            <div class="col-lg-3">EMI Plan (In Weekly)</div>
                            <div class="col-lg-4">: <span class="emiInfoEmiPlan emiInfoVal"></span></div>
                        </div>
                        <div class="row justify-content-center" style="margin-top: 5%">
                            <div class="col-lg-3">Weekly EMI payable</div>
                            <div class="col-lg-4">: Rs.<span class="emiInfoWeeklyEmi emiInfoVal"></span> /-</div>
                        </div>
                        <div class="row justify-content-center" style="margin-top: 5%">
                            <button class="btn btn-md btn-primary apply" id="apply">Apply</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div class="row justify-content-center" style="margin-top: 5%">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><b>{{ __('Your Loan History') }}</b></div>

                    <div class="card-body">
                        @if(count($UserLoans))
                            <div class="row" align="center" style="margin-top: 2%">
                                <div class="col-lg-2 col-md-2">
                                    <b>Loan Type</b>
                                </div>
                                <div class="col-lg-2 col-md-2">
                                    <b>Amount</b>
                                </div>
                                <div class="col-lg-2 col-md-2">
                                    <b>Interest Rate (%)</b>
                                </div>
                                <div class="col-lg-2 col-md-2">
                                    <b>Status</b>
                                </div>
                                <div class="col-lg-2 col-md-2">
                                    <b>EMI</b>
                                </div>
                                <div class="col-lg-2 col-md-2">
                                    <b>Action</b>
                                </div>
                            </div>
                            @foreach($UserLoans as $loan)
                                <div class="row" align="center" style="margin-top: 2%">
                                    <div class="col-lg-2 col-md-2">
                                        {{$loan['loan_type']}}
                                    </div>
                                    <div class="col-lg-2 col-md-2">
                                        {{$loan['loan_amount']}}
                                    </div>
                                    <div class="col-lg-2 col-md-2">
                                        {{$loan['interest_rate']}}
                                    </div>
                                    <div class="col-lg-2 col-md-2">
                                        {{$loan['status']}}
                                    </div>
                                    <div class="col-lg-2 col-md-2">
                                        {{$loan['emi_plan']}}
                                    </div>
                                    <div class="col-lg-2 col-md-2">
                                        @if($loan['status'] != 'In-Progress')
                                            <button class="btn btn-md btn-success">
                                                <a href="/loans/view/{{$loan['id']}}" style="color: white">
                                                    View        
                                                </a>
                                            </button>
                                        @else
                                            <button class="btn btn-md btn-primary" style="color: white" disabled="disabled">
                                                View        
                                            </button> 
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
    $(document).ready(function () {
        var intererest_rates = {!! json_encode($interestInfo) !!};

        //Calculate Weekly EMI 
        function calculateWeeklyEmiAmt() {
            $(document).find('.divLoading').removeClass('hidden');

            $('.emiInfoLoanType').empty("");
            $('.emiInfoLoanAmount').empty("");
            $('.emiInfoInterestRate').empty("");
            $('.emiInfoEmiPlan').empty("");
            $('.emiInfoWeeklyEmi').empty("");

            //Appending Values
            $('.emiInfoLoanType').append($('#loanType').val());
            $('.emiInfoLoanAmount').append($('#loan_amount').val());
            $('.emiInfoInterestRate').append($('#intererest_rate').val());
            $('.emiInfoEmiPlan').append($('#emiPlan').val());

            var EmiWeeklyAmount = ((parseInt($('#loan_amount').val())/100)*$('#intererest_rate').val()+parseInt($('#loan_amount').val()))/parseInt($('#emiPlan').val());

            $('.emiInfoWeeklyEmi').append(Math.round(EmiWeeklyAmount));            

            setTimeout(function() {
                $('.EmiInfo').removeClass('hidden');
                $(document).find('.divLoading').addClass('hidden');
            }, 2000);
        }

        //Getting Interest Rates Based On Loan Type
        $(document).on("change", "#loanType", function() {
            if(!$(this).val()) {
                $('.EmiInfo').addClass('hidden');
                alert('Please select loan type');
                $('#intererest_rate').val("");
                return false;
            }
            var cur_val_interest = intererest_rates[$(this).val()]['INTEREST_RATE'];
            $('#intererest_rate').val(cur_val_interest);

            if($('#emiPlan').val()) {
                calculateWeeklyEmiAmt();
            }
        });

        //Calculation Total Amount After The EMI Plan
        $(document).on("change", "#emiPlan", function() {
            if(!$('#loanType').val()) {
                $('.EmiInfo').addClass('hidden');
                alert('Please select loan type first');
                $(this).val("");
                return false;
            }
            if(!$(this).val()) {
                alert('Please select emi plan');
                return false;
            }
            calculateWeeklyEmiAmt();
        });

        $(document).on("keyup", "#loan_amount", function () {
            if(!$('#loanType').val() || !$('#emiPlan').val()) {
                $('.EmiInfo').addClass('hidden');
                return false;
            }
            calculateWeeklyEmiAmt();
        });

        $(document).on("click", ".apply", function () {
            $(document).find('.divLoading').removeClass('hidden');

            var payload = {
                'loan_type'         : $('.emiInfoLoanType').text(),
                'intererest_rate'   : $('.emiInfoInterestRate').text(),
                'loan_amount'       : $('.emiInfoLoanAmount').text(),
                'emi_plan'          : $('.emiInfoEmiPlan').text(),
                'weekly_pay'        : $('.emiInfoWeeklyEmi').text()
            }

            $.ajax({
                        url: api_url+"/loans/apply",
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data:  payload,
                        success: function(result){
                            if(result.status) {
                                alert('Loan applied successfully.');
                                location.reload();
                            } else {
                                alert('Loan application failed.Please try again after sometime')
                            }
                        }
                    })
        });
    })
</script>
@endsection