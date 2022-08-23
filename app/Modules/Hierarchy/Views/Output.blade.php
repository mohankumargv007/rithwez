@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12" align="center">
            <div class="card">
                <div class="card-header"><b>{{Auth()->user()->first_name}} {{Auth()->user()->last_name}}'s {{ __(' Dashboard') }}</b></div>

                <div class="card-body">
                {{ __('Output') }}
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
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div class="row justify-content-center" style="margin-top: 5%">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><b>{{ __('H4 List') }}</b></div>

                    <div class="card-body">
                        
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection
@section('BasicJs')
<script type="text/javascript">
    $(document).ready(function () {


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
            if(!$('.h3_name').val()) {
                alert('Please select h3 name');
                return false;
            }
            $(document).find('.divLoading').removeClass('hidden');
            var payload = {
                'h3_name'         : $('.h3_name').val(),
                'h4_name'         : $('.h4_name').val(),
                'wall_type'         : $('.wall_type').val(),
                'roof_type'         : $('.roof_type').val(),
                'no_of_stories'         : $('.no_of_stories').val(),
            }

            $.ajax({
                        url: api_url+"/hierarchy/add/h4",
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