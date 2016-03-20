@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <form action="{{ url('/') }}" method="post">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id" value="{{$contact->id}}">
                    {!! csrf_field() !!}
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <input type="text" class="form-control" placeholder="Name" name="name" value="{{ $contact->name }}">
                    </div>
                    @if ($errors->has('phone'))
                        <span class="help-block">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </span>
                    @endif
                    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                        <input type="text" class="form-control" placeholder="Phone" name="phone" value="{{ $contact->phone }}">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="notes" rows="2" placeholder="Additional Notes">{{$contact->notes}}</textarea>
                    </div>
                    <button class="btn btn-primary" type="submit">
                        <i class="glyphicon glyphicon-plus"></i> Save
                    </button>
                    <a href="/" class="btn btn-default" type="submit">
                        <i class="glyphicon glyphicon-backward"></i> Cancel
                    </a>
                </form>

            </div>
        </div>
    </div>
@endsection
