<!DOCTYPE html>
<html>
<head>
    <title>Laravel 5.7 Import Export Excel to database Example - ItSolutionStuff.com</title>
    {!! Html::style('css/app.css', ['rel' => 'stylesheet']) !!}
    
</head>
<body>

<div class="container">
    <div class="card bg-light mt-3">
        <div class="card-header">
            Laravel 5.7 Import Export Excel to database Example
        </div>
        <div class="card-body">
            <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @error('file')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <input type="file" name="file" class="form-control">
                <br>
                <button class="btn btn-success">Import User Data</button>
            </form>

            <form action="{{ route('export') }}" method="GET" enctype="multipart/form-data">
                @csrf
                <select class="form-control" name="file_type">
                    @foreach ($types as $type)
                        <option value="{{ $type }}">{{ $type }}</option>
                    @endforeach
                </select>
                <select class="form-control" name="separation">
                    @foreach ($separations as $key => $separation)
                        <option value="{{ $separation['value'] }}">{{ $separation['value'] }}</option>
                    @endforeach
                </select>

                <select class="form-control" name="encoding">
                    @foreach ($encodings as $key => $encoding)
                        <option value="{{ $key }}">{{ $encoding }}</option>
                    @endforeach
                </select>
                
                @foreach ($exportColumns as $key => $exportColumn)
                    <input type="checkbox" id="{{ $key }}" name="export_column[{{ $key }}]" value="{{ $key }}" checked> <label for="{{ $key }}">{{ __($exportColumn) }}</label><br>
                @endforeach

                <br>
                <button class="btn btn-warning">Export User Data</button>
            </form>
        </div>
    </div>
</div>

    {!! Html::script('js/app.js') !!}

    <script>
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('a3357111ddb3ef61a409', {
      cluster: 'ap1',
      forceTLS: true
    });

    var channel = pusher.subscribe('public');
    channel.bind('import', function(data) {
      alert(JSON.stringify(data));
    });
  </script>

</body>
</html>
