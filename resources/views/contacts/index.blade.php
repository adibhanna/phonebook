@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <form action="{{ url('/') }}" method="post">
                    {!! csrf_field() !!}
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <input type="text" class="form-control" placeholder="Name" name="name" value="{{ old('name') }}">
                    </div>
                    @if ($errors->has('phone'))
                        <span class="help-block">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </span>
                    @endif
                    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                        <input type="text" class="form-control" placeholder="Phone" name="phone" value="{{ old('phone') }}">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="notes" rows="2" placeholder="Additional Notes"></textarea>
                    </div>
                    <button class="btn btn-default btn-block" type="submit">
                        <i class="glyphicon glyphicon-plus"></i> Save
                    </button>
                </form>

            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <form action="#">
                        <input type="search" class="form-control input-lg" name="q" placeholder="Search..." autofocus>
                    </form>
                </div>
                <div class="form-group">
                    @if($contacts->isEmpty())
                        <p>No result found.</p>
                    @endif
                    <div class="list-group">
                        @foreach($contacts as $contact)
                            <a href="#" class="list-group-item">
                                <h4 class="list-group-item-heading">
                                    {{ucwords($contact->name)}}
                                    <small class="pull-right">{{ $contact->updated_at->format('Y-m-d') }}</small>
                                </h4>
                                <div class="list-group-item-text">
                                    <h5>Phone:
                                        <ins>{{ $contact->phone }}</ins>
                                    </h5>
                                <span>
                                    {{ $contact->notes }}
                                </span>
                                    <div class="row">
                                        <div class="pull-right" style="margin-right: 5px">
                                            <button class="btn btn-sm btn-primary" onclick="window.location.href='/{{$contact->id}}/edit'">
                                                <i class="glyphicon glyphicon-edit"></i>
                                            </button>
                                            <form action="{{ url('/'. $contact->id) }}" method="post" class="pull-right">
                                                {!! csrf_field() !!}
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button class="btn btn-sm btn-danger" type="submit">
                                                    <i class="glyphicon glyphicon-trash"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                {!! $contacts->links() !!}
            </div>
        </div>
    </div>
@endsection
