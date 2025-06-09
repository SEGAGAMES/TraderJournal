<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
</head>
<body>
    <div class="auth-container">
        <div class="auth-header">
            <h1>Создайте аккаунт</h1>
        </div>
        
        <form class="auth-form" action="" method="POST" id="register">
            <div class="form-group">
                <label for="username">Имя пользователя</label>
                <input type="text" id="username" name="username" required>
                <div class="focus-border"></div>
            </div>
            
            <div class="form-group">
                <label for="password">Пароль</label>
                <input type="password" id="password" name="password" required>
                <div class="focus-border"></div>
            </div>

            <div class="form-group">
                <label for="e-mail">e-mail</label>
                <input type="email" id="e-mail">
                <div class="focus-border"></div>
            </div>

            <div class="form-group">
                <label for="surname">Фамилия</label>
                <input type="text" id="surname" name='last' required>
                <div class="focus-border"></div>
            </div>

            <div class="form-group">
                <label for="name">Имя</label>
                <input type="text" id="name" name='name' required>
                <div class="focus-border"></div>
            </div>

            <div class="form-group">
                <label for="lastname">Отчество</label>
                <input type="text" id="lastname" name='sur' required>
                <div class="focus-border"></div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn-submit">Зарегистрироваться</button>
            </div>
        </form>
        
        <div class="auth-footer">
            <p>Уже есть аккаут? <a href="mainPage.php">Войти</a></p>
        </div>
    </div>
</body>
</html>

<!-- Регистрация пользователя -->
<script>
    document.getElementById('register').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch("../../api/user/create.php",
            {
                method: 'POST',
                body: formData
            })
            .then(response =>
            {
                fetch("../../api/trader/create.php",
                {
                    method: 'POST',
                    body: formData
                })
                .then(response =>
                {
                    if (response.status == 201)
                        location.href="mainPage.php";
                    else
                        if (response.status == 409)
                            alert('Ошибка регистрации! Такой пользователь уже существует');
                        else
                            alert('Некорректный запрос! Попробуйте убрать спецсимволы!');
                })
                .catch(error =>
                {
                    alert('Ошибка сети: ' + error.message);
                });
            })
            .catch(error =>
            {
                alert('Ошибка сети: ' + error.message);
            });
        });
</script>

<!-- Стили. -->
<style>
    /* Основные стили */
    :root {
        --primary: #7dd3fc;
        --primary-dark: #0ea5e9;
        --bg: #0f172a;
        --bg-light: #1e293b;
        --text: #e2e8f0;
        --text-secondary: #94a3b8;
        --positive: #4ade80;
        --negative: #f87171;
        --border: rgba(148, 163, 184, 0.3);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        background-color: var(--bg);
        color: var(--text);
        line-height: 1.7;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 2rem;
        background-image: 
            radial-gradient(circle at 25% 25%, rgba(14, 165, 233, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 75% 75%, rgba(124, 58, 237, 0.1) 0%, transparent 50%);
    }

    /* Стили формы */
    .auth-container {
        width: 100%;
        max-width: 420px;
        background: rgba(15, 23, 42, 0.8);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 2.5rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        border: 1px solid var(--border);
        animation: fadeIn 0.5s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .auth-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .auth-header h1 {
        color: var(--primary);
        font-size: 2rem;
        margin-bottom: 0.5rem;
        text-shadow: 0 0 10px rgba(125, 211, 252, 0.3);
    }

    .auth-header p {
        color: var(--text-secondary);
        font-size: 0.95rem;
    }

    .auth-form {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .form-group {
        position: relative;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: var(--text-secondary);
        font-size: 0.95rem;
    }

    .form-group input {
        width: 100%;
        padding: 0.9rem 1.2rem;
        background: rgba(30, 41, 59, 0.7);
        border: 1px solid var(--border);
        border-radius: 8px;
        color: var(--text);
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-group input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(125, 211, 252, 0.2);
    }

    .form-actions {
        margin-top: 0.5rem;
    }

    .btn-submit {
        width: 100%;
        padding: 1rem;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: #082f49;
        font-weight: 600;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .btn-submit:hover {
        background: linear-gradient(135deg, var(--primary-dark) 0%, #0369a1 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);
    }

    .auth-footer {
        margin-top: 1.5rem;
        text-align: center;
        font-size: 0.9rem;
        color: var(--text-secondary);
    }

    .auth-footer a {
        color: var(--primary);
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .auth-footer a:hover {
        text-decoration: underline;
        text-shadow: 0 0 8px rgba(125, 211, 252, 0.4);
    }

    /* Эффекты */
    .form-group input:focus + .focus-border {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 2px;
        background: var(--primary);
        animation: inputFocus 0.4s forwards;
    }

    @keyframes inputFocus {
        from { transform: scaleX(0); }
        to { transform: scaleX(1); }
    }

    /* Адаптивность */
    @media (max-width: 480px) {
        .auth-container {
            padding: 1.5rem;
        }
            
        .auth-header h1 {
            font-size: 1.8rem;
        }
    }
</style>

