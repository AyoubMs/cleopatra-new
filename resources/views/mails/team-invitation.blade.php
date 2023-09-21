@component('mail::message')
{{ __('You have been invited to join the :team team!', ['team' => $name]) }}

{{ __('If you already have an account, you may accept this invitation by clicking the button below:') }}

{{ __('You may accept this invitation by clicking the button below:') }}

@component('mail::button', ['url' => $acceptUrl])
{{ __('Accept Invitation') }}
@endcomponent

{{ __('If you did not expect to receive an invitation to this team, you may discard this email.') }}
@endcomponent
