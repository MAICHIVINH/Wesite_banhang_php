// document.addEventListener("DOMContentLoaded", function () {
//   const input = document.getElementById("chat-input");
//   const sendBtn = document.getElementById("send-message");
//   const content = document.getElementById("chat-content");

//   if (!input || !sendBtn || !content) return;

//   sendBtn.addEventListener("click", sendMessage);
//   input.addEventListener("keydown", function (e) {
//     if (e.key === "Enter") sendMessage();
//   });

//   async function sendMessage() {
//     const msg = input.value.trim();
//     if (!msg) return;

//     const res = await fetch("modules/chat/sendMessage.php", {
//       method: "POST",
//       headers: { "Content-Type": "application/json" },
//       body: JSON.stringify({ message: msg }),
//     });

//     if (res.ok) {
//       const now = new Date();
//       const timeStr = now.toLocaleTimeString() + " " + now.toLocaleDateString();

//       const bubble = document.createElement("div");
//       bubble.className = "mb-2 text-end";
//       bubble.innerHTML = `
//                 <div class="d-inline-block p-2 rounded bg-primary text-white">${msg}</div>
//                 <div class="small text-muted">${timeStr}</div>
//             `;
//       content.appendChild(bubble);
//       content.scrollTop = content.scrollHeight;

//       input.value = "";
//     }
//   }
// });
