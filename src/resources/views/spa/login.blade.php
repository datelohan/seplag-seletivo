<!DOCTYPE html>
<html>
<head>
    <title>Login SPA</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
    <h1>Login</h1>
    <form id="loginForm">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Senha" required>
        <button type="submit">Entrar</button>
    </form>
    <script>
        document.getElementById('loginForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            // Inicializar CSRF
            await axios.get('/sanctum/csrf-cookie');

            const formData = new FormData(e.target);
            const data = Object.fromEntries(formData);

            try {
                const response = await axios.post('/api/login', data);
                alert(response.data.message);
                window.location.href = '/dashboard';
            } catch (error) {
                alert('Login falhou');
            }
        });
    </script>
</body>
</html>
