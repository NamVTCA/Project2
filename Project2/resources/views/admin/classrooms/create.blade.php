@extends('layouts.dashboard')

@section('content')
<link rel="stylesheet" href="{{ asset('css/ClassroomsCreation.css') }}">
<div class="classroom-create-page">
    <div class="back-button">
        <a href="{{ route('admin.dashboard')}}" class="btn btn-primary">
            <i class="fas fa-arrow-left"></i> Quay về
        </a>
    </div>
    <h2>Tạo lớp học mới</h2>
    @if($errors->any())
        <div class="error-list">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('classrooms.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Tên lớp học:</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="user_id">Giáo viên:</label>
            <select id="user_id" name="user_id" required>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ old('user_id') == $teacher->id ? 'selected' : '' }}>
                        {{ $teacher->name }}
                    </option>
                @endforeach
                @foreach($allTeachers as $teacher)
                    @if($teacher->classroom)
                        <option value="{{ $teacher->id }}" disabled style="color: gray;">
                            {{ $teacher->name }} (đã phân lớp)
                        </option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="status">Trạng thái:</label>
            <select id="status" name="status" required>
                <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Hoạt động</option>
                <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Không hoạt động</option>
            </select>
        </div>

        <div id="facility-details">
            <h5>Cơ sở vật chất</h5>
            <ul id="facility-list">
           </ul>
        </div>

       <div class="form-group">
            <label for="add-facility-select">Thêm cơ sở vật chất:</label>
            <div class="d-flex align-items-center">
             <select id="add-facility-select" class="form-control" style="margin-right:10px" >
                 <option value="">Chọn cơ sở vật chất</option>
                   @foreach($totalFacilities as $totalFacility)
                        <optgroup label="{{$totalFacility->name}}">
                           @foreach($totalFacility->dentail as $dentail)
                               <option value="{{$dentail->id}}" data-quantity="{{$dentail->quantity}}">
                                   {{$dentail->name}} (Còn lại: {{$dentail->quantity}})
                                </option>
                           @endforeach
                       </optgroup>
                   @endforeach
                </select>
               <input type="number" name="quantity_add" id ="quantity-add"  class="form-control" value = "1" min = "1" style="max-width: 100px; margin-right: 10px;">
              <button type="button" id="add-facility" class="btn btn-secondary">Thêm</button>
           </div>
        </div>
        <button type="submit" class="btn btn-primary">Tạo lớp</button>
    </form>
</div>

 <script>
    let facilities = @json($totalFacilities);

      document.addEventListener('click', function (e) {
          if (e.target && e.target.classList.contains('remove-facility')) {
               const facilityName = e.target.getAttribute('data-name');
               const facilityQuantity = e.target.getAttribute('data-quantity');
                const dentail_id = e.target.getAttribute('data-dentail_id');
              document.querySelectorAll('#add-facility-select option').forEach(option => {
                       if (option.value == dentail_id)
                         option.dataset.quantity = parseInt(option.dataset.quantity) + parseInt(facilityQuantity)
                       option.text = `${option.text.split(' (')[0]} (Còn lại: ${option.dataset.quantity})`;
                   })
                  e.target.parentElement.remove();
           }
      });

  document.getElementById('add-facility').addEventListener('click', function() {
      const dentailId = document.getElementById('add-facility-select').value;
        const quantity = parseInt(document.getElementById('quantity-add').value);
         const dentailSelect = document.getElementById('add-facility-select')
        const dentailOption = dentailSelect.selectedOptions[0];

          if (dentailId && quantity > 0)
                {
                     let availableQuantity = parseInt(dentailOption.dataset.quantity);
                     const facilityDetails = document.getElementById('facility-details');
                       let existingFacility = facilityDetails.querySelector(`li[data-dentail-id="${dentailId}"]`);

                        if (existingFacility) {
                            let currentQuantity = parseInt(existingFacility.querySelector('.quantity').textContent);
                            let newQuantity = currentQuantity + quantity;

                              if (newQuantity > availableQuantity + currentQuantity) {
                                  alert('Số lượng vượt quá số lượng cho phép!');
                                  return;
                               }
                             existingFacility.querySelector('.quantity').textContent = newQuantity;
                           existingFacility.querySelector('input[name^="facility_details"]').value = newQuantity;
                             existingFacility.querySelector('button').dataset.quantity = newQuantity;
                             existingFacility.querySelectorAll('input[type="hidden"]').forEach(input => {
                                if (input.name.endsWith('[quantity]')) {
                                     input.value = newQuantity;
                                  }
                           });
                       }

                         else {
                            if (quantity > availableQuantity) {
                                 alert('Số lượng vượt quá số lượng cho phép!');
                                return;
                           }
                           const newDetail = `
                                <li data-dentail-id="${dentailId}">
                                     Cơ sở vật chất: ${dentailOption.text.split(' (')[0]} - Số lượng: <span class="quantity">${quantity}</span>
                                   <button type="button" class="btn btn-danger remove-facility" data-name="${dentailOption.text.split(' (')[0]}" data-dentail_id ="${dentailId}" data-quantity="${quantity}">Xóa</button>
                                   <input type="hidden" name="facility_details[${dentailId}][dentail_id]" value = "${dentailId}">
                                   <input type="hidden" name="facility_details[${dentailId}][quantity]" value = "${quantity}">
                                 </li>
                             `;
                            facilityDetails.querySelector('ul').insertAdjacentHTML('beforeend', newDetail);
                        }
                             dentailOption.dataset.quantity = availableQuantity - quantity;
                           dentailOption.text = `${dentailOption.text.split(' (')[0]} (Còn lại: ${dentailOption.dataset.quantity})`;
                    }
                });
            // Nút quay về
            document.getElementById('back-button').addEventListener('click', function () {
            window.history.back();
        });
</script>
@endsection