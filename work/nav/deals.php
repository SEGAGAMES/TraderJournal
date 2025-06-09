<?php
require_once("loadSkelet.php");
MakeHeader("deals");
?>

<!-- Генераций карточек. -->
<script>
    window.currentPage = 1;
    window.totalPages = 10;
    function GenerateNewDealPage(deal)
    {
        window.location.href = '../helpers/pagegenerate.php?ticker=' +
        deal["ticker"] + '&deal_type=' +
        deal["deal_type"] + '&turnover=' +
        deal["turnover"] + '&cost=' +
        deal["cost"] + '&count=' +
        deal["count"] + '&futures=' +
        deal["futures"] + '&commission=' +
        deal["commission"] + '&id=' +
        deal['id'] + '&date=' +
        deal['date'] + '&time=' +
        deal['time'] + '&traders=' +
        deal['traders'] + '&photo_path='+
        deal['photo_path'];
    }

    function formatCurrency(value)
    {
        return value.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    }

    function createDealCard(deal)
    {
        const card = document.createElement('a');
        card.href = `javascript:GenerateNewDealPage(${JSON.stringify(deal)});`;
        card.innerHTML = `
            <div class="deal-card">
                <div class="deal-info">
                    <div class="deal-header">
                        <h3>${deal['ticker']}</h3>
                        <span class="${deal['deal_type'] ? 'deal-status open' : 'deal-status closed'}">
                            ${deal['deal_type'] ? 'Лонг' : 'Шорт'}
                        </span>
                    </div>
                    <div class="deal-meta">
                        <span><i class="fas fa-calendar-alt"></i> ${deal['date']} ${deal['time']}</span>
                    </div>
                    <div class="deal-stats">
                        <div class="stat">
                            <span class="stat-label">Количество</span>
                            <span class="stat-value">${deal['count']}</span>
                        </div>
                        <div class="stat">
                            <span class="stat-label">Цена ${deal['deal_type'] ? ' покупки' : 'продажи'}</span>
                            <span class="stat-value">${formatCurrency(deal['cost'])}</span>
                        </div>
                        <div class="stat">
                            <span class="stat-label">Оборот</span>
                            <span class="stat-value">${formatCurrency(deal['turnover'])}</span>
                        </div>
                        <div class="stat">
                            <span class="stat-label">Комиссия</span>
                            <span class="stat-value">${formatCurrency(deal['commission'])}</span>
                        </div>
                    </div>
                </div>
            </div>
        `;
        return card;
    }

    async function getCount()
    {
        const response = await fetch("../../api/trade/count.php?trader=" + '<? echo $_SESSION["traderid"]?>');
        dealsData = await response.json();
        totalPages = Math.ceil(dealsData / 10);
        if (totalPages == 0)
            totalPages = 1;
    }

    function updatePagination(page)
    {
        currentPage = page;
        document.getElementById('currentPage').textContent = currentPage;
        document.getElementById('totalPages').textContent = totalPages;
    
        const prevButton = document.querySelector('.pagination__prev');
        const nextButton = document.querySelector('.pagination__next');
    
        prevButton.disabled = currentPage === 1;
        nextButton.disabled = currentPage === totalPages;
    }

    async function renderDealCards(page=1)
    {
        const container = document.getElementById('deals-container');
        const response = await fetch("../../api/trade/read.php?page=" + page +"&trader=" + + '<? echo $_SESSION["traderid"]?>');
        container.innerHTML ='';
        await getCount();
        updatePagination(page);
        dealsData = await response.json();
        if (container)
        {
            dealsData.forEach(deal =>
            {
                const card = createDealCard(deal);
                container.appendChild(card);
            });
        }
    }
    document.addEventListener('DOMContentLoaded', () => {renderDealCards();});
</script>

            
<!-- Контент -->
<main class="content">
    <h2><i class="fas fa-exchange-alt"></i> История сделок</h2>
    
    <div class="add-deal-container">
        <button id="open-deal-form" class="btn btn-primary">
            <i class="fas fa-plus"></i> Добавить сделку
        </button>
    </div>
    
    <div id="deal-form-modal" class="modal" enctype="multipart/form-data">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3>Добавить новую сделку</h3>
            <form id="deal-form" action="../../api/trade/create.php" method="POST">
                <div class="form-group">
                    <label for="ticker">Тикер:</label>
                    <input type="text" id="ticker" name="ticker" list="tickers-list" required>
                    <datalist id="tickers-list">
                    </datalist>
                </div>
                
                <div class="form-group">
                    <label for="deal_type">Тип сделки:</label>
                    <select id="deal_type" name="deal_type" required>
                        <option value="1">Покупка</option>
                        <option value="0">Продажа</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="cost">Цена:</label>
                    <input type="number" id="cost" name="cost" required>
                </div>
                
                <div class="form-group">
                    <label for="futures">Инструмент:</label>
                    <select id="futures" name="futures" required>
                        <option value="0">Акция</option>
                        <option value="1">Фьючерс</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="count">Количество:</label>
                    <input type="number" id="count" name="count" required>
                </div>
                
                <div class="form-group">
                    <label for="date">Дата:</label>
                    <input type="date" id="date" name="date" required>
                </div>
                
                <div class="form-group">
                    <label for="time">Время:</label>
                    <input type="time" id="time" name="time" required>
                </div>
                
                <div class="form-group">
                    <label for="file_upload">Выберите файл (макс. 5MB):</label>
                    <input type="file" id="file_upload" name="photo" required accept=".jpg,.jpeg,.png">
                </div>

                <div class="form-group">
                    <label for="traders_list">Трейдеры (через запятую):</label>
                    <input type="text" id="traders_list" name="traders_list">
                </div>
                
                <button type="submit" class="btn btn-submit">Отправить</button>
            </form>
        </div>
    </div>

    <!-- Карточки сделок -->
    <div class="deals-grid" id="deals-container">
    </div>
    
    <div class="pagination">
        <!-- Кнопка "Назад" -->
        <button class="pagination__button pagination__prev" onclick="renderDealCards(window.currentPage-1)" >
            ← Назад
        </button>

        <!-- Текущая страница / Всего -->
        <span class="pagination__info">
            Страница <span class="pagination__current" id="currentPage">1</span> из <span class="pagination__total" id="totalPages">10</span>
        </span>

        <!-- Кнопка "Вперед" -->
        <button class="pagination__button pagination__next" onclick="renderDealCards(window.currentPage+1)">
            Вперед →
        </button>
    </div>
