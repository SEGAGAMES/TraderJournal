<?php
require_once("loadSkelet.php");
MakeHeader("tickers");
if ($_SESSION['priority']<7)
    header('Location: mainPage.php');   
?>
<!-- Контент -->
<main class="content">
    <h2><i class="fas fa-user-cog"></i>Пользователи</h2>

    <div class="stats-table-container">
        <div class="table-controls">
            <button class="add-btn" onclick="addNewUser()">
                <i class="fas fa-plus"></i> Добавить пользователя
            </button>
        </div>
        <table class="stats-table" id="users">
            <thead>
                <tr>
                    <th>Имя пользователя</th>
                    <th>Роль</th>
                    <th>Управление</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <!-- Модальное окно для редактирования. -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="document.getElementById('editModal').style.display='none';">&times;</span>
            <h3>Редактирование пользователя</h3>
            <form id="userForm" action="../../api/user/update.php" method="POST">
                
                <div class="form-group">
                    <label>Имя пользователя</label>
                    <input type="text" id="editUsername" name="username" readonly>
                </div>

                <div class="form-group">
                    <label>Роль</label>
                    <select id="editRole" name="role" required>
                        <option value="user">Пользователь</option>
                        <option value="trader">Трейдер</option>
                        <option value="ticker_moderator">Модератор тикеров</option>
                        <option value="trader_moderator">Модератор трейдеров</option>
                        <option value="admin">Администартор</option>
                    </select>
                </div>    

                <div class="form-actions">
                    <button type="submit" class="save-btn">Сохранить</button>
                    <button type="button" class="cancel-btn" onclick="document.getElementById('editModal').style.display='none';">Отмена</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Модальное окно для создания. -->
    <div id="createModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="document.getElementById('createModal').style.display='none';">&times;</span>
            <h3>Добавление пользователя</h3>
            <form id="userCreateForm" action="../../api/user/create.php" method="POST">
                <div class="form-group">
                    <label>Имя пользователя</label>
                    <input type="text" id="createUsername" name="username" required>
                </div>

                <div class="form-group">
                    <label>Пароль</label>
                    <input type="text" id="createPassword" name="password" required>
                </div>

                <div class="form-group">
                    <label>Роль</label>
                    <select id="editRole" name="role" required>
                        <option value="user">Пользователь</option>
                        <option value="trader">Трейдер</option>
                        <option value="ticker_moderator">Модератор тикеров</option>
                        <option value="trader_moderator">Модератор трейдеров</option>
                        <option value="admin">Администартор</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Фамилия</label>
                    <input type="text" name="last" required>
                </div>

                <div class="form-group">
                    <label>Имя</label>
                    <input type="text" name="name" required>
                </div>

                <div class="form-group">
                    <label>Отчество</label>
                    <input type="text" name="sur" required>
                </div>
                                 
                <div class="form-actions">
                    <button type="submit" class="save-btn">Создать</button>
                    <button type="button" class="cancel-btn" onclick="document.getElementById('createModal').style.display='none';">Отмена</button>
                </div>
            </form>
        </div>
    </div>
</main>

<!-- Загрузить карточки -->
<script>
    let usersData;
    document.addEventListener('DOMContentLoaded', renderUsers());

    function loadUser(data)
    {
        const table = document.getElementById("users");
        table.innerHTML += `
          <tr>
            <td>${data['username']}</td>
            <td>${data['role']}</td>
            <td class="actions">
                <button class="edit-btn" onclick="editUser('${data['username']}', '${data['role']}')" title="Редактировать">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="delete-btn" onclick="deleteUser('${data['username']}', '${data['role']}')" title="Удалить">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </td>
          </tr>
        `;
    }

    async function renderUsers()
    {
        //const container = document.getElementById('deals-container');
        const response = await fetch("../../api/user/read.php");
        usersData = await response.json();
        usersData.forEach(user => {
        const card = loadUser(user);
        });
    }
</script>

<!-- Обработка форм. -->
<script>
    document.getElementById('userForm').addEventListener('submit', function(e) {
        e.preventDefault();
            
        const formData = new FormData(this);
        fetch(this.action, {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (response.status == 200) {
                alert('Обновлено!');
                //location.reload();
            } else {
                alert('Ошибка при обновлении ' + response.status);
                console.log(response.json());
            }
        })
        .catch(error => {
            alert('Ошибка сети: ' + error.message);
        });
    });

    document.getElementById('userCreateForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        fetch(this.action, {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (response.status == 201) {
                alert('Добавлено!');
                location.reload();
            } else {
                if (response.status == 409)
                    alert('Некорректно введены данные');
                else
                    if (response.status == 403)
                        alert("Недостаточно прав!");
                    else
                        alert('Удалите спецсимволы' + response.status);
            }
        })
        .catch(error => {
            alert('Ошибка сети: ' + error.message);
        });
    });
</script>

<!-- Управление записями -->
<script>
    function editUser(username, role)
    {
        document.getElementById('editUsername').value = username;
        document.getElementById('editRole').value = role;
        document.getElementById('editModal').style.display = 'block';
    }

    async function deleteUser(username, role)
    {
        const response = await fetch("../../api/user/delete.php?username="+ username);
        if (await response.status == 200)
        {
            alert("Удалено");
            location.reload();
        }
        else
            if (response.status == 403)
                alert("Недостаточно прав!");
            else
                alert("Не удалено. Ошибка!");
    }
    function addNewUser()
    {
        document.getElementById('createModal').style.display = 'block';
    }
</script>

<!-- Стили. -->
<style>
    /* Стили для кнопок действий */
    .actions {
        display: flex;
        gap: 8px;
        justify-content: center;
    }
    
    .edit-btn, .delete-btn, .add-btn {
        background: none;
        border: none;
        cursor: pointer;
        padding: 5px;
        font-size: 16px;
        border-radius: 4px;
        transition: all 0.2s;
    }
    
    .edit-btn {
        color: #3498db;
    }
    
    .delete-btn {
        color: #e74c3c;
    }
    
    .add-btn {
        background-color: #2ecc71;
        color: white;
        padding: 8px 16px;
        margin-top: 15px;
    }
    
    .edit-btn:hover, .delete-btn:hover {
        opacity: 0.8;
        transform: scale(1.1);
    }
    
    .add-btn:hover {
        background-color: #27ae60;
    }
    
    /* Стили для модального окна */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
    }
    
    .modal-content {
        background: white;
        margin: 10% auto;
        padding: 20px;
        border-radius: 8px;
        width: 80%;
        max-width: 500px;
    }
    
    .close {
        float: right;
        cursor: pointer;
        font-size: 24px;
        color: #aaa;
    }
    
    .close:hover {
        color: #333;
    }
    
    .form-group {
        margin-bottom: 15px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }
    
    .form-group input, 
    .form-group select {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;
    }
    
    .save-btn, .cancel-btn {
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    
    .save-btn {
        background-color: #3498db;
        color: white;
    }
    
    .cancel-btn {
        background-color: #e74c3c;
        color: white;
    }
    
    .save-btn:hover {
        background-color: #2980b9;
    }
    
    .cancel-btn:hover {
        background-color: #c0392b;
    }
</style>

<?php
MakeFooter();
?>
