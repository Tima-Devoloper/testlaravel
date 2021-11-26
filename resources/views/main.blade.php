<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <div class="container" style="margin-top:10rem">
        <form>
            <input type="hidden" id="token" name="remember_token" value="{{Auth::user()->remember_token}}">
            <h1 class="h3 mb-3 fw-normal">Создать чек</h1>

            
            <div>
                <label for="" class="form-label">Тип</label>
                <select class="form-select" name="type" id="check-type">
                    <option selected value="regular">обычный</option>
                    <option value="prize">призовой</option>
                </select>
            </div><br>
            
            <div>
                <label for="formFile" class="form-label">Фото</label>
                <input class="form-control" type="file" id="check-image" accept="image/jpeg,image/png,image/gif" max="7120" enctype required>
            </div><br>

            <button class="w-100 btn btn-lg btn-primary" onclick="createCheck()" type="button">Создать</button>
        </form>
        <br>

        @foreach ($checks as $check)
            <div class="container">
                <div class="row">
                    
                    {{-- user name --}}
                        {{\App\Models\User::where('id',$check->user_id)->first()->name}} - 
                    {{-- image --}}
                        <img src="{{asset($check->photo_url)}}" style="width:10rem" alt=""> - 
                    
                    {{-- type --}}
                        @if ( $check->type == 'prize')
                            призовой
                        @else
                            обычный
                        @endif - 
                    {{-- created at --}}
                        {{$check->created_at}} 
                        @if ( \Carbon\Carbon::parse($check->created_at)->getTimestamp() < \Carbon\Carbon::now()->subDay(7)->getTimestamp())
                            Не учавствует на этой неделе
                        @endif -  
                    {{-- code --}}
                        @if ($check->code)
                            {{$check->code}} -
                        @endif 
                    {{-- type --}}
                        @if ( $check->status == 'accepted')
                            Принят
                        @else
                            Отклонен
                        @endif
                </div>
            </div>
            <br>
        @endforeach

        <div class="container">
            {{ $checks->links() }} <br><br>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        function createCheck()
        {
            let formData = new FormData();
            let imagefile = document.getElementById('check-image');
            let type  = document.getElementById('check-type')
            let token = document.getElementById('token')

            if( imagefile.files[0] == null || imagefile.files[0] == 'undefined' )
            {
                alert('заполните поле фото');
                return ;
            }

            formData.append("image", imagefile.files[0]);
            formData.append("type", type.value)
            formData.append('token', token.value)

            axios.post('/api/check', formData,{
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(response => {
                let data = response.data

                alert('чек создан')
                return ;
            }).catch(error => {
                alert(error.response.data.error)
                return ;
            })
        }
    </script>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>