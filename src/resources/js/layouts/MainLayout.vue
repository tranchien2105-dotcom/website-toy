<template>
    <div class="layout">

        <aside class="sidebar">

            <h2>Dashboard</h2>

            <nav>
                <router-link to="/home">Home</router-link>
                <router-link to="/products">Products</router-link>
                <router-link to="/products/create">Create</router-link>
            </nav>

        </aside>

        <main class="content">
            <router-view />
        </main>

    </div>
</template>
<style scoped>
.layout {
    display: flex;
    min-height: 100vh;
    background: #f1f5f9;
    font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
}

/* =======================
   SIDEBAR
======================= */
.sidebar {
    width: 260px;
    background: #0f172a;
    color: white;
    padding: 24px;
    display: flex;
    flex-direction: column;
    gap: 20px;
    position: sticky;
    top: 0;
    height: 100vh;
}

.sidebar h2 {
    font-size: 22px;
    font-weight: 700;
    color: #38bdf8;
    margin-bottom: 10px;
}

/* NAV LINKS */
.sidebar nav {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.sidebar a {
    text-decoration: none;
    color: #cbd5e1;
    padding: 12px 14px;
    border-radius: 10px;
    transition: all 0.2s ease;
    font-weight: 500;
}

.sidebar a:hover {
    background: #1e293b;
    color: #fff;
    transform: translateX(4px);
}

/* ACTIVE LINK */
.router-link-active {
    background: #3b82f6;
    color: white !important;
    font-weight: 600;
}

/* =======================
   MAIN CONTENT
======================= */
.content {
    flex: 1;
    padding: 30px;
}

/* CARD STYLE (optional wrapper cho page) */
.content>* {
    background: white;
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
}

/* =======================
   RESPONSIVE
======================= */
@media (max-width: 768px) {
    .layout {
        flex-direction: column;
    }

    .sidebar {
        width: 100%;
        height: auto;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
    }

    .sidebar nav {
        flex-direction: row;
    }

    .content {
        padding: 15px;
    }
}
</style>