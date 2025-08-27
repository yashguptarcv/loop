@component('mail::message')
# @if($isNewUser) Your Account Has Been Created @else Your Account Has Been Updated @endif

Hello {{ $user->name }},

@if($isNewUser)
An account has been created for you to access our system.
@else
Your existing account has been updated with a new application.
@endif

Here are your login details:

**Email:** {{ $user->email }}  
**Password:** {{ $password }}

Please change your password after logging in.

@component('mail::button', ['url' => url('/login')])
Login to Your Account
@endcomponent

Thanks,  
{{ config('app.name') }}
@endcomponent