<div class="container">
    <h1>Danh sách camera</h1>
    <div class="row">
        @foreach($cameras as $camera)
            <div class="col-md-4">
                <h3>{{ $camera->name }}</h3>
                <iframe src="{{ $camera->stream_url }}" width="100%" height="500" frameborder="0" allowfullscreen></iframe>
            </div>
        @endforeach
    </div>
</div>
