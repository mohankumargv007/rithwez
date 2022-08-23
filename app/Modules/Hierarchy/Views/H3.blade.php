@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12" align="center">
            <div class="card">
                <div class="card-header"><b>{{Auth()->user()->first_name}} {{Auth()->user()->last_name}}'s {{ __(' Dashboard') }}</b></div>

                <div class="card-body">
                {{ __('H3') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center" style="margin-top: 5%">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><b>{{ __('Occupancy Classes') }}</b></div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 col-md-4">
                            <label>Select The H2 Name : </label>
                            <select class="form-control h2_name" id="h2_name">
                                <option value="">-- Select --</option>
                                @foreach($H2List as $key => $h2)
                                    <option value="{{$h2['id']}}">{{$h2['h2_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <label>Enter The H3 Name(Ex: Adobe and Random Rubble Stone Masonry) : </label>
                            <input type="text" class="h3_name form-control" name="h3_name" id="h3_name" />
                        </div>
                        <div class="col-lg-2 col-md-2">
                            <div class="row" style="margin-top: 20%">
                                <button class="btn btn-md btn-primary apply" id="apply">Add</button>
                            </div>
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
                    <div class="card-header"><b>{{ __('H3 List') }}</b></div>

                    <div class="card-body">
                        @if(count($H3List))
                            @foreach($H3List as $h3)
                                <div class="row"  style="margin-top: 2%">
                                    <div class="col-lg-3 col-md-3">
                                        {{$h3['h3_name']}}
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                        <div class="row">
                                            <button class="btn btn-md btn-danger">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            {{ __('You didnt add any H3 category') }}
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
            if(!$('.h2_name').val()) {
                alert('Please select h2 name');
                return false;
            }
            $(document).find('.divLoading').removeClass('hidden');
            var payload = {
                'h2_name'         : $('.h2_name').val(),
                'h3_name'         : $('.h3_name').val(),
            }

            $.ajax({
                        url: api_url+"/hierarchy/add/h3",
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data:  payload,
                        success: function(result){
                            if(result.status) {
                                alert('H3 added successfully.');
                                location.reload();
                            } else {
                                alert('Failed.Please try again after sometime')
                            }
                        }
                    })
        });
    })
</script>
@endsection