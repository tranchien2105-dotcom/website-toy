<template>
    <div class="auth-layout">

        <div class="content">
            <router-view />
        </div>

    </div>
</template>

<style scoped>
.auth-layout {
    height: 100vh;
    background: #f3f4f6;
    display: flex;
    flex-direction: column; /* 🔥 quan trọng */
    align-items: center;
    justify-content: center;
}

.title {
    margin-bottom: 20px;
}

.content {
    width: 100%;
    display: flex;
    justify-content: center;
}
</style>