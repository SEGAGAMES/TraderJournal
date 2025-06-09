<?php
    function MakeHeader($window)
    {
        if (include_once "../../api/auth/check.php")
        {?> 
            <!DOCTYPE html>
            <html lang="ru">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>QuantumTrade</title>
                <link rel="stylesheet" href="../data/StyleSheet2.css">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
            </head>
            <body>
                <div class="container">
                    <!-- Шапка сайта -->
                    <header class="header">
                        <div class="logo">
                            <a href="mainPage.php" class="logo-link">
                                <h1><i class="fas fa-chart-line"></i> QuantumTrade</h1>
                                <p>Алгоритмический трейдинг нового поколения</p>
                            </a>
                        </div>
                        <div class="logout-btn">
                            <a href="../../api/auth/logout.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Выход</a>
                        </div>
                    </header>
                    <!-- Основное содержимое -->
            <?php
            if ($_SESSION['priority']>7)
            {
                if ($window != 'deal')
                {?>
                <div class="main-content">
                    <aside class="sidebar">
                        <nav>
                            <ul id='addHere'>
                                <li><a href="mainPage.php"><i class="fas fa-home"></i> Главная</a></li>
                                <li><a href="deals.php"><i class="fas fa-exchange-alt"></i> Сделки</a></li>
                                <li><a href="tickers.php"><i class="fas fa-chart-line label-icon"></i> Тикеры</a></li>
                                <li><a href="traders.php"><i class="fas fa-user-tie label-icon"></i> Трейдеры</a></li>
                                <li><a href="history.php"><i class="fas fa-history"></i> История</a></li>
                                <li><a href="admin.php"><i class="fas fa-user-cog"></i> Панель администраторы</a></li>
                            </ul>
                        </nav>
                    </aside>
                <?}
                else
                {?>
                    <div class="main-content">
                    <aside class="sidebar">
                        <nav>
                            <ul id='addHere'>
                                <li><a href="../nav/mainPage.php"><i class="fas fa-home"></i> Главная</a></li>
                                <li><a href="../nav/deals.php"><i class="fas fa-exchange-alt"></i> Сделки</a></li>
                                <li><a href="../nav/tickers.php"><i class="fas fa-chart-line label-icon"></i> Тикеры</a></li>
                                <li><a href="../nav/traders.php"><i class="fas fa-user-tie label-icon"></i> Трейдеры</a></li>
                                <li><a href="../nav/history.php"><i class="fas fa-history"></i> История</a></li>
                                <li><a href="../nav/admin.php"><i class="fas fa-user-cog"></i> Панель администраторы</a></li>
                            </ul>
                        </nav>
                    </aside>
                <?}
            }
            else
            {
                switch ($window)
                {
                    case "main": ?>
                        <div class="main-content">
                            <!-- Левая панель навигации -->
                            <aside class="sidebar">
                                <nav>
                                    <ul id='addHere'>
                                        <li class="active"><a href="mainPage.php"><i class="fas fa-home"></i> Главная</a></li>
                                        <li><a href="deals.php"><i class="fas fa-exchange-alt"></i> Сделки</a></li>
                                        <li><a href="tickers.php"><i class="fas fa-chart-line label-icon"></i> Тикеры</a></li>
                                        <li><a href="traders.php"><i class="fas fa-user-tie label-icon"></i> Трейдеры</a></li>
                                        <li><a href="history.php"><i class="fas fa-history"></i> История</a></li>
                                    </ul>
                                </nav>
                            </aside>
                        <?php break;
                    case "deals": ?>
                        <div class="main-content">
                            <!-- Левая панель навигации -->
                            <aside class="sidebar">
                                <nav>
                                    <ul id='addHere'>
                                        <li><a href="mainPage.php"><i class="fas fa-home"></i> Главная</a></li>
                                        <li  class="active"><a href="deals.php"><i class="fas fa-exchange-alt"></i> Сделки</a></li>
                                        <li><a href="tickers.php"><i class="fas fa-chart-line label-icon"></i> Тикеры</a></li>
                                        <li><a href="traders.php"><i class="fas fa-user-tie label-icon"></i> Трейдеры</a></li>
                                        <li><a href="history.php"><i class="fas fa-history"></i> История</a></li>
                                    </ul>
                                </nav>
                            </aside>
                        <?php break;
                    case "tickers": ?>
                        <div class="main-content">
                            <!-- Левая панель навигации -->
                            <aside class="sidebar">
                                <nav>
                                    <ul id='addHere'>
                                        <li><a href="mainPage.php"><i class="fas fa-home"></i> Главная</a></li>
                                        <li><a href="deals.php"><i class="fas fa-exchange-alt"></i> Сделки</a></li>
                                        <li class="active"><a href="tickers.php"><i class="fas fa-chart-line label-icon"></i> Тикеры</a></li>
                                        <li><a href="traders.php"><i class="fas fa-user-tie label-icon"></i> Трейдеры</a></li>
                                        <li><a href="history.php"><i class="fas fa-history"></i> История</a></li>
                                    </ul>
                                </nav>
                            </aside>
                        <?php break;
                    case "traders": ?>
                        <div class="main-content">
                            <!-- Левая панель навигации -->
                            <aside class="sidebar">
                                <nav>
                                    <ul id='addHere'>
                                        <li><a href="mainPage.php"><i class="fas fa-home"></i> Главная</a></li>
                                        <li><a href="deals.php"><i class="fas fa-exchange-alt"></i> Сделки</a></li>
                                        <li><a href="tickers.php"><i class="fas fa-chart-line label-icon"></i> Тикеры</a></li>
                                        <li class="active"><a href="traders.php"><i class="fas fa-user-tie label-icon"></i> Трейдеры</a></li>
                                        <li><a href="history.php"><i class="fas fa-history"></i> История</a></li>
                                    </ul>
                                </nav>
                            </aside>
                        <?php break;
                    case "history": ?>
                        <div class="main-content">
                            <!-- Левая панель навигации -->
                            <aside class="sidebar">
                                <nav>
                                    <ul id='addHere'>
                                        <li><a href="mainPage.php"><i class="fas fa-home"></i> Главная</a></li>
                                        <li><a href="deals.php"><i class="fas fa-exchange-alt"></i> Сделки</a></li>
                                        <li><a href="tickers.php"><i class="fas fa-chart-line label-icon"></i> Тикеры</a></li>
                                        <li><a href="traders.php"><i class="fas fa-user-tie label-icon"></i> Трейдеры</a></li>
                                        <li class="active"><a href="history.php"><i class="fas fa-history"></i> История</a></li>
                                    </ul>
                                </nav>
                            </aside>
                        <?php break;
                    case "deal": ?>
                        <div class="main-content">
                            <!-- Левая панель навигации -->
                            <aside class="sidebar">
                                <nav>
                                    <ul id='addHere'>
                                        <li><a href="../nav/mainPage.php"><i class="fas fa-home"></i> Главная</a></li>
                                        <li class="active"><a href="../nav/deals.php"><i class="fas fa-exchange-alt"></i> Сделки</a></li>
                                        <li><a href="../nav/tickers.php"><i class="fas fa-chart-line label-icon"></i> Тикеры</a></li>
                                        <li><a href="../nav/traders.php"><i class="fas fa-user-tie label-icon"></i> Трейдеры</a></li>
                                        <li><a href="../nav/history.php"><i class="fas fa-history"></i> История</a></li>
                                    </ul>
                                </nav>
                            </aside>
                        <?php break;
                }
            }
        }
        else
        {?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Авторизация / Регистрация</title>
            </head>
            <body>
                <div class="auth-container">
                    <div class="auth-header">
                        <h1>Вход в систему</h1>
                        <p>Введите ваши учетные данные для доступа</p>
                    </div>
        
                    <form action="../../api/auth/auth.php" method="POST" id="login" class="auth-form">
                        <div class="form-group">
                            <label for="username">Логин</label>
                            <input type="text" id="username" name="username" required>
                            <div class="focus-border"></div>
                        </div>
            
                        <div class="form-group">
                            <label for="password">Пароль</label>
                            <input type="password" id="password" name="password" required>
                            <div class="focus-border"></div>
                        </div>
            
                        <div class="form-actions">
                            <button type="submit" class="btn-submit">Войти</button>
                        </div>
                    </form>
        
                    <div class="auth-footer">
                        Нет аккаунта? <a href="register.php">Зарегистрируйтесь</a>
                    </div>
                </div>
            </body>
            </html>

            <script>
                document.getElementById('login').addEventListener('submit', function(e)
                {
                    e.preventDefault();
                    const formData = new FormData(this);
            
                    fetch(this.action,{method: 'POST', body: formData})
                    .then(response =>
                    {
                        if (response.status == 200)
                            location.reload();
                        else 
                            if (response.status == 409)
                                alert('Неверный логин или пароль ');
                            else
                                alert('Удалите спецсимволы');
                    })
                    .catch(error => { alert('Ошибка сети: ' + error.message); });
                });
            </script>

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
            <?php
            exit();
        }
    }

