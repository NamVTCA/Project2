<link rel="stylesheet" href="{{ asset('css/ChatParent.css') }}">
<h2>Trò chuyện phụ huynh</h2>
<ul>
    @foreach($teachers as $teacher)
        <li>
            <a href="javascript:void(0)" onclick="openChat({{ $teacher->id }}, '{{ $teacher->name }}')">
                {{ $teacher->name }}
            </a>
        </li>
    @endforeach
</ul>

<div id="chat-box" style="display:none;">
    <h3 id="chat-with"></h3>
    <div id="messages" style="border: 1px solid #ccc; height: 300px; overflow-y: auto; margin-bottom: 10px; padding: 10px;">
    </div>
    <form id="chat-form">
        <input type="hidden" name="receiver_id" id="receiver_id">
        <textarea name="message" id="message" rows="3" placeholder="Nhập tin nhắn của bạn..." style="width: 100%;"></textarea>
        <button type="submit" style="margin-top: 10px;">Gửi</button>
    </form>
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
</script>

