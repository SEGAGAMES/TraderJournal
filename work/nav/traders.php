<?php
require_once("loadSkelet.php");
MakeHeader("traders");
?>
<!-- Контент -->
<main class="content">
    <h2><i class="fas fa-user-tie label-icon"></i>Трейдеры</h2>

    <div class="stats-table-container">
        <table class="stats-table" id="traders">
            <thead>
                <tr>
                    <th>Фамилия</th>
                    <th>Имя</th>
                    <th>Отчество</th>
                    <th>Управление</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <!-- Модальное окно для редактирования -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="document.getElementById('editModal').style.display='none';">&times;</span>
            <h3>Редактирование трейдера</h3>
            <form id="tradeForm" action="../../api/trader/update.php" method="POST"> 
            
                <div class="form-group">
                    <label>Имя пользователя</label>
                    <input type="text" id="editUsername" name="username" readonly>
                </div>

                <div class="form-group">
                    <label>Фамилия</label>
                    <input type="text" id="editLast" name="last" required>
                </div>
                
                <div class="form-group">
                    <label>Имя</label>
                    <input type="text" id="editName" name="name" required>
                </div>
                
                <div class="form-group">
                    <label>Отчество</label>
                    <input type="text" id="editSur" name="sur" required>
                </div>
                                
                <div class="form-actions">
                    <button type="submit" class="save-btn">Сохранить</button>
                    <button type="button" class="cancel-btn" onclick="document.getElementById('editModal').style.display='none';">Отмена</button>
                </div>
            </form>
        </div>
    </div>

</main>

<!-- Загрузить карточки -->
<script>
    let tradersData;
    document.addEventListener('DOMContentLoaded', renderTraders());

    function loadTrader(data)
    {
        const table = document.getElementById("traders");
        table.innerHTML += `
          <tr>
            <td>${data['last']}</td>
            <td>${data['name']}</td>
            <td>${data['sur']}</td>
            <td class="actions">
                <button class="edit-btn" onclick="editTrader('${data['username']}', '${data['last']}', '${data['name']}', '${data['sur']}')" title="Редактировать">
                    <i class="fas fa-edit"></i>
                </button>
            </td>
          </tr>
        `;
    }

    async function renderTraders()
    {
        //const container = document.getElementById('deals-container');
        const response = await fetch("../../api/trader/read.php");
        tradersData = await response.json();
        tradersData.forEach(trader => {
        const card = loadTrader(trader);
        });
    }
</script>

<!-- Управление окном. -->
<script>
    function closeModal()
    {
        document.getElementById('editModal').style.display = 'none';
    }
</script>

<!-- Обработка форм. -->
<script>
    document.getElementById('tradeForm').addEventListener('submit', function(e) {
        e.preventDefault();
            
        const formData = new FormData(this);
            
        fetch(this.action, {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (response.status == 200) {
                alert('Обновлено!');
                location.reload();
            }
            else
                if (response.status == 403)
                    alert('Недостаточно прав!');
                else
                    alert('Ошибка при обновлении!');
        })
        .catch(error => {
            alert('Ошибка сети: ' + error.message);
        });
    });
</script>

<!-- Управление записями -->
<script>
    function editTrader(username, last, name, sur)
    {
        document.getElementById('editUsername').value = username;
        document.getElementById('editLast').value = last;
        document.getElementById('editName').value = name;
        document.getElementById('editSur').value = sur;
        document.getElementById('editModal').style.display = 'block';
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
