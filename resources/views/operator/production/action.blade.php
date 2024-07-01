@if ($model->machine->ip_address == request()->ip())
    <a href="{{ url('operator/production/' . $model->id . '/show') }}" class="btn btn-primary">Go To Report Page</a>
@else
    @if (auth()->user()->hasRole('supervisor|super-admin|owner'))
        <a href="{{ url('operator/production/' . $model->id . '/show') }}" class="btn btn-success">Supervise</a>
    @else
        <span class="text-danger">you have no rights to process this workorder</span>
    @endif
@endif
