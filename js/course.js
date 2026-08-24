function searchCourse() {
    let search = document.getElementById("searchCourse").value.toLowerCase();
    let rows = document.getElementById("courseTable").getElementsByTagName("tr");

    for (let i = 1; i < rows.length; i++) {
        let course = rows[i].cells[1].innerText.toLowerCase();

        if (course.includes(search))
            rows[i].style.display = "";
        else
            rows[i].style.display = "none";
    }
}