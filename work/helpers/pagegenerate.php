<?php

$ticker = $_GET['ticker'];
$deal_type = $_GET['deal_type'];
$turnover = $_GET['turnover'];
$cost = $_GET['cost'];
$count = $_GET['count'];
$futures = $_GET['futures'];
$commission = $_GET['commission'];
$id = $_GET['id'];
$date = $_GET['date'];
$time = $_GET['time'];
$traders = $_GET['traders'];
$photo_path = $_GET['photo_path'];

require_once("../nav/loadSkelet.php");
MakeHeader("deal");
?>
<main class="content">
    <div class="deal-details-header">
        <a href="../nav/deals.php" class="back-link">
            <i class="fas fa-arrow-left"></i> Назад к сделкам
        </a>
        <h2><i class="fas fa-exchange-alt"></i> Детали сделки </h2>
    </div>
    <style>
.gallery {
    grid-area: gallery;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 15px;
    background: #f9f9f9;
    text-align: center;
}

.gallery img {
    max-width: 100%;
    max-height: 500px;
    border-radius: 4px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    margin: 0 auto;
    display: block;
}

/* Для двухколоночного расположения на широких экранах */
@media (min-width: 768px) {
    .deal-info-grid {
        grid-template-areas:
            "gallery gallery"
            "params finance";
        grid-template-columns: 1fr 1fr;
    }
}
</style>
    <div class="deal-details-container">
        <div class="deal-info-grid">
            <div class="gallery">
                <?php
                if (!is_null($photo_path))
                {
                        echo '<div class="photo">';
                        echo '<img src="' . htmlspecialchars($photo_path) . '">';
                        echo '</div>';
                }
                else
                    echo '<p>Нет загруженных изображений.</p>';
                ?>
            </div>
            <div class="deal-info-section">
                <h3><i class="fas fa-info-circle"></i> Основные параметры</h3>
                <div class="info-row">
                    <span class="info-label">Тикер:</span>
                    <span class="info-value"><?echo $ticker?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Тип сделки:</span>
                    <span class="info-value"><? echo ($deal_type ? 'Лонг' : 'Шорт'); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Оборот:</span>
                    <span class="info-value"><?echo $turnover?></span>
                </div>
            </div>

            <div class="deal-info-section">
                <h3><i class="fas fa-coins"></i> Финансовые показатели</h3>
                <div class="info-row">
                    <span class="info-label">Цена <?echo ($deal_type ? 'покупки' : 'продажи');?>:</span>
                    <span class="info-value"><?echo $cost?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Объем:</span>
                    <span class="info-value"><?echo $count?> <?echo ($futures ? 'контрактов' : 'акций');?></span>
                </div>
                <div class="info-row highlight">
                    <span class="info-label">Комиссия:</span>
                    <span class="info-value negative"><?echo $commission?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="deal-actions">
        <button class="btn edit-btn" id="editDealBtn">
            <i class="fas fa-edit"></i> Изменить сделку
        </button>
        <button class="btn delete-btn" id="deleteDealBtn">
            <i class="fas fa-trash-alt"></i> Удалить сделку
        </button>
    </div>

    <div id="edit-deal-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3>Редактировать сделку</h3>
            <form id="edit-deal-form" action="../../api/trade/update.php" method="POST">
                <input type="hidden" id="edit-id" name="id" value="">
            
                <div class="form-group">
                    <label for="edit-ticker">Тикер:</label>
                    <input type="text" id="edit-ticker" name="ticker" required>
                </div>
            
                <div class="form-group">
                    <label for="edit-deal_type">Тип сделки:</label>
                    <select id="edit-deal_type" name="deal_type" required>
                        <option value="1">Покупка</option>
                        <option value="0">Продажа</option>
                    </select>
                </div>
            
                <div class="form-group">
                    <label for="edit-cost">Цена:</label>
                    <input type="number" id="edit-cost" name="cost" step="0.01" required>
                </div>
            
                <div class="form-group">
                    <label for="edit-futures">Фьючерс:</label>
                    <select id="edit-futures" name="futures" required>
                        <option value="1">Да</option>
                        <option value="0">Нет</option>
                    </select>
                </div>
            
                <div class="form-group">
                    <label for="edit-count">Количество:</label>
                    <input type="number" id="edit-count" name="count" required>
                </div>
            
                <div class="form-group">
                    <label for="edit-date">Дата:</label>
                    <input type="date" id="edit-date" name="date" required>
                </div>
            
                <div class="form-group">
                    <label for="edit-time">Время:</label>
                    <input type="time" id="edit-time" name="time" required>
                </div>

                <div class="form-group">
                    <label for="file_upload">Выберите файл (макс. 5MB):</label>
                    <input type="file" id="file_upload" name="photo" required accept=".jpg,.jpeg,.png">
                </div>

            
                <div class="form-group">
                    <label for="edit-traders_list">Трейдеры (через запятую):</label>
                    <input type="text" id="edit-traders_list" name="traders_list">
                </div>
            
                <button type="submit" class="btn btn-submit">Сохранить изменения</button>
            </form>
        </div>
    </div>
