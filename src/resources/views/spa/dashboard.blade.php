<!DOCTYPE html>
<html>
<head>
    <title>Dashboard SPA</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
    <h1>Bem-vindo ao Dashboard!</h1>
    <button id="logout">Logout</button>
    <script>
        document.getElementById('logout').addEventListener('click', async () => {
            try {
                const response = await axios.post('/api/logout');
                alert(response.data.message);
                window.location.href = '/login';
            } catch (error) {
                alert('Falha ao fazer logout');
            }
        });
    </script>
</body>
</html>
