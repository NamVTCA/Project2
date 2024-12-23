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
                     <img src="{{ url('storage/' .  $parent->img) }}" 
                                 alt="Ảnh Đại Diện" 
                                 class="rounded-circle mb-3" 
                                 style="width: 120px; height: 120px; object-fit: cover;">
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

<style>
.message {
    display: flex;
    margin-bottom: 10px;
    padding: 10px;
    border-radius: 10px;
    max-width: 70%;
    word-wrap: break-word;
}

.message-right {
    background-color: #d1f0ff; /* Màu xanh */
    align-self: flex-end;
    margin-left: auto;
    text-align: right;
}

.message-left {
    background-color: #f0f0f0; /* Màu xám */
    align-self: flex-start;
    text-align: left;
}
</style>


<script>
let lastMessageId = 0;

function startPolling(receiverId) {
    setInterval(() => {
        fetch(`/get-new-messages`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ receiver_id: receiverId, last_message_id: lastMessageId })
        })
        .then(response => {
            if (!response.ok) throw new Error('Không thể tải tin nhắn mới');
            return response.json();
        })
        .then(messages => {
            if (messages.length > 0) {
                const messagesDiv = document.querySelector('#chat-box #messages');
                messages.forEach(msg => {
                    const p = document.createElement('div');
                    p.classList.add('message');
                    if (msg.sender_id === {{ auth()->id() }}) {
                        p.classList.add('message-right'); // Tin nhắn của bạn
                        p.textContent = `Bạn: ${msg.message}`;
                    } else {
                        p.classList.add('message-left'); // Tin nhắn của người khác
                        p.textContent = `Người gửi: ${msg.message}`;
                    }
                    messagesDiv.appendChild(p);
                    lastMessageId = msg.id; // Cập nhật ID tin nhắn cuối cùng
                });
                messagesDiv.scrollTop = messagesDiv.scrollHeight;
            }
        })
        .catch(error => console.error(error.message));
    }, 2000); // 2 giây
}

function openChat(receiverId, receiverName) {
    document.getElementById('chat-box').style.display = 'block';
    document.getElementById('chat-with').innerText = 'Trò chuyện với ' + receiverName;
    document.getElementById('receiver_id').value = receiverId;
    fetchChatHistory(receiverId);

    // Bắt đầu polling
    startPolling(receiverId);
}

function fetchChatHistory(receiverId) {
    fetch(`/chat-history/${receiverId}`)
        .then(response => {
            if (!response.ok) throw new Error('Không thể tải lịch sử trò chuyện');
            return response.json();
        })
        .then(messages => {
            const messagesDiv = document.querySelector('#chat-box #messages');
            messagesDiv.innerHTML = '';
            messages.forEach(msg => {
                const p = document.createElement('div');
                p.classList.add('message');
                if (msg.sender_id === {{ auth()->id() }}) {
                    p.classList.add('message-right'); // Tin nhắn của bạn
                    p.textContent = `Bạn: ${msg.message}`;
                } else {
                    p.classList.add('message-left'); // Tin nhắn của người khác
                    p.textContent = `Người gửi: ${msg.message}`;
                }
                messagesDiv.appendChild(p);
                lastMessageId = msg.id; // Ghi nhận tin nhắn cuối cùng
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


