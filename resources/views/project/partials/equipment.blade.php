{!! Form::open(['url' => 'projects/equipment/edit/'.$project->id, 'class' => 'form-horizontal']) !!}

@foreach($equipments as $equipment)

<div class="form-group row">
  <div class="col-xs-6">
    {!! Form::label('equipment_'.$equipment->id, $equipment->name, ['class' => 'control-label']) !!}
  </div>
  <div class="col-xs-3">
    {!! Form::text('existing_equipments['.$equipment->id.']', $question->projects->where('id',$project->id)->first()->pivot->answer_id, ['class' => 'form-control', 'placeholder' => 'Existing']) !!}
  </div>
  <div class="col-xs-3">
    {!! Form::text('replacement_equipments['.$equipment->id.']', '', ['class' => 'form-control', 'placeholder' => 'Replacement']) !!}
  </div>
</div>
@endforeach

<div class="form-group">
<div class="col-lg-10 col-lg-offset-2">
    {{ link_to('projects', $title = 'Cancel', $attributes = ['class' => 'btn btn-warning'], $secure = null)}}
    {!! Form::submit('Save Equipment', ['class' => 'btn btn-success pull-right'] ) !!}
</div>
</div>



{!! Form::close()  !!}