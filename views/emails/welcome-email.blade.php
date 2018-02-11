@extends('emails.base-email')

@section('body')
<p>
    Welcome to Phpunittest!
</p>

<p>
    Please <a href="{!! getenv('HOST') !!}/verify-account?token={!! $token !!}">click here to activate</a> your account.
@stop
