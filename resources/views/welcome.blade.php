@extends('layouts.app')

@section('content')
   @if(Auth::check())
      <?php $user = Auth::user(); ?>
      {{ $user->name }}
   @else
    <div class='center jumbotron'>
        <div class='text-center'>
            <h1>Welcome to the Task-list</h1>
            {!! link_to_route('signup.get', 'Sign up now!', null,['class' => 'btn btn-primary']) !!}
        </div>
    </div>
   @endif
@endsection