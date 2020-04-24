import '../css/training_edit.css';
import '../css/autocomplete.css';
import {exerciseParameterElementCreate} from '../js/view/exercise_parameter';
import {exerciseElementCreate} from '../js/view/exercise';

let trainingElement = document.getElementById('training_edit');

if (trainingElement) {
    // Чтение атрибута data-training-id
    let trainingId = trainingElement.dataset.trainingId;
    renderExercises();

    function renderExercises() {
        fetch(`/api/trainings/${trainingId}/exercises`).then(response => {
            if (response.ok) {
                return response.json();
            }
            throw new Error('Request failed!');
        }, networkError => {
            console.log(networkError.message);
        }).then(exercises => {
            exercises.forEach(exercise => {
                // В функцию addExerciseElement передаются данные необходимые для отрисовки упражнения
                addExerciseElement(
                    exercise.id,
                    exercise.exerciseType.name,
                    exercise.exerciseType.id,
                    exercise.exerciseParameters
                );
            });
            document.querySelector(".exercise-add-button").addEventListener("click", function () {
                addExerciseElement();
            })
        });
    }

    function addExerciseElement(exerciseId, exerciseName, exerciseTypeId, exerciseParameters) {

        exerciseParameters = exerciseParameters || new Array();

        let exerciseElement = exerciseElementCreate(exerciseId, exerciseName, exerciseTypeId, exerciseParameters);

        exerciseParameters.forEach(exerciseParameter => {
            addExerciseParameterItem(
                exerciseElement,
                exerciseParameter.id,
                exerciseParameter.value,
                exerciseParameter.type.name,
                exerciseParameter.type.id
            );
        });

        // Ниже навешиваются события на это упражнение
        exerciseElement.querySelector(".exercise-delete-button").addEventListener("click", function () {
            exerciseDelete(exerciseElement.dataset.exerciseId, exerciseElement)
        });
        exerciseElement.querySelector(".exercise-parameter-add-button").addEventListener("click", function () {
            addExerciseParameterItem(exerciseElement)
        });
        exerciseTypeAutocomplete(exerciseElement);

        // Это упражнение добавляется к списку упражнений
        document.getElementById("exercises")
            .appendChild(exerciseElement);
    }

    function addExerciseParameterItem(exerciseElement, parameterId, parameterValue, parameterTypeName, parameterTypeId) {

        // Создание параметра
        let exerciseParameterList = exerciseElement.querySelector(".exercise-parameter-list");
        let exerciseParameterElement = exerciseParameterElementCreate(parameterId, parameterValue, parameterTypeName, parameterTypeId);
        exerciseParameterList.appendChild(exerciseParameterElement);

        // Добавление автокомплита в exercise-parameter-type
        // Тут внутри автокомплита навешивается функция exerciseParameterSave на exercise-parameter-type
        exerciseParameterTypeAutocomplete(exerciseParameterElement
            .querySelector('.exercise-parameter-type'), exerciseElement.dataset.exerciseId);

        // Добавление события к exercise-parameter-value
        let exerciseParameterValue = exerciseParameterElement.querySelector(".exercise-parameter-value");
        exerciseParameterValue.addEventListener("keyup", function () {
            // Тут навешивается exerciseParameterSave на exercise-parameter-value
            // В функцию передается два аргумента, первый - это id упражнения для запроса fetch,
            // второй - это созданный выше параметр полность, что бы прочесть оба инпута
            exerciseParameterSave(exerciseElement.dataset.exerciseId, exerciseParameterElement);
        });

        exerciseParameterElement.querySelector(".exercise-parameter-delete-button")
            .addEventListener("click", function () {
                exerciseParameterDelete(exerciseElement.dataset.exerciseId, exerciseParameterElement);
            })
    }

    function exerciseSave(trainingId, exerciseTypeId, exerciseElement) {

        let exerciseId = exerciseElement.dataset.exerciseId;

        if (exerciseTypeId) {
            fetch('/api/exercises', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    'exerciseTypeId': exerciseTypeId,
                    'trainingId': trainingId,
                    'exerciseId': exerciseId
                })
            })
                .then((response) => {
                    return response.json();
                })
                .then(response => {
                    console.log(exerciseElement);
                    exerciseElement.setAttribute("data-exercise-id", response.id);
                })
        }
    }

    function exerciseParameterSave(exerciseId, exerciseParameterElement) {

        let inputParameterTypeElement = exerciseParameterElement.querySelector(".exercise-parameter-type");
        let inputParameterValueElement = exerciseParameterElement.querySelector(".exercise-parameter-value");
        let parameterTypeId = inputParameterTypeElement.dataset.exerciseParameterTypeId;
        let parameterValue = inputParameterValueElement.value;

        if (parameterTypeId && parameterValue && parameterTypeId !== 'null') {
            fetch('/api/exercises/' + exerciseId + '/parameters', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    'parameterTypeId': parameterTypeId,
                    'parameterValue': parameterValue,
                    'previousParameterId': exerciseParameterElement.dataset.exerciseParameterId
                })
            })
                .then((response) => {
                    return response.json();
                })
                .then(response => {
                    exerciseParameterElement.setAttribute("data-exercise-parameter-id", response.id);
                })
        }
    }

    function exerciseTypeCreate(typeName) {
        const exerciseType =  () => {
            return fetch('/api/exercise-type', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    'typeName': typeName
                })
            }).then(response => response.json());
        };

        return exerciseType();
    }

    function exerciseTypeAutocomplete(exerciseElement) {

        let inputElement = exerciseElement.querySelector('.exercise-type-name');
        inputElement.onkeyup = (event) => {
            fetch('/api/exercise-type/search', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    'query': inputElement.value
                })
            })
                .then((response) => {
                    return response.json();
                })
                .then((data) => {
                    let tableElement = document.getElementById("results");
                    if (document.body.contains(tableElement)) {
                        tableElement.remove();
                    }
                    let table = document.createElement("table");
                    table.classList.add("autocomplete-table");
                    table.setAttribute("id", "results");
                    data.forEach(exerciseType => {
                        let tr = document.createElement("tr");
                        let tdExerciseTypeName = document.createElement("td");
                        // Добавление события. При клике будет подставляться value и id
                        // Следом навешивается функция сохранения упражнения. Следом всплывающая таблица удаляется
                        tdExerciseTypeName.addEventListener("click", function (event) {
                            inputElement.value = exerciseType.name;
                            inputElement.dataset.exerciseTypeId = exerciseType.id;
                            let trainingId = document.getElementById('training_edit').dataset.trainingId;
                            exerciseSave(trainingId, exerciseType.id, exerciseElement);
                            table.remove();
                        });
                        tdExerciseTypeName.appendChild(document.createTextNode(exerciseType.name));
                        tr.appendChild(tdExerciseTypeName);
                        table.appendChild(tr);
                    });

                    exerciseTypeAutocompleteCreate(inputElement, exerciseElement, table);

                    inputElement.parentElement.appendChild(table);
                    document.addEventListener("click", function (event) {
                        if (event.target.closest("#results")) return;
                        table.remove();
                    });
                });
        };
    }

    function exerciseTypeAutocompleteCreate(inputElement, exerciseElement, table) {
        let tr = document.createElement("tr");
        let tdExerciseTypeName = document.createElement("td");
        tdExerciseTypeName.addEventListener("click", function (event) {
            exerciseTypeCreate(inputElement.value).then(exerciseType => {
                inputElement.value = exerciseType.name;
                inputElement.dataset.exerciseTypeId = exerciseType.id;
                let trainingId = document.getElementById('training_edit').dataset.trainingId;
                exerciseSave(trainingId, exerciseType.id, exerciseElement);
            });
            table.remove();
        });
        tdExerciseTypeName.appendChild(document.createTextNode(inputElement.value));
        tr.appendChild(tdExerciseTypeName);

        table.appendChild(tr);
    }

    function exerciseParameterTypeAutocomplete(inputElement, exerciseId) {
        inputElement.onkeyup = (event) => {
            fetch('/api/exercise-parameter-type/search', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    'query': inputElement.value
                })
            })
                .then((response) => {
                    return response.json();
                })
                .then((data) => {
                    let tableElement = document.getElementById("results");
                    if (document.body.contains(tableElement)) {
                        tableElement.remove();
                    }
                    let table = document.createElement("table");
                    table.classList.add("autocomplete-table");
                    table.setAttribute("id", "results");
                    data.forEach(exerciseParameterType => {
                        let tr = document.createElement("tr");
                        let tdExerciseParameterTypeName = document.createElement("td");
                        tdExerciseParameterTypeName.addEventListener("click", function (event) {
                            inputElement.value = exerciseParameterType.name;
                            inputElement.dataset.exerciseParameterTypeId = exerciseParameterType.id;
                            // В функцию передает id упражнения и div содержащий оба инпута
                            exerciseParameterSave(exerciseId, inputElement.parentElement);
                            table.remove();
                        });

                        tdExerciseParameterTypeName.appendChild(document.createTextNode(exerciseParameterType.name));
                        tr.appendChild(tdExerciseParameterTypeName);
                        table.appendChild(tr);
                    });

                    inputElement.parentElement.appendChild(table);
                    document.addEventListener("click", function (event) {
                        if (event.target.closest("#results")) return;
                        table.remove();
                    });
                });
        }
    }

    function exerciseDelete(exerciseId, exerciseElement) {

        if (exerciseId !== "") {
            fetch(`/api/exercises/${exerciseId}`, {method: 'DELETE'}).then(response => {
                if (response.status !== 204) {
                    console.log('Fail!');
                }
            })
        }
        exerciseElement.remove();
    }

    function exerciseParameterDelete(exerciseId, exerciseParameterElement) {

        let parameterId = exerciseParameterElement.dataset.exerciseParameterId;

        if (parameterId !== "") {
            fetch(`/api/exercises/${exerciseId}/parameters/${parameterId}`, {method: 'DELETE'})
                .then(response => {
                    if (response.status !== 204) {
                        console.log('Fail!');
                    }
                })
        }
        exerciseParameterElement.remove();
    }
}