<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
</head>
<body>
    <h1>Registro</h1>
    <form method="POST" action="/api/register">
        @csrf
        <input type="text" name="name" placeholder="Nome" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Senha" required>
        <button type="submit">Registrar</button>
    </form>
    <p>Já tem uma conta? <a href="/login">Faça login aqui</a>.</p>
</body>
<script>
        document.getElementById('registerForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            const response = await fetch('/api/register', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(Object.fromEntries(formData))
            });
            if (response.ok) {
                alert('Usuário registrado com sucesso');
                window.location.href = '/login';
            } else {
                alert('Registro falhou');
            }
        });
    </script>
</html>