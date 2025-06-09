<?php
require_once("loadSkelet.php");
MakeHeader("tickers");
?>
<!-- Контент -->
<main class="content">
    <h2><i class="fas fa-chart-line label-icon"></i>Тикеры</h2>

    <div class="stats-table-container">
        <div class="table-controls">
            <button class="add-btn" onclick="addNewTicker()">
                <i class="fas fa-plus"></i> Добавить тикер
            </button>
        </div>
        <table class="stats-table" id="tickers">
            <thead>
                <tr>
                    <th>Тикер</th>
                    <th>Фьючерс?</th>
                    <th>Биржа</th>
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
            <h3>Редактирование сделки</h3>
            <form id="tickerForm" action="../../api/stock/update.php" method="POST">               
                <div class="form-group">
                    <label>Тикер</label>
                    <input type="text" id="editTicker" name="ticker" required readonly>
                </div>
                
                <div class="form-group">
                    <label>Тип инструмента</label>
                    <select id="editFutures" name="futures">
                        <option value="0">Акция</option>
                        <option value="1">Фьючерс</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Биржа</label>
                    <select id="editExchange" name="exchange">
                        <option value="MOEX">MOEX</option>
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
            <h3>Добавление тикера</h3>
            <form id="tickerCreateForm" action="../../api/stock/create.php" method="POST">
                
                <div class="form-group">
                    <label>Тикер</label>
                    <input type="text" id="createTicker" name="ticker" required>
                </div>
                
                <div class="form-group">
                    <label>Тип инструмента</label>
                    <select id="editFutures" name="futures">
                        <option value="0">Акция</option>
                        <option value="1">Фьючерс</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Биржа</label>
                    <select id="createExchange" name="exchange">
                        <option value="MOEX">MOEX</option>
                    </select>
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
    let tickersData;
    document.addEventListener('DOMContentLoaded', renderTickers());

    function loadTrader(data)
    {
        const table = document.getElementById("tickers");
        table.innerHTML += `
          <tr>
            <td>${data['ticker']}</td>
            <td> <input type="checkbox" ${data['futures'] ? 'checked' : ''} readonly> </td>
            <td>${data['exchange']}</td>
            <td class="actions">
                <button class="edit-btn" onclick="editTicker('${data['ticker']}', '${data['futures']}', '${data['exchange']}')" title="Редактировать">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="delete-btn" onclick="deleteTicker('${data['ticker']}')" title="Удалить">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </td>
          </tr>
        `;
    }

    async function renderTickers()
    {
        //const container = document.getElementById('deals-container');
        const response = await fetch("../../api/stock/read.php");
        tickersData = await response.json();
        tickersData.forEach(trader => {
        const card = loadTrader(trader);
        });
    }
</script>

<!-- Обработка форм. -->
<script>
    document.getElementById('tickerForm').addEventListener('submit', function(e) {
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

    document.getElementById('tickerCreateForm').addEventListener('submit', function(e) {
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
            } 
            else
                if (response.status == 403)
                    alert('Недостаточно прав!');
                else
                    alert('Ошибка при добавлении!');
        })
        .catch(error => {
            alert('Ошибка сети: ' + error.message);
        });
    });
</script>

<!-- Управление записями -->
<script>
    function editTicker(ticker, futures, exchange)
    {
        document.getElementById('editTicker').value = ticker;
        document.getElementById('editFutures').value = futures;
        document.getElementById('editExchange').value = exchange;
        document.getElementById('editModal').style.display = 'block';
    }

    async function deleteTicker(ticker)
    {
        const response = await fetch("../../api/stock/delete.php?ticker="+ ticker);
        if (await response.status == 200)
        {
            alert("Удалено");
            location.reload();
        }
        else
            if (response.status == 403)
                alert('Недостаточно прав!');
            else
                alert('Ошибка при удалении!');
    }
    function addNewTicker()
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
