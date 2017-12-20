{!! Form::open(['url' => 'projects/equipment/edit/'.$project->id, 'class' => 'form-horizontal']) !!}

@foreach($equipments as $equipment)

<div class="form-group row">
  <div class="col-xs-6">
    {!! Form::label('equipment_'.$equipment->id, $equipment->name, ['class' => 'control-label']) !!}
  </div>
  <div class="col-xs-3">
    {!! Form::text('equipment_existing_'.$equipment->id, '', ['class' => 'form-control', 'placeholder' => 'Existing']) !!}
  </div>
  <div class="col-xs-3">
    {!! Form::text('equipment_replacement_'.$equipment->id, '', ['class' => 'form-control', 'placeholder' => 'Replacement']) !!}
  </div>
</div>
@endforeach


{!! Form::close()  !!}