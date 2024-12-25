<link rel="stylesheet" href="{{ asset('css/ChatParent.css') }}">

<div class="chat-parent-container">
    <h2 class="chat-title">Trò chuyện phụ huynh</h2>
    <ul class="teacher-list">
        <button id="back-button" class="btn btn-secondary">← Quay về</button>
        @foreach($teachers as $teacher)
            <li class="teacher-item">
                <a href="javascript:void(0)" onclick="openChat({{ $teacher->id }}, '{{ $teacher->name }}')">
                    <span class="teacher-name">{{ $teacher->name }}</span>
                     <img src="{{ url('storage/' .  $teacher->img) }}" 
                                 alt="Ảnh Đại Diện" 
                                 class="rounded-circle mb-3" 
                                 style="width: 120px; height: 120px; object-fit: cover;">
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
document.addEventListener('DOMContentLoaded', () => {
    let lastMessageId = 0;

    const fetchChatHistory = (receiverId) => {
        fetch(`/chat-history/${receiverId}`)
            .then(res => res.json())
            .then(messages => {
                const messagesDiv = document.querySelector('#messages');
                messagesDiv.innerHTML = '';
                messages.forEach(msg => {
                    const div = document.createElement('div');
                    div.classList.add('message', msg.sender_id === {{ auth()->id() }} ? 'message-right' : 'message-left');
                    div.textContent = msg.sender_id === {{ auth()->id() }} ? `Bạn: ${msg.message}` : `Người gửi: ${msg.message}`;
                    messagesDiv.appendChild(div);
                    lastMessageId = msg.id;
                });
                messagesDiv.scrollTop = messagesDiv.scrollHeight;
            })
            .catch(console.error);
    };

    const startPolling = (receiverId) => {
        setInterval(() => {
            fetch(`/get-new-messages`, {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json', 
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                },
                body: JSON.stringify({ receiver_id: receiverId, last_message_id: lastMessageId })
            })
                .then(res => res.json())
                .then(messages => {
                    const messagesDiv = document.querySelector('#messages');
                    messages.forEach(msg => {
                        const div = document.createElement('div');
                        div.classList.add('message', msg.sender_id === {{ auth()->id() }} ? 'message-right' : 'message-left');
                        div.textContent = msg.sender_id === {{ auth()->id() }} ? `Bạn: ${msg.message}` : `Người gửi: ${msg.message}`;
                        messagesDiv.appendChild(div);
                        lastMessageId = msg.id;
                    });
                    messagesDiv.scrollTop = messagesDiv.scrollHeight;
                })
                .catch(console.error);
        }, 2000);
    };

    document.querySelector('#chat-form').addEventListener('submit', (e) => {
        e.preventDefault();
        const receiverId = document.querySelector('#receiver_id').value;
        const message = document.querySelector('#message').value;

        fetch('/send-message', {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json', 
                'X-CSRF-TOKEN': '{{ csrf_token() }}' 
            },
            body: JSON.stringify({ receiver_id: receiverId, message })
        })
            .then(() => {
                fetchChatHistory(receiverId);
                document.querySelector('#message').value = '';
            })
            .catch(console.error);
    });

    document.querySelector('#back-button').addEventListener('click', () => window.history.back());

    window.openChat = (receiverId, receiverName) => {
        document.querySelector('#chat-box').style.display = 'block';
        document.querySelector('#chat-with').innerText = `Trò chuyện với ${receiverName}`;
        document.querySelector('#receiver_id').value = receiverId;
        fetchChatHistory(receiverId);
        startPolling(receiverId);
    };
});
</script>