function MakeFooter()
{
    echo <<<END
        <!-- Правая панель с курсами -->
            <aside class="right-sidebar">
                <div class="exchange-rates">
                    <h3><i class="fas fa-coins"></i> Курсы валют</h3>
                    <table>
                        <tr>
                            <th>Пара</th>
                            <th>Цена</th>
                            <th>Изменение</th>
                        </tr>
                        <tr>
                            <td>USD/RUB</td>
                            <td id='usd'>XXX</td>
                            <td id='usd_2'>XXX</td>
                        </tr>
                        <tr>
                            <td>EUR/RUB</td>
                            <td id='eur'>XXX</td>
                            <td id='eur_2'>XXX</td>
                        </tr>
                        <tr>
                            <td>GBP/RUB</td>
                            <td id='gbp'>XXX</td>
                            <td id='gbp_2'>XXX</td>
                        </tr>
                        <tr>
                            <td>CNY/RUB</td>
                            <td id='cny'>XXX</td>
                            <td id='cny_2'>XXX</td>
                        </tr>
                    </table>
                </div>
                <div class="market-indices">
                    <h3><i class="fas fa-chart-pie"></i> Индексы</h3>
                    <div class="index">
                        <span>MOEX</span>
                        <span id='moex'>XXX</span>
                        <span id='moex_2'>XXX</span>
                    </div>
                </div>
            </aside>
        </div>

        <!-- Подвал сайта -->
        <footer class="footer">
            <div class="footer-content">
                <div class="footer-section">
                    <h4>О компании</h4>
                    <p>QuantumTrade - лидер в области алгоритмического трейдинга с 2010 года.</p>
                </div>
                <div class="footer-section">
                    <h4>Контакты</h4>
                    <p>Москва, ул. Тверская, 15</p>
                    <p>Телефон: +7 (123) 456-78-90</p>
                    <p>Email: info@quantumtrade.ru</p>
                </div>
                <div class="footer-section">
                    <h4>Регуляторы</h4>
                    <p>Лицензия ЦБ РФ №123456</p>
                    <p>Член SRO "Финансовый рынок"</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2023 QuantumTrade. Все права защищены.</p>
            </div>
        </footer>
    </div>
    </body>
    </html>
    <script>
        fetch('../helpers/load.php') 
            .then(response => response.json())
            .then(data => {
                document.getElementById('usd').textContent = data['USD'];
                document.getElementById('usd_2').textContent = data['USD_change'] + "%";
                document.getElementById('usd_2').classList = data['USD_class'];

                document.getElementById('eur').textContent = data['EUR'];
                document.getElementById('eur_2').textContent = data['EUR_change'] + "%";
                document.getElementById('eur_2').classList = data['EUR_class'];

                document.getElementById('gbp').textContent = data['GBP'];
                document.getElementById('gbp_2').textContent = data['GBP_change'] + "%";
                document.getElementById('gbp_2').classList = data['GBP_class'];

                document.getElementById('cny').textContent = data['CNY'];
                document.getElementById('cny_2').textContent = data['CNY_change'] + "%";
                document.getElementById('cny_2').classList = data['CNY_class'];

                document.getElementById('moex').textContent = data['MOEX'];
                document.getElementById('moex_2').textContent = data['MOEX_change'] + "%";
                document.getElementById('moex_2').classList = data['MOEX_class'];
            })
            .catch(error => console.error('Ошибка при загрузке курсов:', error));
    </script>
END;
}
?>