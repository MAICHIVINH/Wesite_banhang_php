const chatToggle = document.getElementById("chat-toggle");
const chatForm = document.getElementById("chat-form");
const chatClose = document.getElementById("chat-close");
const sendMessage = document.getElementById("send-message");
const chatInput = document.getElementById("chat-input");
const chatContent = document.getElementById("chat-content");

chatToggle.addEventListener("click", () => {
  chatForm.classList.toggle("hidden");
});

chatClose.addEventListener("click", () => {
  chatForm.classList.add("hidden");
});

function addMessage(message, isMine = true) {
  const msgDiv = document.createElement("div");
  msgDiv.classList.add("d-flex", "mb-2");
  msgDiv.style.wordBreak = "break-word";

  if (isMine) {
    msgDiv.classList.add("justify-content-end");
    msgDiv.innerHTML = `
                <div class="p-2 bg-primary text-white border rounded" style="max-width: 70%;">
                    ${message}
                </div>
            `;
  } else {
    msgDiv.classList.add("align-items-start");
    msgDiv.innerHTML = `
                <img src="https://tse4.mm.bing.net/th?id=OIP.8xHZ13-7xIo-wSNdPYmeXgAAAA&pid=Api&P=0&h=220" class="rounded-circle me-2" style="width: 30px; height: 30px;">
                <div>
                    <strong>Hỗ trợ viên</strong>
                    <div class="p-2 bg-light border rounded" style="max-width: 70%;">
                        ${message}
                    </div>
                </div>
            `;
  }

  chatContent.appendChild(msgDiv);
  chatContent.scrollTop = chatContent.scrollHeight;
}
sendMessage.addEventListener("click", () => {
  const message = chatInput.value.trim();
  if (message) {
    addMessage(message, true);
    chatInput.value = "";
  
    setTimeout(() => {
      addMessage("Cảm ơn bạn, chúng tôi sẽ phản hồi sớm!", false);
    }, 1000);
  }
});
chatInput.addEventListener("keypress", (e) => {
  if (e.key === "Enter") {
    sendMessage.click();
    e.preventDefault();
  }
});
