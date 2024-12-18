<link rel="stylesheet" href="{{ asset('css/ChatParent.css') }}">

<div class="chat-parent-container">
    <h2 class="chat-title">Trò Chuyện Phụ Huynh</h2>
    <ul class="teacher-list">
        <button id="back-button" class="btn btn-secondary">← Quay về</button>
        @foreach($teachers as $teacher)
            <li class="teacher-item">
                <a href="javascript:void(0)" onclick="openChat({{ $teacher->id }}, '{{ $teacher->name }}')">
                    <span class="teacher-name">{{ $teacher->name }}</span>
                </a>
            </li>
        @endforeach
    </ul>

    <div id="chat-box" class="chat-box" style="display: none;">
        <div class="chat-header">

            <h3 id="chat-with" class="chat-with"></h3>
        </div>
        <div id="messages" class="messages"></div>
        <form id="chat-form" class="chat-form">
            <input type="hidden" name="receiver_id" id="receiver_id">
            <textarea name="message" id="message" rows="3" placeholder="Nhập tin nhắn của bạn..." class="message-input"></textarea>
            <button type="submit" class="btn btn-primary send-button">Gửi</button>
        </form>
    </div>
</div>

<script>
// JavaScript để xử lý chat
function openChat(receiverId, receiverName) {
    document.getElementById('chat-box').style.display = 'block';
    document.getElementById('chat-with').innerText = 'Trò chuyện với ' + receiverName;
    document.getElementById('receiver_id').value = receiverId;
    fetchChatHistory(receiverId);
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
                p.textContent = msg.sender_id === {{ auth()->id() }} ? `Bạn: ${msg.message}` : `Giáo Viên: ${msg.message}`;
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

