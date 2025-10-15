document.addEventListener('DOMContentLoaded', function() {
    const chatbox = document.getElementById('chatbot-chatbox');
    const chatbotBody = document.getElementById('chatbot-chatbox-body');
    const chatbotInput = document.getElementById('chatbot-input');
    const chatbotSendBtn = document.getElementById('chatbot-send-btn');
    const chatbotCloseBtn = document.getElementById('chatbot-chatbox-close');

    // Función para mostrar el indicador de escritura
    function showTypingIndicator() {
        const typingIndicator = document.createElement('div');
        typingIndicator.className = 'typing-indicator active';
        typingIndicator.innerHTML = '<span></span><span></span><span></span>';
        chatbotBody.appendChild(typingIndicator);
        chatbotBody.scrollTop = chatbotBody.scrollHeight;
        return typingIndicator;
    }

    // Función para ocultar el indicador de escritura
    function hideTypingIndicator(indicator) {
        if (indicator && indicator.parentNode) {
            indicator.parentNode.removeChild(indicator);
        }
    }

    // Función para agregar un mensaje al chat
    function addMessage(message, isUser = false) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `chatbot-message ${isUser ? 'user' : 'bot'}`;
        
        // Procesar el mensaje para convertir Markdown a HTML
        const formattedMessage = formatBotMessage(message);
        
        messageDiv.innerHTML = `<div class="chatbot-bubble-text">${formattedMessage}</div>`;
        chatbotBody.appendChild(messageDiv);
        chatbotBody.scrollTop = chatbotBody.scrollHeight;
    }

    // Función para enviar mensaje al servidor
    async function sendMessage(message) {
        const typingIndicator = showTypingIndicator();
        try {
            const response = await fetch('/chatbot/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ message: message })
            });

            const data = await response.json();
            hideTypingIndicator(typingIndicator);
            
            if (data.success) {
                addMessage(data.message);
            } else {
                const errorMessage = data.message || 'Lo siento, ocurrió un error al procesar tu mensaje.';
                addMessage(errorMessage);
            }
        } catch (error) {
            console.error('Error:', error);
            hideTypingIndicator(typingIndicator);
            addMessage('Lo siento, ocurrió un error al procesar tu mensaje.');
        }
    }

    // Función para formatear el mensaje del bot
    function formatBotMessage(message) {
        // Convertir **texto** a <strong>texto</strong>
        let formatted = message.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
        
        // Convertir números seguidos de punto y espacio a lista ordenada
        formatted = formatted.replace(/(\d+)\.\s/g, '<br>$1. ');
        
        // Convertir emojis y otros caracteres especiales
        formatted = formatted.replace(/👋|✨|🦠|🌼|💪|🤧|🍄|💊|😊/g, 
            match => `<span class="emoji">${match}</span>`);
        
        return formatted;
    }

    // Event listener para el botón de enviar
    chatbotSendBtn.addEventListener('click', function() {
        const message = chatbotInput.value.trim();
        if (message) {
            addMessage(message, true);
            sendMessage(message);
            chatbotInput.value = '';
        }
    });

    // Event listener para la tecla Enter
    chatbotInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            const message = chatbotInput.value.trim();
            if (message) {
                addMessage(message, true);
                sendMessage(message);
                chatbotInput.value = '';
            }
        }
    });

    // Event listener para cerrar el chatbot
    chatbotCloseBtn.addEventListener('click', function() {
        chatbox.classList.add('closing');
        setTimeout(() => {
            chatbox.classList.remove('open', 'closing');
        }, 220);
    });
});