</main>
<?php
MakeFooter();
?>
<script>
    document.addEventListener('DOMContentLoaded', function()
    {
        // Получаем кнопку и модальное окно
        const editBtn = document.getElementById('editDealBtn');
        const modal = document.getElementById('edit-deal-modal');
        const closeBtn = modal.querySelector('.close');
        const delBtn = document.getElementById('deleteDealBtn');
        // Функция для заполнения формы данными сделки
        function fillEditForm(dealData)
        {
            document.getElementById('edit-id').value = dealData.id || '';
            document.getElementById('edit-ticker').value = dealData.ticker || '';
            document.getElementById('edit-deal_type').value = dealData.deal_type ? '1' : '0';
            document.getElementById('edit-cost').value = dealData.cost || '';
            document.getElementById('edit-futures').value = dealData.futures ? '1' : '0';
            document.getElementById('edit-count').value = dealData.count || '';
            document.getElementById('edit-date').value = dealData.date || '';
            document.getElementById('edit-time').value = dealData.time || '';
            document.getElementById('edit-traders_list').value = dealData.traders_list || '';
        }
        if (delBtn)
        {
            delBtn.addEventListener('click', async function()
            {
                const response = await fetch("../../api/trade/delete.php?id=<?echo $id?>");
                if (await response.status == 200)
                {
                    alert("Сделка успешно удалена");
                    window.location.href = '../nav/deals.php';
                }
                else
                    if (response.status == 403)
                        alert("Недостаточно прав!");
                    else
                        alert("Не удалось удалить сделку!");
            });
        }
        // Обработчик открытия модального окна
        if (editBtn)
        {
            editBtn.addEventListener('click', function()
            {
                const dealData =
                {
                    id:"<?echo $id?>",
                    ticker:"<?echo $ticker?>",
                    deal_type:<?echo ($deal_type ? 'true' : 'false');?>,
                    cost:"<?echo $cost?>",
                    futures:<?echo ($futures ? 'true' : 'false');?>,
                    count:"<?echo $count?>",
                    date:"<?echo $date?>",
                    time:"<?echo $time?>",
                    traders_list:"<?echo $traders?>"
                };
                fillEditForm(dealData);
                modal.style.display = 'block';
            });
        }
        
        // Закрытие модального окна
        if (closeBtn)
        {
            closeBtn.addEventListener('click', function()
            {
                modal.style.display = 'none';
            });
        }
        
        // Закрытие при клике вне модального окна
        window.addEventListener('click', function(event)
        {
            if (event.target === modal)
            {
                modal.style.display = 'none';
            }
        });
        
        // Обработка отправки формы
        const editForm = document.getElementById('edit-deal-form');
        if (editForm)
        {
            editForm.addEventListener('submit', function(e)
            {
                e.preventDefault();
                const formData = new FormData(this);
                fetch(this.action, { method: 'POST', body: formData}).then(response =>
                {
                    if (response.status == 202)
                    {
                        alert('Сделка успешно обновлена!');
                        modal.style.display = 'none';
                        this.reset();
                    }
                    else
                        if (response.status == 403)
                            alert("Недостаточно прав!");
                        else
                            alert('Ошибка при добавлении сделки!');
                }).catch(error => { alert('Ошибка сети: ' + error.message); });
            });
        }
    });
</script>