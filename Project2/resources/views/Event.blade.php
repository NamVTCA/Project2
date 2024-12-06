@extends('layouts.dashboard')

@section('content')
<link rel="stylesheet" href="{{ asset('css/Event.css') }}">
<div class="content-section">
  <section class="event-section py-5">
      <div class="container">
          <h2 class="text-primary fw-bold text-center mb-4">Sự Kiện</h2>
          <div class="row">
              <div class="col-md-6 mb-4">
                  <div class="card border-0 shadow">
                      <img src="{{ asset('img/event1.jpg') }}" class="card-img-top" alt="Sự Kiện 1">
                      <div class="card-body">
                          <h3 class="card-title text-primary">Ngày Hội Gia Đình</h3>
                          <p class="card-text">Tham gia các hoạt động vui chơi, giao lưu và tham gia các trò chơi cùng gia đình.</p>
                      </div>
                  </div>
              </div>
              <div class="col-md-6 mb-4">
                  <div class="card border-0 shadow">
                      <img src="{{ asset('img/event2.jpg') }}" class="card-img-top" alt="Sự Kiện 2">
                      <div class="card-body">
                          <h3 class="card-title text-primary">Ngày Hội Vẽ Tranh</h3>
                          <p class="card-text">Tham gia các hoạt động vẽ tranh, sáng tạo và trưng bày các tác phẩm của các em.</p>
                      </div>
                  </div>
              </div>
              <div class="col-md-6 mb-4">
                  <div class="card border-0 shadow">
                      <img src="{{ asset('img/event3.jpg') }}" class="card-img-top" alt="Sự Kiện 3">
                      <div class="card-body">
                          <h3 class="card-title text-primary">Ngày Hội Thể Thao</h3>
                          <p class="card-text">Tham gia các hoạt động thể thao, vận động và giao lưu cùng bạn bè.</p>
                      </div>
                  </div>
              </div>
              <div class="col-md-6 mb-4">
                  <div class="card border-0 shadow">
                      <img src="{{ asset('img/event4.jpg') }}" class="card-img-top" alt="Sự Kiện 4">
                      <div class="card-body">
                          <h3 class="card-title text-primary">Ngày Hội Đọc Sách</h3>
                          <p class="card-text">Tham gia đọc sách cùng bạn bè.</p>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </section>
</div>
@endsection
