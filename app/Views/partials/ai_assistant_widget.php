<!-- AI Gram-Sahayak: The ULTIMATE Virtual Assistant -->
<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap');

    #ult-sahayak-widget {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 9999999 !important; /* Absolute top priority */
        font-family: 'Outfit', sans-serif;
        --sahayak-accent: #6366f1;
        --sahayak-accent-dark: #4338ca;
    }

    /* BREATHING TRIGGER */
    #ult-sahayak-trigger {
        width: 72px;
        height: 72px;
        background: linear-gradient(135deg, var(--sahayak-accent), #818cf8);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 15px 35px rgba(99, 102, 241, 0.4);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 4px solid white;
        position: relative;
        animation: sahayak_breathe 3s infinite ease-in-out;
    }

    @keyframes sahayak_breathe {
        0% { transform: scale(1); box-shadow: 0 15px 35px rgba(99, 102, 241, 0.4); }
        50% { transform: scale(1.08); box-shadow: 0 20px 45px rgba(99, 102, 241, 0.5); }
        100% { transform: scale(1); box-shadow: 0 15px 35px rgba(99, 102, 241, 0.4); }
    }

    #ult-sahayak-trigger:hover {
        transform: scale(1.15) rotate(15deg) !important;
        animation: none;
    }

    #ult-sahayak-trigger img {
        width: 45px;
        height: 45px;
        border-radius: 50%;
    }

    /* ONLINE STATUS */
    .online-badge {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 18px;
        height: 18px;
        background: #10b981;
        border: 3px solid white;
        border-radius: 50%;
        box-shadow: 0 0 10px #10b981;
    }

    /* CHAT PANEL: GLASSMORPHISM & RESPONSIVE HEIGHT */
    #ult-sahayak-panel {
        width: 420px;
        height: 75vh; /* Responsive height to avoid screen cutoff */
        max-height: 650px; /* Maximum height cap */
        min-height: 400px;
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(25px);
        -webkit-backdrop-filter: blur(25px);
        border-radius: 35px;
        position: absolute;
        bottom: 95px;
        right: 0;
        display: none;
        flex-direction: column;
        box-shadow: 0 30px 100px -20px rgba(0,0,0,0.25);
        border: 1px solid rgba(255,255,255,0.6);
        overflow: hidden; /* Prevent child bleed-out */
        animation: sahayak_pop 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
        transform-origin: bottom right;
    }

    @keyframes sahayak_pop {
        from { transform: scale(0.7) translateY(50px); opacity: 0; }
        to { transform: scale(1) translateY(0); opacity: 1; }
    }

    /* HEADER: PREMIUM DARK */
    .sahayak-top {
        padding: 30px;
        background: linear-gradient(135deg, #1e293b, #0f172a);
        color: white;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .sahayak-top h3 { margin: 0; font-size: 1.25rem; font-weight: 800; letter-spacing: -0.5px; }
    .sahayak-top p { margin: 0; font-size: 0.8rem; opacity: 0.6; }

    /* MESSAGES AREA */
    #sahayak-chat-flow {
        flex: 1;
        padding: 25px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 15px;
        background: radial-gradient(circle at 10% 20%, rgba(239, 246, 255, 0.5) 0%, rgba(255, 255, 255, 0) 90%);
        scrollbar-width: thin;
        scrollbar-color: #e2e8f0 transparent;
    }

    #sahayak-chat-flow::-webkit-scrollbar { 
        width: 8px; /* Increased from 5px for better visibility */
    }
    #sahayak-chat-flow::-webkit-scrollbar-track { 
        background: rgba(0,0,0,0.02); 
    }
    #sahayak-chat-flow::-webkit-scrollbar-thumb { 
        background: #cbd5e1; 
        border-radius: 20px; 
        border: 2px solid transparent;
        background-clip: content-box;
    }
    #sahayak-chat-flow::-webkit-scrollbar-thumb:hover { 
        background: #94a3b8; 
        border: 2px solid transparent;
        background-clip: content-box;
    }

    .msg-box {
        max-width: 85%;
        padding: 16px 20px;
        border-radius: 22px;
        font-size: 0.98rem;
        line-height: 1.5;
        position: relative;
    }

    .msg-bot {
        background: white;
        color: #1e293b;
        align-self: flex-start;
        border-bottom-left-radius: 4px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid #f1f5f9;
    }

    .msg-user {
        background: var(--sahayak-accent);
        color: white;
        align-self: flex-end;
        border-bottom-right-radius: 4px;
        box-shadow: 0 10px 20px -5px rgba(99, 102, 241, 0.3);
    }

    /* RICH SCHEME CARDS */
    .scheme-card-alt {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        border: 2px solid #eef2ff;
        margin-top: 10px;
        box-shadow: 0 10px 30px rgba(99, 102, 241, 0.1);
    }
    .card-alt-header { padding: 15px; background: #f5f3ff; font-weight: 800; color: #5b21b6; font-size: 0.9rem; }
    .card-alt-body { padding: 15px; font-size: 0.85rem; color: #475569; }
    .card-alt-btn { display: block; width: 100%; padding: 12px; background: #6366f1; color: white; text-align: center; text-decoration: none; font-weight: 700; font-size: 0.85rem; }

    /* FOOTER & INPUT */
    .sahayak-input-wrap {
        padding: 25px;
        background: white;
        border-top: 1px solid #f1f5f9;
        display: flex;
        gap: 12px;
        align-items: center;
    }

    #sahayak-input-field {
        flex: 1;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        padding: 14px 22px;
        border-radius: 100px;
        outline: none;
        font-size: 1rem;
        transition: 0.3s;
    }
    #sahayak-input-field:focus { border-color: var(--sahayak-accent); background: white; box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1); }

    .sahayak-action-btn {
        width: 52px;
        height: 52px;
        background: var(--sahayak-accent);
        color: white;
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        cursor: pointer;
        transition: 0.3s;
    }
    .sahayak-action-btn:hover { background: var(--sahayak-accent-dark); transform: scale(1.1) rotate(10deg); }

    .chip-tray { display: flex; gap: 10px; overflow-x: auto; padding: 0 25px 15px 25px; background: white; scrollbar-width: none; }
    .chip-tray::-webkit-scrollbar { display: none; }
    .sahayak-chip { padding: 8px 18px; background: #f1f5f9; border-radius: 100px; font-size: 0.8rem; font-weight: 700; color: #475569; white-space: nowrap; cursor: pointer; transition: 0.3s; }
    .sahayak-chip:hover { background: var(--sahayak-accent); color: white; transform: translateY(-2px); }

    /* TYPING DOTS */
    .typing-dots { display: flex; gap: 4px; padding: 10px; }
    .typing-dots span { width: 8px; height: 8px; background: #cbd5e1; border-radius: 50%; animation: sahayak_dots 1.5s infinite; }
    .typing-dots span:nth-child(2) { animation-delay: 0.2s; }
    .typing-dots span:nth-child(3) { animation-delay: 0.4s; }
    @keyframes sahayak_dots { 0%, 100% { opacity: 0.3; transform: scale(0.8); } 50% { opacity: 1; transform: scale(1.1); } }
</style>

<div id="ult-sahayak-widget">
    <!-- Chat Panel -->
    <div id="ult-sahayak-panel">
        <div class="sahayak-top">
            <div style="position: relative;">
                <img src="<?= str_replace('index.php', '', $_SERVER['SCRIPT_NAME']) ?>assets/img/ai_sahayak_avatar.png" 
                     style="width: 55px; height: 55px; border-radius: 15px; border: 2px solid rgba(255,255,255,0.2); object-fit: cover;" 
                     onerror="this.src='https://cdn-icons-png.flaticon.com/512/2593/2593635.png'">
                <div class="online-badge" style="bottom: -2px; right: -2px; width: 14px; height: 14px;"></div>
            </div>
            <div>
                <h3>Gram-Sahayak AI</h3>
                <p>Advanced Public Service Intelligence</p>
            </div>
            <div style="margin-left: auto; cursor: pointer;" onclick="toggleUltSahayak()">
                <i class="fas fa-chevron-down" style="opacity: 0.5;"></i>
            </div>
        </div>

        <div id="sahayak-chat-flow">
            <div class="msg-box msg-bot">
                Namaste! 🙏 I am your **Omiscient Gram-Sahayak**. I have been fully trained on **EVERY** module of this PMS.
            </div>
            <div class="msg-box msg-bot">
                I can help with **Marketplace, Notices, E-Learning, GIS Maps, Permits, Utilities, Taxes, Staff, Grievances, Schemes, Polls, and Meetings**. What do you need?
            </div>
        </div>

        <div id="sahayak-typing-ui" style="display: none; padding-left: 25px;">
            <div class="typing-dots"><span></span><span></span><span></span></div>
        </div>

        <div class="chip-tray" id="sahayak-chip-tray">
            <div class="sahayak-chip" onclick="ultSahayakSend('Find schemes for me')">🌾 Search Schemes</div>
            <div class="sahayak-chip" onclick="ultSahayakSend('My tax balance')">💰 Tax Dues</div>
            <div class="sahayak-chip" onclick="ultSahayakSend('Need a certificate')">📄 Certificates</div>
        </div>

        <div class="sahayak-input-wrap">
            <input type="text" id="sahayak-input-field" placeholder="Ask anything in English or Hindi..." onkeypress="if(event.key==='Enter') ultSahayakSend()">
            <button class="sahayak-action-btn" onclick="ultSahayakSend()">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>

    <!-- Main Trigger -->
    <div id="ult-sahayak-trigger-wrap" style="position: fixed; bottom: 30px; right: 30px; z-index: 9999999;">
        <div id="ult-sahayak-trigger" onclick="toggleUltSahayak()">
            <img src="<?= str_replace('index.php', '', $_SERVER['SCRIPT_NAME']) ?>assets/img/ai_sahayak_avatar.png" onerror="this.src='https://cdn-icons-png.flaticon.com/512/2593/2593635.png'">
            <div class="online-badge"></div>
        </div>
        <!-- Dismiss Button -->
        <div onclick="dismissSahayakPermanently()" style="position: absolute; top: -10px; right: -10px; width: 24px; height: 24px; background: #ef4444; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 10px; cursor: pointer; border: 2px solid white; box-shadow: 0 4px 10px rgba(0,0,0,0.1); z-index: 10;">
            <i class="fas fa-times"></i>
        </div>
    </div>
</div>

<script>
    // PRE-CHECK: If user dismissed the bot, hide it immediately
    if(localStorage.getItem('sahayak_dismissed') === 'true') {
        document.getElementById('ult-sahayak-widget').style.display = 'none';
    }

    function dismissSahayakPermanently() {
        if(confirm("Would you like to hide the AI Assistant for this session? You can always access it via the 'AI Gram-Sahayak' menu.")) {
            localStorage.setItem('sahayak_dismissed', 'true');
            document.getElementById('ult-sahayak-widget').style.opacity = '0';
            setTimeout(() => {
                document.getElementById('ult-sahayak-widget').style.display = 'none';
            }, 500);
        }
    }

    // UNSTOPPABLE CONNECTIVITY: Using consistent base_url
    const SAHAYAK_CONFIG = {
        api_url: '<?= base_url('ai-assistant/neural-hub') ?>',
        csrf_name: '<?= csrf_token() ?>',
        csrf_hash: '<?= csrf_hash() ?>'
    };

    function toggleUltSahayak() {
        const panel = document.getElementById('ult-sahayak-panel');
        const isVisible = panel.style.display === 'flex';
        panel.style.display = isVisible ? 'none' : 'flex';
        
        if(!isVisible) {
            document.getElementById('sahayak-input-field').focus();
            const flow = document.getElementById('sahayak-chat-flow');
            flow.scrollTop = flow.scrollHeight;
        }
    }

    // Auto-engage after 5 seconds to show it's "real"
    setTimeout(() => {
        const trigger = document.getElementById('ult-sahayak-trigger');
        trigger.style.animation = 'sahayak_breathe 1s 3 ease-in-out';
    }, 5000);

    function ultSahayakSend(manualText = null) {
        const input = document.getElementById('sahayak-input-field');
        const message = manualText || input.value.trim();
        if(!message) return;

        appendSahayakItem(message, 'user');
        input.value = '';

        const typing = document.getElementById('sahayak-typing-ui');
        typing.style.display = 'block';
        const flow = document.getElementById('sahayak-chat-flow');
        flow.scrollTop = flow.scrollHeight;

        // AJAX CALL WITH ROBUST ERROR HANDLING
        fetch(SAHAYAK_CONFIG.api_url, {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json', 
                'Accept': 'application/json',
                'X-CSRF-TOKEN': SAHAYAK_CONFIG.csrf_hash
            },
            body: JSON.stringify({
                message: message
            })
        })
        .then(async response => {
            if (!response.ok) {
                const errData = await response.text();
                throw new Error('Sync Error: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            typing.style.display = 'none';
            if(data.status === 'success') {
                SAHAYAK_CONFIG.csrf_hash = data.token; // IMPORTANT: UPDATE CSRF
                appendSahayakItem(data.reply, 'bot');
                
                if(data.rich_card) appendSahayakRichCard(data.rich_card);
                if(data.suggestions) updateSahayakChips(data.suggestions);
            }
        })
        .catch(error => {
            console.error('Sahayak Error:', error);
            typing.style.display = 'none';
            appendSahayakItem("Apologies, my link to the central registry is momentarily disrupted. Please try again or check your internet. (संपर्क टूट गया है, पुनः प्रयास करें)", 'bot');
        });
    }

    function appendSahayakItem(text, side) {
        const flow = document.getElementById('sahayak-chat-flow');
        const div = document.createElement('div');
        div.className = `msg-box msg-${side}`;
        // Smart Markdown + Smooth Fade
        div.style.opacity = '0';
        div.innerHTML = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
        flow.appendChild(div);
        
        // Trigger reflow for animation
        setTimeout(() => { 
            div.style.transition = 'opacity 0.3s ease';
            div.style.opacity = '1';
            flow.scrollTo({ top: flow.scrollHeight, behavior: 'smooth' });
        }, 50);
    }

    function appendSahayakRichCard(card) {
        const flow = document.getElementById('sahayak-chat-flow');
        const div = document.createElement('div');
        div.className = 'scheme-card-alt';
        div.style.opacity = '0';
        div.innerHTML = `
            <div class="card-alt-header"><i class="fas fa-award"></i> Eligible: ${card.title}</div>
            <div class="card-alt-body">
                ${card.body}<br><br>
                <div style="background:#f1f5f9; padding:10px; border-radius:10px; font-weight:700; color:#1e293b;">
                   Benefit: ${card.benefit}
                </div>
            </div>
            <a href="${card.url}" class="card-alt-btn">Apply Now</a>
        `;
        flow.appendChild(div);
        setTimeout(() => { 
            div.style.transition = 'opacity 0.4s ease';
            div.style.opacity = '1';
            flow.scrollTo({ top: flow.scrollHeight, behavior: 'smooth' });
        }, 100);
    }

    function updateSahayakChips(chips) {
        const tray = document.getElementById('sahayak-chip-tray');
        if(!chips || chips.length === 0) return;
        tray.innerHTML = '';
        chips.forEach(c => {
            const chip = document.createElement('div');
            chip.className = 'sahayak-chip';
            chip.innerText = c;
            chip.onclick = () => ultSahayakSend(c);
            tray.appendChild(chip);
        });
    }
</script>
