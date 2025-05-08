<style>
    #chatbot-toggle {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 99999;
        background: #0d6efd;
        color: white;
        padding: 12px;
        border-radius: 50%;
        border: none;
        font-size: 20px;
        cursor: pointer;
    }

    #chatbot-container {
        position: fixed;
        bottom: 80px;
        right: 20px;
        width: 320px;
        max-height: 500px;
        background: white;
        border: 1px solid #ccc;
        border-radius: 8px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        z-index: 99998;
        display: none;
        flex-direction: column;
        overflow: hidden;
    }

    #chatbot-header {
        background-color: #0d6efd;
        color: white;
        padding: 10px;
        font-weight: bold;
    }

    #chatbot-messages {
        padding: 10px;
        height: 300px;
        overflow-y: auto;
        font-size: 14px;
        flex: 1;
    }

    #chatbot-input {
        display: flex;
        border-top: 1px solid #ccc;
    }

    #chatbot-input input {
        flex: 1;
        border: none;
        padding: 10px;
        outline: none;
    }

    #chatbot-input button {
        border: none;
        background: #0d6efd;
        color: white;
        padding: 10px 15px;
        cursor: pointer;
    }
</style>

<!-- Botón flotante -->
<button id="chatbot-toggle">💬</button>

<!-- Contenedor del chatbot -->
<div id="chatbot-container">
    <div id="chatbot-header">🤖 Merl-IA</div> <!-- Cambié "Asistente Virtual" por "Merl-IA" -->
    <div id="chatbot-messages"></div>
    <div id="chatbot-input">
        <input type="text" id="chatbot-question" placeholder="Escribe tu pregunta..." />
        <button onclick="sendChatbotMessage()">Enviar</button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toggleButton = document.getElementById('chatbot-toggle');
        const container = document.getElementById('chatbot-container');

        toggleButton.addEventListener('click', () => {
            container.style.display = container.style.display === 'none' || container.style.display === '' ? 'flex' : 'none';
        });
    });

    async function sendChatbotMessage() {
        const input = document.getElementById('chatbot-question');
        const messagesDiv = document.getElementById('chatbot-messages');
        const question = input.value.trim();

        if (!question) return;

        messagesDiv.innerHTML += `<div><strong>Tú:</strong> ${question}</div>`;
        input.value = '...';

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        try {
            const res = await fetch('/ai/query', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({ message: question })
            });

            const data = await res.json();
            messagesDiv.innerHTML += `<div><strong>Merl-IA:</strong> ${data.reply}</div>`;  <!-- Cambié "Bot" por "Merl-IA" -->
        } catch (error) {
            messagesDiv.innerHTML += `<div><strong>Merl-IA:</strong> Error al responder.</div>`;  <!-- Cambié "Bot" por "Merl-IA" -->
        }

        input.value = '';
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    }
</script>
