@extends('layout.master')

@section('content')
	<h1>{{ trans('tax.form.tax_calculation') }}</h1>
	<form method="POST" action="{{ route('tax.calculate') }}" id="form">
		  <div class="form-group">
		    <label>{{ trans('tax.form.total_income') }}</label>
		    <input type="text" class="form-control" id="total_income"  placeholder="Enter Total income" name="total_income" >
		  </div>

		<div class="checkbox">
		  <label>{{ trans('tax.form.resident') }}</label>
		  <input type="checkbox" value="" name="resident" id="resident">
		</div>

		<div class="checkbox">
		  <label>{{ trans('tax.form.spouse') }}</label>
		  <input type="checkbox" value="" id="married" onclick="toggle('.Married', this)">
		</div>
		  <div class="form-group Married">
		    <label>{{ trans('tax.form.tot_spo_income') }}</label>
		    <input type="text" class="form-control Married"  placeholder="Enter Total spouse income" id="tot_spo_income" >
		  </div>

		  <div class="form-group Married">
		    <label>{{ trans('tax.form.spo_resident') }}</label>
		  <input type="checkbox" value="" id="spo_resident" class="Married">
		  </div>
		  @csrf
		  <button type="submit" class="btn btn-primary">{{ trans('tax.form.calculate') }}</button>
	</form>
	<div id="validation-errors" ></div>
	<div id="result"></div>
@endsection

@section('js')
	<script type="text/javascript">
		 $("#form").submit(function(event) {
			 $('#validation-errors').html('');
			 $('#result').html('');

		      event.preventDefault();
		      $.ajax({
				    type: "POST",
				    url: '/calculate',
				    data: { 
				    	total_income: $('#total_income').val(),
				    	resident: $('#resident').is(":checked") ? 1 : 0,
				    	married: $('#married').is(":checked") ? 1 : 0 ,
				    	tot_spo_income: $('#tot_spo_income').val(),
				    	spo_resident: $('#spo_resident').is(":checked") ? 1 : 0,
				    	_token: '{{csrf_token()}}' 
				    },
				    success:  function (xhr) {
				    	$('#result').append('<h1>Tax : ' + xhr.data.result +'</h1>');
				    },
				    error:function(xhr){
				    	$err = xhr.responseJSON;
				    	return   $.each($err.errors, function(key,value) {
							     $('#validation-errors').append('<div class="alert alert-danger">'+value+'</div');
							 });
				    }
				   
				});
	    });

		$( window ).load(function() {
		   $('.Married').toggle( $('#married').checked )
		});
		function toggle(className, obj) {
		    $(className).toggle( obj.checked )
		}


	</script>
@endsection
