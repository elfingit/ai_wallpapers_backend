
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Request for remove data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<style>
    .form-group {
        margin: 1rem auto;
    }
    body {
        background: #0A314B; color: white;
    }
</style>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">AI Wallpapers</h1>
            <h2 class="text-center">{{ __('Request for remove personal data') }}</h2>
            <p class="text-center">
                {{ __('Enter below your email address to remove your personal data from our service.') }}
            </p>
            <form action="{{ route('google.remove_data_send') }}" method="post">
                @csrf
                <div class="form-group col-md-4 mx-auto">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-4 mx-auto">
                    <button type="submit" class="btn btn-primary float-end">{{ __('Submit') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
