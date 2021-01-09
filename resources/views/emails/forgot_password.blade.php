@component('mail::message')

<p>Dear {{ $data['name'] }},</p>

<p>If you recognize this activity, please confirm it with the activation code. Here is your account activation code:</p>

<p style="text-align: center; font-size: 300%; margin: 0;">
    <b>{{ $data['otp'] }}</b>
</p>

Thanks,<br>
{{ config("app.name") }}
@endcomponent