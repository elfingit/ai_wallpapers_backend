<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" style="font-family:roboto, 'helvetica neue', helvetica, arial, sans-serif">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="telephone=no" name="format-detection">
    <title>AI Wallpapers</title>
</head>
<body>
<h1>{{ __('Remove personal data from AI Wallpapers') }}</h1>
<p>
    {{ __('We received a request to remove your personal data from AI Wallpapers.') }}<br/>
    {{ __('If you did not make this request, just ignore this letter.') }}
</p>
<p>
    {{ __('To confirm the request, click the link below.') }}
    <a href="{{ route('google.remove_data_confirm', ['token' => $confirm_token]) }}">{{ __('Remove data')  }}</a>
</p>
<p>
    {{ __('If link not working, just copy below url and paste it to browser') }}

    <br/>
    {{ route('google.remove_data_confirm', ['token' => $confirm_token]) }}
</p>
</body>
</html>
