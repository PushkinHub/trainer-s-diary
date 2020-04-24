export  function exerciseElementCreate(exerciseId, exerciseName, exerciseTypeId) {

    exerciseId = exerciseId || "";
    exerciseName = exerciseName || "";
    exerciseTypeId = exerciseTypeId || "";

    let divExerciseItem = document.createElement("div");
    divExerciseItem.classList.add("exercise-item");
    divExerciseItem.classList.add("row");
    divExerciseItem.setAttribute("data-exercise-id", exerciseId);

    let divLeft = document.createElement("div");
    divLeft.classList.add("col-lg-7");

    let divExerciseTypeName = document.createElement("div");

    let inputExerciseTypeName = document.createElement("input");
    inputExerciseTypeName.classList.add("exercise-type-name");
    inputExerciseTypeName.setAttribute("data-exercise-type-id", exerciseTypeId);
    inputExerciseTypeName.setAttribute("value", exerciseName);

    divExerciseTypeName.appendChild(inputExerciseTypeName);

    let divExerciseParameterList = document.createElement("div");
    divExerciseParameterList.classList.add("exercise-parameter-list");

    let inputExerciseParameterButton = document.createElement("input");
    inputExerciseParameterButton.classList.add("exercise-parameter-add-button");
    inputExerciseParameterButton.setAttribute("value", "+");
    inputExerciseParameterButton.setAttribute("type", "button");

    divLeft.appendChild(divExerciseTypeName);
    divLeft.appendChild(divExerciseParameterList);
    divLeft.appendChild(inputExerciseParameterButton);

    let divRight = document.createElement("div");
    divLeft.classList.add("col-lg-1");

    let buttonExerciseEdit = document.createElement("button");
    buttonExerciseEdit.classList.add("exercise-edit-button");

    let iconButtonExerciseEdit = document.createElement("i");
    iconButtonExerciseEdit.classList.add("far");
    iconButtonExerciseEdit.classList.add("fa-edit");

    buttonExerciseEdit.appendChild(iconButtonExerciseEdit);

    let buttonExerciseDelete = document.createElement("button");
    buttonExerciseDelete.classList.add("exercise-delete-button");

    let iconButtonExerciseDelete = document.createElement("i");
    iconButtonExerciseDelete.classList.add("far");
    iconButtonExerciseDelete.classList.add("fa-trash-alt");

    buttonExerciseDelete.appendChild(iconButtonExerciseDelete);

    divRight.appendChild(buttonExerciseEdit);
    divRight.appendChild(buttonExerciseDelete);

    divExerciseItem.appendChild(divLeft);
    divExerciseItem.appendChild(divRight);

    return divExerciseItem;
}