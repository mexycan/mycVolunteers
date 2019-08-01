@extends('layouts.app')

@section('content')
<div class="sectionHeader">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Register</h1>
            </div>
        </div>
    </div>
</div>
<div class="container mt-3">
    <div class="row  justify-content-md-center">            
        <div class="col col-lg-6">
            <p class="text-center">The first 100 registered Volunteers get a Free T-Shirt!</p>

                    <form class="form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="form-group col-6 {{ $errors->has('firstname') ? ' has-error' : '' }}">
                                <label for="firstname" class=" control-label">First Name</label>

                                    <input id="firstname" type="text" class="form-control" name="firstname" value="{{ old('firstname') }}" required autofocus>

                                    @if ($errors->has('firstname'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('firstname') }}</strong>
                                        </span>
                                    @endif
                            </div>

                            <div class="form-group col-6 {{ $errors->has('lastname') ? ' has-error' : '' }}">
                                <label for="lastname" class=" control-label">Last Name</label>

                                    <input id="lastname" type="text" class="form-control" name="lastname" value="{{ old('lastname') }}" required autofocus>

                                    @if ($errors->has('lastname'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('lastname') }}</strong>
                                        </span>
                                    @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class=" control-label">E-Mail Address</label>

                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>
                        <div class="form-group {{ $errors->has('area') ? ' has-error' : '' }}">
                            <label for="area_id" class="control-label">Area of interest</label>

                            <select id="area_id" class="form-control" name="area_id">
                                <?php
                                foreach($areas as $a){
                                ?>
                                <option value="<?php echo $a->id; ?>"><?php echo $a->name; ?></option>
                                <?php 
                                }
                                ?>
                            </select>
                                
                        </div>

                        <div class="row">
                            <div class="form-group col-6 {{ $errors->has('age') ? ' has-error' : '' }}">
                                <label for="age" class=" control-label">Age</label>

                                    <input id="age" type="number" class="form-control" name="age" value="{{ old('age') }}" required autofocus>

                            </div>

                            <div class="form-group col-6 {{ $errors->has('phone') ? ' has-error' : '' }}">
                                <label for="phone" class=" control-label">Phone</label>

                                    <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}"  autofocus>
                                
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="control-label">Password</label>

                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group ">
                            <label for="password-confirm" class=" control-label">Confirm Password</label>

                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                        </div>

                        <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                        </div>
                    </form>
                </div>
        </div>
    </div>
</div>
@endsection
