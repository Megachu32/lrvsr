<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile | Nexus</title>
    <style>
        /* --- CSS STYLES --- */
        :root {
            --primary-grad: linear-gradient(135deg, #00f2ff, #7000ff);
            --bg-color: #0a0a0a;
            --glass-bg: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(255, 255, 255, 0.1);
            --text-color: #ffffff;
            --text-muted: #aaaaaa;
            --accent-color: #00f2ff;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: var(--bg-color);
            /* Tech grid background */
            background-image: 
                linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 30px 30px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-color);
        }

        /* Main Profile Card */
        .profile-card {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            width: 800px;
            max-width: 90%;
            display: flex;
            overflow: hidden;
            box-shadow: 0 0 50px rgba(0, 0, 0, 0.5);
            flex-direction: row;
        }

        /* Left Sidebar: Avatar & Actions */
        .sidebar {
            width: 300px;
            padding: 40px;
            background: rgba(0,0,0,0.2);
            border-right: 1px solid var(--glass-border);
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: #222;
            border: 3px solid var(--accent-color);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            color: #555;
            box-shadow: 0 0 20px rgba(0, 242, 255, 0.3);
            /* Placeholder avatar image */
            background-image: url('https://api.dicebear.com/7.x/avataaars/svg?seed=Felix'); 
            background-size: cover;
        }

        .username {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
            letter-spacing: 1px;
        }

        .handle {
            color: var(--text-muted);
            font-size: 14px;
            margin-bottom: 20px;
        }

        .badge {
            background: var(--primary-grad);
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 30px;
            display: inline-block;
        }

        /* Stats Grid (Wins/Level) */
        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            width: 100%;
            margin-bottom: 30px;
        }

        .stat-box {
            background: rgba(255,255,255,0.05);
            padding: 10px;
            border-radius: 8px;
        }

        .stat-num {
            display: block;
            font-size: 18px;
            font-weight: bold;
            color: var(--accent-color);
        }

        .stat-label {
            font-size: 11px;
            color: var(--text-muted);
        }

        /* Button Styles */
        .btn {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
            margin-bottom: 10px;
        }

        .btn-primary {
            background: var(--accent-color);
            color: #000;
        }
        
        .btn-primary:hover {
            background: #fff;
            box-shadow: 0 0 15px var(--accent-color);
        }

        .btn-outline {
            background: transparent;
            border: 1px solid var(--glass-border);
            color: #fff;
        }

        .btn-outline:hover {
            border-color: var(--accent-color);
            color: var(--accent-color);
        }

        /* Right Content Area */
        .content {
            flex: 1;
            padding: 40px;
        }

        h3 {
            border-bottom: 1px solid var(--glass-border);
            padding-bottom: 10px;
            margin-top: 0;
            font-size: 18px;
            color: var(--accent-color);
            text-transform: uppercase;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .info-label { color: var(--text-muted); }
        .info-value { font-weight: bold; }

        /* Activity Feed */
        .activity-item {
            display: flex;
            align-items: center;
            background: rgba(255,255,255,0.03);
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 10px;
            transition: 0.2s;
        }

        .activity-item:hover {
            background: rgba(255,255,255,0.08);
            transform: translateX(5px);
        }

        .activity-icon {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #333;
            margin-right: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }

        .activity-text { font-size: 13px; color: #ddd; }
        .activity-time { font-size: 11px; color: #666; margin-left: auto; }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .profile-card { flex-direction: column; }
            .sidebar { width: auto; border-right: none; border-bottom: 1px solid var(--glass-border); }
        }

        /* Demo Toggle Button (Top Right) */
        .demo-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #333;
            padding: 10px;
            border-radius: 5px;
            font-size: 12px;
            cursor: pointer;
            border: 1px solid #555;
            color: white;
            z-index: 100;
        }
    </style>
</head>
<body>

<button class="demo-toggle" onclick="toggleView()">🔄 Switch View (Self / Other)</button>

<div class="profile-card">
    
    <div class="sidebar">
        <div class="avatar"></div>
        <h1 class="username">AlexRyder</h1>
        <div class="handle">@ryder_01</div>
        <div class="badge">PRO MEMBER</div>

        <div class="stats-grid">
            <div class="stat-box">
                <span class="stat-num">1.2k</span>
                <span class="stat-label">Wins</span>
            </div>
            <div class="stat-box">
                <span class="stat-num">45</span>
                <span class="stat-label">Level</span>
            </div>
        </div>

        <div id="self-actions">
            <button class="btn btn-primary">Edit Profile</button>
            <button class="btn btn-outline">Settings</button>
        </div>

        <div id="other-actions" style="display: none;">
            <button class="btn btn-primary">Follow User</button>
            <button class="btn btn-outline">Send Message</button>
        </div>
    </div>

    <div class="content">
        <h3>User Details</h3>
        <div class="info-row">
            <span class="info-label">Member Since</span>
            <span class="info-value">Jan 24, 2024</span>
        </div>
        <div class="info-row">
            <span class="info-label">Location</span>
            <span class="info-value">Cyber City, ND</span>
        </div>
        
        <div class="info-row" id="private-info">
            <span class="info-label">Email</span>
            <span class="info-value">alex@nexus.net</span>
        </div>

        <div class="info-row">
            <span class="info-label">Clan</span>
            <span class="info-value" style="color: #00f2ff">NeonStrikers</span>
        </div>

        <h3 style="margin-top: 30px;">Recent Activity</h3>
        
        <div class="activity-list">
            <div class="activity-item">
                <div class="activity-icon" style="background: #7000ff;">🏆</div>
                <div class="activity-text">Achieved <strong>Rank Gold I</strong> in Arena</div>
                <div class="activity-time">2h ago</div>
            </div>
            <div class="activity-item">
                <div class="activity-icon" style="background: #00f2ff; color: #000;">💬</div>
                <div class="activity-text">Commented on <strong>Update v2.4</strong></div>
                <div class="activity-time">5h ago</div>
            </div>
            <div class="activity-item">
                <div class="activity-icon" style="background: #333;">🛡️</div>
                <div class="activity-text">Joined clan <strong>NeonStrikers</strong></div>
                <div class="activity-time">1d ago</div>
            </div>
        </div>

    </div>
</div>

<script>
    // This script simulates switching between "My Profile" and "Their Profile"
    let isSelfView = true;

    function toggleView() {
        isSelfView = !isSelfView;
        const selfActions = document.getElementById('self-actions');
        const otherActions = document.getElementById('other-actions');
        const privateInfo = document.getElementById('private-info');

        if (isSelfView) {
            // Viewing own profile
            selfActions.style.display = 'block';
            otherActions.style.display = 'none';
            privateInfo.style.display = 'flex'; // Show private email
            alert("Now viewing as: OWNER (You can edit)");
        } else {
            // Viewing someone else
            selfActions.style.display = 'none';
            otherActions.style.display = 'block';
            privateInfo.style.display = 'none'; // Hide private email
            alert("Now viewing as: VISITOR (You can follow/message)");
        }
    }
</script>

</body>
</html>