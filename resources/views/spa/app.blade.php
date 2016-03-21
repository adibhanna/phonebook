@extends('layouts.app')

@section('head')
<meta name="token" value="{{ csrf_token() }}">
@endsection

@section('content')
    <div class="container" id="spaApp">

        <div class="row">
            <div class="col-md-4">
                <form v-on:submit.prevent="addContact">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Name" name="name" v-model="name">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Phone" name="phone" v-model="phone">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="notes" rows="2" placeholder="Additional Notes" v-model="notes"></textarea>
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
                    <div class="list-group">
                        <a href="#" class="list-group-item" v-for="contact in contacts">
                            <h4 class="list-group-item-heading">
                                @{{contact.name}} - userID: @{{ contact.user_id }}
                                <small class="pull-right">@{{ contact.created_at }}</small>
                            </h4>
                            <div class="list-group-item-text">
                                <h5>Phone:
                                    <ins>@{{ contact.phone }}</ins>
                                </h5>
                                <span>@{{ contact.notes }}</span>
                                <div class="row">
                                    <div class="pull-right" style="margin-right: 5px">
                                        <button class="btn btn-sm btn-primary">
                                            <i class="glyphicon glyphicon-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" type="submit">
                                            <i class="glyphicon glyphicon-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
