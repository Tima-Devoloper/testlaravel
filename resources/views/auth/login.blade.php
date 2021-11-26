<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body class="text-center">
    <main class="form-signin container">
        <div style="text-align: right;margin-top:1rem">
            <a href="/registration">Регистрация</a>
        </div>
        <div class="container" style="margin-top: 10rem;">
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <h1 class="h3 mb-3 fw-normal">Войти</h1>
    
                <div class="form-floating">
                    <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com">
                    <label for="email">Email</label>
                </div><br>
                <div class="form-floating">
                    <input type="password" name="password" class="form-control" id="password">
                    <label for="password">Пароль</label>
                </div><br>


                <div style="color:red">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div>{{$error}}</div>
                        @endforeach
                    @endif
                </div>
    
                <button class="w-100 btn btn-lg btn-primary" type="submit">Войти</button>
            </form>
        </div>

    </main>

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>