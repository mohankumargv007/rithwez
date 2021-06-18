@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12" align="center">
            <div class="card">
                <div class="card-header"><b>{{ __('Admin Dashboard') }}</b></div>

                <div class="card-body">
                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center" style="margin-top: 5%">
        <div class="col-md-12">
            <div class="card">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <div class="card-header"><b>{{ __('Customers Loan History') }}</b></div>

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
                                    @if($loan['status'] == 'In-Progress')
                                        <button class="btn btn-md btn-primary" 
                                            onclick="approveLoan({{$loan['id']}});">
                                                Approve        
                                        </button>
                                    @else
                                        <button class="btn btn-md btn-danger" style="color: white">
                                            Approved        
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
    function approveLoan (loan_id) {
        $(document).find('.divLoading').removeClass('hidden');
        var payload = {
            'loan_id': loan_id
        }
        $.ajax({
                url: api_url+"/loans/approve",
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:  payload,
                success: function(result){
                    if(result.status) {
                        alert('Loan approved successfully.');
                        location.reload();
                    } else {
                        alert('Approving the loan is failed.Please try again after sometime')
                    }
                }
            })
    }
</script>
@endsection