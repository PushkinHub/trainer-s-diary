import '../css/autocomplete.css';

if (document.getElementById('search_ward')) {
    //В переменную input записываем элемент search(это id у input)
    let input = document.getElementById('search');
    input.onkeyup = (event) => {
        fetch('/api/wards/search', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                'query': input.value
            })
        })
            .then((response) => {
                return response.json();
            })
            .then((data) => {
                // Получаем элемент по id results для удаления таблицы с предыдущими результатами запроса
                // Если body содержит элемент с id results таблица удаляется
                let tableElement = document.getElementById("results");
                if (document.body.contains(tableElement)) {
                    tableElement.remove();
                }
                let table = document.createElement("table");
                table.classList.add("autocomplete-table");
                // Задается атрибут id со значением results
                table.setAttribute("id", "results");
                data.forEach(element => {
                    let tr = document.createElement("tr");
                    let tdEmail = document.createElement("td");
                    let link = document.createElement("a");
                    link.setAttribute("href", `/training/${element.id}/list`);
                    link.appendChild(document.createTextNode(element.email));
                    tdEmail.appendChild(link);
                    let tdFirstName = document.createElement("td");
                    tdFirstName.appendChild(document.createTextNode(element.firstName));
                    tr.appendChild(tdFirstName);
                    tr.appendChild(tdEmail);
                    table.appendChild(tr);
                });
                document.getElementById("search_ward").appendChild(table);
                //Добавление обработчика события, где событие click, а коллбек функция обработчик(listener)
                document.addEventListener("click", function (event) {
                    // Если кликнуть внутри элемента results ничего не произойдет
                    if (event.target.closest("#results")) return;
                    //Если кликнуть вне элемента results, таблица удалится
                    table.remove();
                });
            });
    };
    /**
     * getElementById - устанавливает связь между HTML и JS, позволяя из JS влиять на HTML
     * onkeyup - метод обозначающий событие отжатия клавишы
     * innerHTML - работа изнутри тега полученного по getElementById
     */
}
