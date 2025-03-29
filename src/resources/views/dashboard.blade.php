<!-- filepath: c:\Users\ASUS16X\OneDrive\Documentos\api-seplag\application\resources\views\dashboard.blade.php -->
<!-- ...existing code... -->
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h1>Bem-vindo ao Dashboard!</h1>
    <form method="POST" action="/api/logout">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
    <script>
        document.getElementById('logout').addEventListener('click', async () => {
            const token = localStorage.getItem('token');
            const response = await fetch('/api/logout', {
                method: 'POST',
                headers: { 'Authorization': `Bearer ${token}` }
            });
            if (response.ok) {
                localStorage.removeItem('token');
                window.location.href = '/login';
            } else {
                alert('Falha ao fazer logout');
            }
        });
    </script>
<!-- ...existing code... -->