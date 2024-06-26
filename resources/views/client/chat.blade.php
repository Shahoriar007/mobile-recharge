@extends('clientLayouts/contentLayoutMaster')
@section('content')
    <div class="navbar">
      <a href="{{ route('chat') }}">Chat</a>
      <a href="#command">Command</a>
      <a href="">
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </a>
    </div>
    <div class="chat-container">
      <div class="chat-header">
        Chat Now
      </div>
      <div class="chat-messages" id="chat-messages">
        <div class="chat-message received">
          Hello, how can I help you?
          <div class="message-meta">
            <span class="time">12:00 PM</span>
          </div>
        </div>
      </div>
      <div class="chat-input">
        <input type="text" id="message-input" placeholder="Type a message...">
        <button id="send-btn">Send</button>
      </div>
    </div>

    <script>
      document.getElementById("send-btn").addEventListener("click", function() {
        var messageInput = document.getElementById("message-input");
        var message = messageInput.value.trim();
        if (message !== "") {
          var chatMessages = document.getElementById("chat-messages");
          var newMessage = document.createElement("div");
          newMessage.classList.add("chat-message", "sent");
          newMessage.innerHTML = message + '<div class="message-meta"><span class="time">' + new Date().toLocaleTimeString() + '</span> ✓✓</div>';
          chatMessages.insertBefore(newMessage, chatMessages.firstChild);
          messageInput.value = "";
        }
      });
    </script>

