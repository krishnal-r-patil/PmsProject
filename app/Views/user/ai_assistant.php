<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Gram-Sahayak Hub - E-Panchayat</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #6366f1;
            --dark: #0f172a;
            --light: #f8fafc;
        }
        * { margin:0; padding:0; box-sizing:border-box; font-family: 'Outfit', sans-serif; }
        body { background: var(--light); display: flex; height: 100vh; overflow: hidden; }
        
        .sidebar { z-index: 1000; }
        .main-content { flex: 1; display: flex; flex-direction: column; overflow: hidden; }
        
        .ultimate-container {
            flex: 1;
            max-width: 1200px;
            margin: 20px auto; /* Reduced margin */
            width: 95%;
            height: calc(100vh - 40px); /* Strictly lock height to viewport */
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            border-radius: 40px;
            box-shadow: 0 40px 100px -20px rgba(0, 0, 0, 0.15);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.5);
        }

        .ultimate-header {
            padding: 40px;
            background: linear-gradient(135deg, #1e293b, #0f172a);
            color: white;
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .avatar-glow {
            width: 80px;
            height: 80px;
            background: rgba(255,255,255,0.1);
            border-radius: 25px;
            padding: 5px;
            box-shadow: 0 0 30px rgba(99, 102, 241, 0.3);
            border: 2px solid rgba(255,255,255,0.2);
        }

        .chat-flow {
            flex: 1;
            padding: 40px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        /* CUSTOM PREMIUM SCROLLER */
        .chat-flow::-webkit-scrollbar { 
            width: 10px;
        }
        .chat-flow::-webkit-scrollbar-track { 
            background: rgba(0,0,0,0.02);
            border-radius: 10px;
        }
        .chat-flow::-webkit-scrollbar-thumb { 
            background: #cbd5e1; 
            border-radius: 20px; 
            border: 3px solid transparent;
            background-clip: content-box;
        }
        .chat-flow::-webkit-scrollbar-thumb:hover { 
            background: var(--primary); 
            border: 3px solid transparent;
            background-clip: content-box;
        }

        .bubble {
            max-width: 65%;
            padding: 20px 25px;
            border-radius: 28px;
            font-size: 1.1rem;
            line-height: 1.6;
            box-shadow: 0 4px 20px rgba(0,0,0,0.02);
            position: relative;
            animation: bubble_fade 0.4s ease-out;
        }

        @keyframes bubble_fade {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .bubble.bot {
            background: white;
            color: var(--dark);
            align-self: flex-start;
            border-bottom-left-radius: 5px;
            border: 1px solid #f1f5f9;
        }

        .bubble.user {
            background: var(--primary);
            color: white;
            align-self: flex-end;
            border-bottom-right-radius: 5px;
            box-shadow: 0 10px 30px rgba(99, 102, 241, 0.2);
        }

        .input-hub {
            padding: 40px;
            background: white;
            display: flex;
            gap: 20px;
            border-top: 1px solid #f1f5f9;
        }

        .ultra-input {
            flex: 1;
            padding: 20px 35px;
            border-radius: 100px;
            border: 2px solid #f1f5f9;
            font-size: 1.2rem;
            outline: none;
            transition: 0.3s;
        }
        .ultra-input:focus { border-color: var(--primary); background: #fdfdfd; box-shadow: 0 0 0 5px rgba(99, 102, 241, 0.1); }

        .big-send {
            width: 70px;
            height: 70px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 50%;
            font-size: 1.5rem;
            cursor: pointer;
            transition: 0.3s;
        }
        .big-send:hover { transform: scale(1.1) rotate(10deg); background: #4338ca; }

        .feature-chips {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        .chip-ultimate {
            background: #f1f5f9;
            padding: 12px 25px;
            border-radius: 100px;
            font-weight: 700;
            color: #475569;
            cursor: pointer;
            transition: 0.3s;
        }
        .chip-ultimate:hover { background: var(--primary); color: white; transform: translateY(-3px); }
    </style>
</head>
<body>
    <div class="sidebar"><?= view('user/partials/sidebar') ?></div>

    <div class="main-content">
        <div class="ultimate-container">
            <div class="ultimate-header">
                <div class="avatar-glow">
                     <img src="<?= str_replace('index.php', '', $_SERVER['SCRIPT_NAME']) ?>assets/img/ai_sahayak_avatar.png" style="width:100%; height:100%; object-fit:cover; border-radius:20px;" onerror="this.src='https://cdn-icons-png.flaticon.com/512/2593/2593635.png'">
                </div>
                <div>
                    <h2 style="font-weight: 800; font-size: 1.8rem; letter-spacing: -1px;">AI Gram-Sahayak Hub</h2>
                    <p style="opacity: 0.6;">Omniscient Village Intelligence Hub</p>
                </div>
                <div style="margin-left: auto;">
                    <div style="display: flex; align-items: center; gap: 10px; background: rgba(0,0,0,0.2); padding: 10px 20px; border-radius: 100px; font-size: 0.8rem; font-weight: 700;">
                        <span style="width:10px; height:10px; background:#10b981; border-radius:50%; box-shadow: 0 0 10px #10b981;"></span>
                        PROXIMITY SYNC ACTIVE
                    </div>
                </div>
            </div>

            <div class="chat-flow" id="main-flow-area">
                <div class="bubble bot">
                    Namaste **<?= esc($user_name) ?>**! 🙏 I have synchronized your citizen profile with the Entire Village Ecosystem.
                    <br><br>
                    I am the all-knowing brain of this Panchayat. Ask me about Marketplace, Taxes, Schemes, Projects or even Hospital phone numbers. How can I serve you?
                </div>
            </div>

            <div style="padding: 0 40px;">
                <div class="feature-chips">
                    <div class="chip-ultimate" onclick="ultimateSend('Show schemes matching my profile')">🎯 My Schemes</div>
                    <div class="chip-ultimate" onclick="ultimateSend('Check my tax dues')">💸 Tax Check</div>
                    <div class="chip-ultimate" onclick="ultimateSend('Show latest mandi rates')">🌾 Mandi Price</div>
                </div>
            </div>

            <div class="input-hub">
                <input type="text" id="ultra-input-fld" class="ultra-input" placeholder="Ask Gram-Sahayak anything..." onkeypress="if(event.key==='Enter') ultimateSend()">
                <button class="big-send" onclick="ultimateSend()">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>

    <script>
        let ultimateCSRF = '<?= csrf_hash() ?>';
        const csrfName = '<?= csrf_token() ?>';

        function ultimateSend(txt = null) {
            const input = document.getElementById('ultra-input-fld');
            const val = txt || input.value.trim();
            if(!val) return;

            appendUltMsg(val, 'user');
            input.value = '';

            fetch('<?= base_url('ai-assistant/neural-hub') ?>', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': ultimateCSRF
                },
                body: JSON.stringify({
                    message: val
                })
            })
            .then(res => res.json())
            .then(data => {
                if(data.token) ultimateCSRF = data.token; // IMPORTANT: UPDATE CSRF
                if(data.status === 'success') {
                    appendUltMsg(data.reply, 'bot');
                    if(data.rich_card) appendUltRichCard(data.rich_card);
                } else {
                    appendUltMsg("I encountered a synchronization lag. Please refresh or try again. (संपर्क का अभाव)", 'bot');
                }
            })
            .catch(e => {
                appendUltMsg("Internal System Sync Error. Please check your connectivity.", 'bot');
            });
        }

        function appendUltMsg(text, side) {
            const area = document.getElementById('main-flow-area');
            const div = document.createElement('div');
            div.className = `bubble ${side}`;
            div.innerHTML = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
            area.appendChild(div);
            // Smoothly glide to bottom
            setTimeout(() => {
                area.scrollTo({ top: area.scrollHeight, behavior: 'smooth' });
            }, 50);
        }

        function appendUltRichCard(card) {
            const area = document.getElementById('main-flow-area');
            const div = document.createElement('div');
            div.style.cssText = "background: white; border-radius: 30px; padding: 30px; border: 2px solid #eef2ff; margin: 20px 0; max-width: 60%; box-shadow: 0 20px 50px rgba(0,0,0,0.05); animation: bubble_fade 0.5s ease-out;";
            div.innerHTML = `
                <h3 style="color: #6366f1; margin-bottom: 5px;">${card.title}</h3>
                <p style="font-size: 1rem; color: #64748b; margin-bottom: 20px; line-height: 1.6;">${card.body}</p>
                <div style="background: #f8fafc; padding: 15px; border-radius: 15px; margin-bottom: 20px; font-weight: 700;">
                    Benefit: ${card.benefit}
                </div>
                <a href="${card.url}" style="display:inline-block; background: #6366f1; color: white; padding: 12px 30px; border-radius: 100px; text-decoration: none; font-weight: 700; transition: 0.3s;">Explore & Apply</a>
            `;
            area.appendChild(div);
             setTimeout(() => {
                area.scrollTo({ top: area.scrollHeight, behavior: 'smooth' });
            }, 50);
        }
    </script>
</body>
</html>
