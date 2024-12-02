$(function () {
    var monthPicker = $("#monthPicker");
    var selectedDateField = $("#selectedDate");
    var groupSelect = $("#groupSelect");

    function setMonthValue() {
        var selectedDate = monthPicker.val();
        selectedDateField.val(selectedDate);
        localStorage.setItem('selectedMonth', selectedDate);
    }

    var savedMonth = localStorage.getItem('selectedMonth');
    var savedGroup = localStorage.getItem('selectedGroup');

    if (savedMonth) {
        monthPicker.val(savedMonth);
    } else {
        var currentDate = new Date();
        var formattedDate = currentDate.toISOString().slice(0, 7);
        monthPicker.val(formattedDate);
    }

    if (savedGroup) {
        groupSelect.val(savedGroup);
    }

    monthPicker.on("change", setMonthValue);

    groupSelect.on("change", function () {
        var selectedGroup = groupSelect.val();
        localStorage.setItem('selectedGroup', selectedGroup);
        setMonthValue();
    });
});