</main>

<!-- Автоматическая подстановка в форму. -->
<script>
    let tickersData = [];
    document.addEventListener('DOMContentLoaded', function()
    {
        fetch('../../api/stock/read.php').then(response => response.json()).then(data =>
        {
            tickersData = data;
            const datalist = document.getElementById('tickers-list');
            data.forEach(ticker =>
            {
                const option = document.createElement('option');
                option.value = ticker.ticker; 
                option.textContent = ticker.id; 
                datalist.appendChild(option);
                option.dataset.isFutures = ticker.futures;
                option.dataset.id = ticker.id;
            });
        }).catch(error => console.error('Ошибка при загрузке тикеров:', error));

        document.getElementById('ticker').addEventListener('change', function()
        {
            const selectedTickerValue = this.value;
            const futuresSelect = document.getElementById('futures');
        
            // Находим выбранный option в datalist
            const options = document.querySelectorAll('#tickers-list option');
            const selectedOption = Array.from(options).find(opt => opt.value === selectedTickerValue);
        
            if (selectedOption)
            {
                const tickerId = selectedOption.dataset.id;
                const selectedTickerData = tickersData.find(t => t.id == tickerId);
            
                if (selectedTickerData && selectedTickerData.futures)
                    futuresSelect.value = '1';
                else
                    futuresSelect.value = '0';
            }
        });
    });
</script>

<!-- Добавление сделки. -->
<script>
    document.addEventListener('DOMContentLoaded', function()
    {
        const modal = document.getElementById('deal-form-modal');
        const btn = document.getElementById('open-deal-form');
        const span = document.getElementsByClassName('close')[0];
        
        btn.onclick = function()
        {
            modal.style.display = 'block';
        }
        
        span.onclick = function()
        {
            modal.style.display = 'none';
        }
        
        window.onclick = function(event)
        {
            if (event.target == modal)
                modal.style.display = 'none';
        }
        
        document.getElementById('deal-form').addEventListener('submit', function(e)
        {
            e.preventDefault();
            const formData = new FormData(this);
            fetch(this.action, {method: 'POST', body: formData}).then(response =>
            {
                if (response.status == 201)
                {
                    alert('Сделка успешно добавлена!');
                    location.reload();
                }
                else
                {
                    alert('Ошибка при добавлении сделки ' + response.status);
                    console.log(response.json());
                }
            }).catch(error => {alert('Ошибка сети: ' + error.message);});
        });
    });
</script>

<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.4);
    }
    
    .modal-content {
        background-color: #fefefe;
        margin: 10% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 600px;
        border-radius: 5px;
    }
    
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }
    
    .close:hover {
        color: black;
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
        box-sizing: border-box;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    
    .btn {
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
    }
    
    .btn-primary {
        background-color: #4CAF50;
        color: white;
    }
    
    .btn-submit {
        background-color: #2196F3;
        color: white;
        width: 100%;
    }
    
    .add-deal-container {
        margin-bottom: 20px;
        text-align: right;
    }
</style>

<style>
    .pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 16px;
    margin: 24px 0;
    font-family: 'Segoe UI', Arial, sans-serif;
    }

    .pagination__button {
        padding: 8px 16px;
        border: 2px solid #4a6bff;
        border-radius: 6px;
        background-color: transparent;
        color: #4a6bff;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .pagination__button:hover:not(:disabled) {
        background-color: #4a6bff;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(74, 107, 255, 0.2);
    }

    .pagination__button:disabled {
        border-color: #e0e0e0;
        color: #e0e0e0;
        cursor: not-allowed;
    }

    .pagination__info {
        font-size: 14px;
        color: #555;
        min-width: 120px;
        text-align: center;
    }

    .pagination__current {
        font-weight: bold;
        color: #4a6bff;
    }

    .pagination__total {
        font-weight: bold;
        color: #333;
    }
    /* Адаптивность */
    @media (max-width: 480px) {
        .pagination {
            gap: 8px;
        }
        .pagination__button {
            padding: 6px 12px;
            font-size: 14px;
        }
        .pagination__info {
            font-size: 13px;
            min-width: 100px;
        }
    }
</style>

<?php
MakeFooter();
?>