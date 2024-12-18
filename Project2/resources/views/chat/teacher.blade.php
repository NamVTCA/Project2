<link rel="stylesheet" href="{{ asset('css/ChatTeacher.css') }}">

<div class="chat-parent-container">
    <div class="back-to-dashboard">
        <button id="back-button">← Quay về</button>
    </div>
    <h2 class="chat-title">Trò chuyện giáo viên</h2>
    <ul class="teacher-list">
        @foreach($parents as $parent)
            <li class="teacher-item">
                <a href="javascript:void(0)" 
                   class="teacher-name" 
                   onclick="openChat({{ $parent->id }}, '{{ $parent->name }}', 'parent')">
                    {{ $parent->name }}
                </a>
            </li>
        @endforeach
    </ul>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div id="chat-box" class="chat-box" style="display:none;">
        <div class="chat-header">
            <h3 id="chat-with" class="chat-with"></h3>
        </div>
        <div id="messages" class="messages"></div>
        <form id="chat-form">
            <input type="hidden" name="receiver_id" id="receiver_id">
            <textarea name="message" id="message" class="message-input" rows="3" placeholder="Nhập tin nhắn..."></textarea>
            <button type="submit" class="send-button">Gửi</button>
        </form>
    </div>
</div>


<script>
function openChat(receiverId, receiverName, type) {
    const chatBox = document.getElementById('chat-box'); 
    chatBox.style.display = 'block';
    chatBox.querySelector('#chat-with').innerText = 'Trò chuyện với ' + receiverName;
    chatBox.querySelector('#receiver_id').value = receiverId;
    fetchChatHistory(receiverId, type);
}


function fetchChatHistory(receiverId, type) {
    fetch(`/chat-history/${receiverId}`)
        .then(response => {
            if (!response.ok) throw new Error('Không thể tải lịch sử trò chuyện');
            return response.json();
        })
        .then(messages => {
            const messagesDiv = document.querySelector(type === 'teacher' ? '#teacher-chat-box #messages' : '#chat-box #messages');
            messagesDiv.innerHTML = '';
            messages.forEach(msg => {
                const p = document.createElement('p');
                p.textContent = msg.sender_id === {{ auth()->id() }} ? `Bạn: ${msg.message}` : `Phụ Huynh: ${msg.message}`;
                messagesDiv.appendChild(p);
            });
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        })
        .catch(error => alert(error.message));
}


document.getElementById('chat-form').addEventListener('submit', function (e) {
    e.preventDefault();
    const receiverId = document.getElementById('receiver_id').value;
    const message = document.getElementById('message').value;

   fetch('/send-message', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: JSON.stringify({ receiver_id: receiverId, message })
})
.then(response => {
    if (!response.ok) throw new Error('Không thể gửi tin nhắn');
    return response.json();
})
.then(() => {
    fetchChatHistory(receiverId);
    document.getElementById('message').value = '';
})
.catch(error => alert(error.message));

});

        // Nút quay về
        document.getElementById('back-button').addEventListener('click', function () {
            window.history.back();
        });

</script>

