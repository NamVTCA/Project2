
<div class="container">
    <h1>Danh sách camera</h1>
    <div class="row">
        @foreach($cameras as $camera)
            <div class="col-md-4">
                <h3>{{ $camera->name }}</h3>
                <video width="100%" controls autoplay>
                    <source src="{{ $camera->stream_url }}" type="application/x-mpegURL">
                    Trình duyệt không hỗ trợ video trực tiếp.
                </video>
            </div>
        @endforeach
    </div>
</div>

