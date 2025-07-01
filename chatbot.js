// Function to toggle chatbot visibility
function toggleChatbot() {
    const chatbotContainer = document.getElementById('chatbot-container');
    const openChatbotButton = document.getElementById('open-chatbot');
    if (chatbotContainer.style.display === 'none' || chatbotContainer.style.display === '') {
      chatbotContainer.style.display = 'block';
      openChatbotButton.style.display = 'none';
    } else {
      chatbotContainer.style.display = 'none';
      openChatbotButton.style.display = 'block';
    }
  }
  
  // Function to send a message
  async function sendMessage() {
    const inputField = document.getElementById('chatbot-input');
    const messagesContainer = document.getElementById('chatbot-messages');
    const userMessage = inputField.value.trim();
  
    if (userMessage === '') return;
  
    // Display user message
    const userMessageElement = document.createElement('div');
    userMessageElement.className = 'chatbot-message user-message';
    userMessageElement.innerText = userMessage;
    messagesContainer.appendChild(userMessageElement);
  
    // Clear input field
    inputField.value = '';
  
    // Call the API
    const response = await fetch('chatbot-api.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ message: userMessage }),
    });
  
    const data = await response.json();
  
    // Display bot response
    const botMessageElement = document.createElement('div');
    botMessageElement.className = 'chatbot-message bot-message';
    botMessageElement.innerText = data.response;
    messagesContainer.appendChild(botMessageElement);
  
    // Scroll to the latest message
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
  }