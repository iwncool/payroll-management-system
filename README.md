body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #f4f7fb;
    color: #1f2937;
}

* {
    box-sizing: border-box;
}

.login-body {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #0f172a, #1e3a8a);
}

.login-box {
    width: 100%;
    max-width: 420px;
    background: #ffffff;
    border-radius: 14px;
    padding: 32px 28px;
    box-shadow: 0 18px 40px rgba(15, 23, 42, 0.28);
}

.login-box h1 {
    margin: 0 0 10px;
    text-align: center;
    color: #111827;
}

.subtitle {
    text-align: center;
    margin-bottom: 24px;
    color: #6b7280;
}

.field {
    margin-bottom: 18px;
}

.field label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
}

.field input {
    width: 100%;
    padding: 12px 14px;
    border-radius: 10px;
    border: 1px solid #d1d5db;
    font-size: 15px;
}

.btn {
    display: inline-block;
    border: none;
    border-radius: 10px;
    padding: 10px 18px;
    text-decoration: none;
    cursor: pointer;
    font-size: 14px;
    font-weight: 600;
    transition: 0.2s ease;
}

.btn:hover {
    opacity: 0.96;
}

.btn-primary {
    background: #2563eb;
    color: #fff;
}

.btn-secondary {
    background: #e5e7eb;
    color: #111827;
}

.btn-danger {
    background: #dc2626;
    color: #fff;
}

.btn-small {
    padding: 7px 12px;
    font-size: 12px;
}

.btn-block {
    width: 100%;
    padding: 12px 16px;
}

.alert {
    margin-bottom: 18px;
    padding: 12px 14px;
    border-radius: 10px;
    font-size: 14px;
}

.alert.success {
    background: #dcfce7;
    color: #166534;
    border: 1px solid #86efac;
}

.alert.error {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #fca5a5;
}

.login-hint {
    margin-top: 18px;
    font-size: 13px;
    color: #4b5563;
    text-align: center;
}

.layout {
    display: flex;
    min-height: 100vh;
}

.sidebar {
    width: 250px;
    background: #111827;
    color: #f9fafb;
    padding: 24px 16px;
}

.brand {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 28px;
    text-align: center;
}

.sidebar nav {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.sidebar nav a {
    text-decoration: none;
    color: #e5e7eb;
    padding: 12px 14px;
    border-radius: 10px;
    transition: 0.2s ease;
}

.sidebar nav a:hover,
.sidebar nav a.active {
    background: #1f2937;
    color: #fff;
}

.content {
    flex: 1;
    padding: 28px;
}

.topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 22px;
}

.topbar h1 {
    margin: 0;
    font-size: 32px;
}

.topbar p {
    margin: 6px 0 0;
    color: #6b7280;
}

.stats {
    display: grid;
    grid-template-columns: repeat(3, minmax(180px, 1fr));
    gap: 18px;
    margin-bottom: 24px;
}

.stat-card {
    background: #fff;
    border-radius: 14px;
    padding: 22px 18px;
    box-shadow: 0 8px 18px rgba(15, 23, 42, 0.08);
}

.stat-card span {
    display: block;
    margin-bottom: 8px;
    color: #6b7280;
}

.stat-card strong {
    font-size: 30px;
}

.stat-card.primary { border-left: 5px solid #2563eb; }
.stat-card.success { border-left: 5px solid #16a34a; }
.stat-card.warning { border-left: 5px solid #f59e0b; }

.panel {
    background: #fff;
    border-radius: 14px;
    padding: 22px;
    box-shadow: 0 8px 18px rgba(15, 23, 42, 0.08);
    margin-bottom: 22px;
}

.panel h2 {
    margin-top: 0;
}

.menu-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 18px;
}

.menu-item {
    display: block;
    text-decoration: none;
    background: #f8fafc;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 20px;
    color: #111827;
}

.menu-item h3 {
    margin-top: 0;
    margin-bottom: 8px;
}

.menu-item p {
    margin: 0;
    color: #4b5563;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(180px, 1fr));
    gap: 18px;
}

.form-grid.single {
    grid-template-columns: 1fr;
}

.form-grid label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
}

.form-grid input {
    width: 100%;
    padding: 11px 12px;
    border-radius: 10px;
    border: 1px solid #d1d5db;
    font-size: 14px;
}

.checkbox-wrap {
    display: flex;
    align-items: center;
    padding-top: 26px;
}

.checkbox-wrap label {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 500;
}

.checkbox-wrap input {
    width: 18px;
    height: 18px;
}

.form-actions {
    margin-top: 20px;
    display: flex;
    gap: 12px;
}

table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}

th, td {
    border-bottom: 1px solid #e5e7eb;
    padding: 12px 10px;
    text-align: left;
    vertical-align: top;
}

th {
    background: #f3f4f6;
}

.badge {
    display: inline-block;
    padding: 6px 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
}

.badge.success {
    background: #dcfce7;
    color: #166534;
}

.badge.pending {
    background: #fef3c7;
    color: #92400e;
}

.actions {
    display: flex;
    gap: 8px;
    align-items: center;
}

@media (max-width: 900px) {
    .layout {
        flex-direction: column;
    }

    .sidebar {
        width: 100%;
    }

    .stats,
    .form-grid {
        grid-template-columns: 1fr;
    }

    .topbar {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }
}
