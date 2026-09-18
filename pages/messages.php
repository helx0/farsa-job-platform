<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الرسائل - فرصة</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/rtl.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="stylesheet" href="../css/navbar-footer.css">
    <style>
        .messages-container {
            display: flex;
            height: calc(100vh - 100px);
            gap: 20px;
            padding: 20px;
        }

        .conversations-list {
            flex: 0 0 300px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }

        .conversation-search {
            padding: 15px;
            border-bottom: 1px solid #e5e7eb;
        }

        .conversation-search input {
            width: 100%;
            padding: 10px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 0.9rem;
        }

        .conversations {
            flex: 1;
            overflow-y: auto;
            padding: 10px;
        }

        .conversation-item {
            padding: 12px;
            margin-bottom: 8px;
            border-radius: 6px;
            cursor: pointer;
            background: #f9fafb;
            transition: all 0.3s;
            border-right: 3px solid transparent;
        }

        .conversation-item:hover {
            background: #f3f4f6;
        }

        .conversation-item.active {
            background: #eff6ff;
            border-right-color: #1e40af;
        }

        .conversation-item.unread {
            font-weight: 600;
        }

        .conversation-user {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
        }

        .conversation-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .conversation-info {
            flex: 1;
            min-width: 0;
        }

        .conversation-name {
            font-weight: 500;
            color: #111827;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .conversation-preview {
            font-size: 0.85rem;
            color: #6b7280;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .unread-badge {
            background: #ef4444;
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: bold;
        }

        .chat-area {
            flex: 1;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }

        .chat-header {
            padding: 15px 20px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chat-user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .chat-header-actions {
            display: flex;
            gap: 10px;
        }

        .chat-header-actions button {
            padding: 8px 12px;
            border: none;
            background: #f3f4f6;
            border-radius: 6px;
            cursor: pointer;
            color: #374151;
            transition: all 0.3s;
        }

        .chat-header-actions button:hover {
            background: #e5e7eb;
        }

        .messages-list {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .message {
            display: flex;
            gap: 12px;
            max-width: 70%;
        }

        .message.sent {
            margin-right: auto;
        }

        .message.received {
            margin-left: auto;
        }

        .message-content {
            padding: 12px 15px;
            border-radius: 12px;
            word-wrap: break-word;
        }

        .message.sent .message-content {
            background: #1e40af;
            color: white;
            border-bottom-left-radius: 0;
        }

        .message.received .message-content {
            background: #f3f4f6;
            color: #111827;
            border-bottom-right-radius: 0;
        }

        .message-time {
            font-size: 0.75rem;
            color: #9ca3af;
            margin-top: 4px;
        }

        .message-actions {
            display: flex;
            gap: 5px;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .message:hover .message-actions {
            opacity: 1;
        }

        .message-action-btn {
            width: 24px;
            height: 24px;
            border: none;
            background: none;
            cursor: pointer;
            color: #6b7280;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
        }

        .message-action-btn:hover {
            color: #1e40af;
        }

        .chat-input-area {
            padding: 20px;
            border-top: 1px solid #e5e7eb;
            display: flex;
            gap: 10px;
        }

        .chat-input-group {
            flex: 1;
            display: flex;
            gap: 10px;
        }

        .chat-input {
            flex: 1;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 0.95rem;
            font-family: inherit;
            resize: none;
            max-height: 120px;
        }

        .chat-input:focus {
            outline: none;
            border-color: #1e40af;
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
        }

        .quick-reply-list {
            position: absolute;
            bottom: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            max-height: 200px;
            overflow-y: auto;
            display: none;
            z-index: 10;
        }

        .quick-reply-list.show {
            display: block;
        }

        .quick-reply-item {
            padding: 10px 15px;
            cursor: pointer;
            border-bottom: 1px solid #f3f4f6;
            transition: background 0.3s;
        }

        .quick-reply-item:hover {
            background: #f9fafb;
        }

        .filters-sidebar {
            flex: 0 0 250px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-height: 600px;
            overflow-y: auto;
        }

        .filter-section {
            margin-bottom: 20px;
        }

        .filter-section h4 {
            font-size: 0.95rem;
            font-weight: 600;
            margin-bottom: 10px;
            color: #111827;
        }

        .filter-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px;
            cursor: pointer;
            border-radius: 6px;
            transition: background 0.3s;
        }

        .filter-item:hover {
            background: #f3f4f6;
        }

        .filter-item input[type="checkbox"] {
            cursor: pointer;
        }

        .stats-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px;
            border-radius: 6px;
            text-align: center;
            margin-bottom: 15px;
        }

        .stats-number {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .stats-label {
            font-size: 0.85rem;
            opacity: 0.9;
        }

        @media (max-width: 768px) {
            .messages-container {
                flex-direction: column;
            }

            .conversations-list {
                flex: 0 0 auto;
                max-height: 200px;
            }

            .chat-area {
                min-height: 400px;
            }

            .filters-sidebar {
                display: none;
            }

            .message {
                max-width: 90%;
            }
        }

        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #9ca3af;
            text-align: center;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
            opacity: 0.5;
        }
    </style>
</head>
<body>
    <div id="navbar-container"></div>

    <div class="messages-container">
        <!-- قائمة المحادثات -->
        <div class="conversations-list">
            <div class="conversation-search">
                <input type="text" id="conversationSearch" placeholder="ابحث عن محادثة...">
            </div>
            <div class="conversations" id="conversationsList">
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <p>لا توجد محادثات</p>
                </div>
            </div>
        </div>

        <!-- منطقة الدردشة -->
        <div class="chat-area">
            <div id="chatContent" style="display: none; display: flex; flex-direction: column; height: 100%;">
                <div class="chat-header">
                    <div class="chat-user-info">
                        <div class="conversation-avatar" id="chatAvatar">U</div>
                        <div>
                            <div class="conversation-name" id="chatUserName">اختر محادثة</div>
                            <small id="chatStatus" style="color: #9ca3af;"></small>
                        </div>
                    </div>
                    <div class="chat-header-actions">
                        <button onclick="pinCurrentMessage()" title="تثبيت">
                            <i class="fas fa-thumbtack"></i>
                        </button>
                        <button onclick="showQuickReplies()" title="رد سريع">
                            <i class="fas fa-bolt"></i>
                        </button>
                        <button onclick="blockUser()" title="حظر">
                            <i class="fas fa-ban"></i>
                        </button>
                    </div>
                </div>

                <div class="messages-list" id="messagesList"></div>

                <div class="chat-input-area">
                    <div class="chat-input-group">
                        <textarea class="chat-input" id="messageInput" placeholder="أكتب رسالتك هنا..." rows="3"></textarea>
                        <button onclick="sendMessage()" style="
                            padding: 12px 20px;
                            background: #1e40af;
                            color: white;
                            border: none;
                            border-radius: 6px;
                            cursor: pointer;
                            width: 50px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                        ">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div id="emptyChat" class="empty-state">
                <i class="fas fa-comments"></i>
                <p>اختر محادثة لبدء الدردشة</p>
            </div>
        </div>

        <!-- شريط الفلاتر والإحصائيات -->
        <div class="filters-sidebar">
            <div class="stats-box">
                <div class="stats-number" id="unreadCount">0</div>
                <div class="stats-label">رسائل غير مقروءة</div>
            </div>

            <div class="filter-section">
                <h4>الفلاتر</h4>
                <div class="filter-item">
                    <input type="checkbox" id="filterUnread" onchange="applyFilters()">
                    <label for="filterUnread">غير مقروءة فقط</label>
                </div>
                <div class="filter-item">
                    <input type="checkbox" id="filterImportant" onchange="applyFilters()">
                    <label for="filterImportant">مهمة فقط</label>
                </div>
                <div class="filter-item">
                    <input type="checkbox" id="filterArchived" onchange="applyFilters()">
                    <label for="filterArchived">الأرشيف</label>
                </div>
            </div>

            <div class="filter-section">
                <h4>الأنواع</h4>
                <div class="filter-item">
                    <input type="checkbox" id="filterJobRelated" onchange="applyFilters()">
                    <label for="filterJobRelated">متعلقة بوظيفة</label>
                </div>
                <div class="filter-item">
                    <input type="checkbox" id="filterApplicationRelated" onchange="applyFilters()">
                    <label for="filterApplicationRelated">متعلقة بطلب</label>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/api-client.js"></script>
    <script>
        let currentConversation = null;
        const api = new APIClient();

        async function loadConversations() {
            try {
                const response = await api.request('/php/api/messages.php?action=inbox');
                const conversations = response.data.messages;

                const list = document.getElementById('conversationsList');
                if (conversations.length === 0) {
                    list.innerHTML = '<div class="empty-state"><i class="fas fa-inbox"></i><p>لا توجد محادثات</p></div>';
                    return;
                }

                list.innerHTML = conversations.map(conv => `
                    <div class="conversation-item" onclick="selectConversation(${conv.sender_id}, '${conv.full_name}')">
                        <div class="conversation-user">
                            <div class="conversation-avatar">${conv.full_name.charAt(0)}</div>
                            <div class="conversation-info">
                                <div class="conversation-name">${conv.full_name}</div>
                                <div class="conversation-preview">${conv.message_body.substring(0, 30)}...</div>
                            </div>
                            ${conv.unread_count > 0 ? `<div class="unread-badge">${conv.unread_count}</div>` : ''}
                        </div>
                    </div>
                `).join('');
            } catch (error) {
                console.error('خطأ في تحميل المحادثات', error);
            }
        }

        async function selectConversation(userId, userName) {
            currentConversation = userId;
            document.getElementById('chatUserName').textContent = userName;
            document.getElementById('chatAvatar').textContent = userName.charAt(0);
            document.getElementById('emptyChat').style.display = 'none';
            document.getElementById('chatContent').style.display = 'flex';

            await loadMessages(userId);
            document.querySelector('.conversation-item.active')?.classList.remove('active');
            event.target.closest('.conversation-item').classList.add('active');
        }

        async function loadMessages(userId) {
            try {
                const response = await api.request(`/php/api/messages.php?action=conversation&user_id=${userId}`);
                const messages = response.data.messages;

                const list = document.getElementById('messagesList');
                list.innerHTML = messages.map(msg => `
                    <div class="message ${msg.sender_id === userId ? 'received' : 'sent'}">
                        <div>
                            <div class="message-content">
                                ${msg.message_body}
                            </div>
                            <div class="message-time">${formatTime(msg.created_at)}</div>
                        </div>
                        <div class="message-actions">
                            <button class="message-action-btn" onclick="pinMessage(${msg.id})" title="تثبيت">
                                <i class="fas fa-thumbtack"></i>
                            </button>
                            <button class="message-action-btn" onclick="archiveMessage(${msg.id})" title="أرشفة">
                                <i class="fas fa-archive"></i>
                            </button>
                        </div>
                    </div>
                `).join('');

                list.scrollTop = list.scrollHeight;
            } catch (error) {
                console.error('خطأ في تحميل الرسائل', error);
            }
        }

        async function sendMessage() {
            const text = document.getElementById('messageInput').value;
            if (!text.trim() || !currentConversation) return;

            try {
                const response = await api.request('/php/api/messages.php?action=send', {
                    method: 'POST',
                    body: JSON.stringify({
                        recipient_id: currentConversation,
                        message_body: text,
                        subject: 'رسالة'
                    })
                });

                document.getElementById('messageInput').value = '';
                await loadMessages(currentConversation);
            } catch (error) {
                console.error('خطأ في إرسال الرسالة', error);
            }
        }

        async function pinMessage(messageId) {
            try {
                await api.request('/php/api/messages.php?action=pin', {
                    method: 'POST',
                    body: JSON.stringify({ message_id: messageId })
                });
                alert('تم تثبيت الرسالة');
            } catch (error) {
                console.error('خطأ في تثبيت الرسالة', error);
            }
        }

        async function archiveMessage(messageId) {
            try {
                await api.request('/php/api/messages.php?action=archive', {
                    method: 'POST',
                    body: JSON.stringify({ message_id: messageId })
                });
                alert('تم أرشفة الرسالة');
            } catch (error) {
                console.error('خطأ في أرشفة الرسالة', error);
            }
        }

        async function blockUser() {
            if (!currentConversation) return;
            try {
                await api.request('/php/api/messages.php?action=block', {
                    method: 'POST',
                    body: JSON.stringify({ blocked_user_id: currentConversation })
                });
                alert('تم حظر المستخدم');
                currentConversation = null;
                await loadConversations();
            } catch (error) {
                console.error('خطأ في حظر المستخدم', error);
            }
        }

        function formatTime(dateString) {
            const date = new Date(dateString);
            return date.toLocaleTimeString('ar-SA', { hour: '2-digit', minute: '2-digit' });
        }

        function applyFilters() {
            // سيتم تنفيذ الفلاتر
        }

        async function loadStats() {
            try {
                const response = await api.request('/php/api/messages.php?action=stats');
                document.getElementById('unreadCount').textContent = response.data.unread_count || 0;
            } catch (error) {
                console.error('خطأ في تحميل الإحصائيات', error);
            }
        }

        // تحميل البيانات عند فتح الصفحة
        loadConversations();
        loadStats();

        // تحديث المحادثات كل 30 ثانية
        setInterval(() => {
            loadConversations();
            loadStats();
        }, 30000);
    </script>
    <div id="footer-container"></div>
    <script src="../js/navbar-footer-loader.js"></script>
</body>
</html>
