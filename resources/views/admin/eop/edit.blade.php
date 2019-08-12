@extends('layouts.app')

@section('head')
@parent

@endsection
@section('page_title','Edit Elements of Performance')
@section('page_description','Edit elements of performance here')
@section('content')
@include('layouts.partials.success')
@include('layouts.partials.errors')

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Edit Elements of Performance for {{$standard_label->label}}</h3>

        <div class="box-tools pull-right">
        </div>
      </div>
      <div class="box-body">
        {!! Form::open(['url' => 'admin/standard-label/'.$standard_label->id.'/eop/edit/'.$eop->id, 'class' => 'form-horizontal']) !!}

            <fieldset>

              <!-- Name -->
              <div class="form-group">
                  {!! Form::label('name', 'Name:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::text('name', $eop->name, ['class' => 'form-control', 'placeholder' => 'Client Name']) !!}
                  </div>
              </div>

              <div class="form-group">
                  {!! Form::label('text', 'Text:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                      {!! Form::textarea('text', $eop->text, ['class' => 'form-control']) !!}
                  </div>
              </div>

                <!-- Email -->
                <div class="form-group">
                    {!! Form::label('documentation', 'Documentation Required:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('documentation', ['0' => 'No','1' => 'Yes'], $eop->documentation, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <!-- Phone -->
                <div class="form-group">
                    {!! Form::label('frequency', 'Frequency:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                      {!! Form::select('frequency', ['no_frequency' => 'No Frequency','daily' => 'Daily','weekly' => 'Weekly','monthly' => 'Monthly','quarterly' => 'Quarterly','annually' => 'Annually','semi-annually' => 'Semi-anually','as_needed' => 'As Needed' ,'per_policy' => 'Per Policy','two-years' => 'Two Years', 'three-years' => 'Three Years', 'four-years' => 'Four Years', 'five-years' => 'Five Years', 'six-years' => 'Six Years'], $eop->frequency, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('risk', 'Risk:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('risk', ['0' => 'No','1' => 'Yes'], $eop->risk, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('occupancy_type', 'Occupancy Type:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('occupancy_type', $occupancy_types,  $eop->occupancy_type, ['class' => 'form-control']) !!}
                    </div>
                </div>


                <div class="form-group">
                    {!! Form::label('cops', 'CMS COPS:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('cops[]', $cops, $eop->subCOPs->pluck('id')->toArray(), ['class' => 'form-control selectpicker','multiple' => 'true']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('accreditations', 'Accreditations:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('accreditations[]', $accreditations, $eop->accreditations->pluck('id')->toArray(), ['class' => 'form-control selectpicker','multiple' => 'true']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('problems', 'Problems:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('problems[]', $problems, $eop->problems->pluck('id')->toArray(), ['class' => 'form-control selectpicker','placeholder' => 'Please select','multiple' => 'true','data-live-search' => 'true']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('is_ilsm', 'Is ILSM Required:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('is_ilsm', ['0' => 'No','1' => 'Yes'], $eop->is_ilsm, ['class' => 'form-control','id' => 'is_ilsm']) !!}
                    </div>
                </div>

                

                <div class="islm form-group" @if(!$eop->is_ilsm) style="display:none;" @endif>
                    {!! Form::label('is_ilsm_shift', 'Correct during shift, no ILSM required:', ['class' => 'col-lg-2 control-label']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('is_ilsm_shift', ['0' => 'No','1' => 'Yes'], $eop->is_ilsm_shift, ['class' => 'form-control','id' => 'is_ilsm_shift']) !!}
                    </div>
                </div>

                <div class="islm form-group" @if(!$eop->is_ilsm) style="display:none;" @endif>
                  {!! Form::label('islm_hours_threshold', 'ILSM Hour Threshold:', ['class' => 'col-lg-2 control-label']) !!}
                  <div class="col-lg-10">
                        {!! Form::select('islm_hours_threshold', ['0' => 'No Threshold'] + range(0,100), $eop->islm_hours_threshold, ['class' => 'form-control','id' => 'islm_hours_threshold']) !!}
                  </div>
                </div>


                <!-- Submit Button -->
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        {!! link_to('admin/standard-label/'.$standard_label->id.'/eop','Cancel', ['class' => 'btn btn-warning'] ) !!}
                        {!! Form::submit('Save EOP', ['class' => 'btn btn-success pull-right'] ) !!}
                    </div>
                </div>

            </fieldset>

            {!! Form::close()  !!}
               </div>
      <!-- /.box-body -->
      <div class="box-footer">

      </div>
      <!-- /.box-footer-->
    </div>

        <script>
        $('#is_ilsm').change(function(){
            if($(this).val() == 1){
                $('.islm').show();
            }else{
                $('.islm').hide();
                $('#is_ilsm_shift').val(0);
                $('#islm_hours_threshold').val(0);
            }
        });

        $('#is_ilsm_shift').change(function(){
            if($(this).val() == 1){
                enableAllExcept('islm_hours_threshold',0)
            }else{
                enableAll('islm_hours_threshold');
            }
        });

     function enableAllExcept(selector,value)
      {
            $('#'+selector+' option').each(function() {
                if($(this).val() != value) {
                    $(this).attr('disabled', true);
                }
            });
      }

      function enableAll(selector)
      {
            $('#'+selector+' option').each(function() {
                $(this).attr('disabled', false);
            });
      }


    </script>


@endsection
