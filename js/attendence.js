function searchSubject() {

    let search = document.getElementById("searchSubject").value.toLowerCase();

    let table = document.getElementById("attendanceTable");

    let rows = table.getElementsByTagName("tr");

    for (let i = 1; i < rows.length; i++) {

   let subject = rows[i].getElementsByTagName("td")[1];

 if (subject) {

  let subjectName = subject.innerText.toLowerCase();
  if (subjectName.includes(search)) {
   rows[i].style.display = "";
   } 
  else {
   rows[i].style.display = "none";
   }
  }
    }
}


function resetSearch() {

    let table = document.getElementById("attendanceTable");

    let rows = table.getElementsByTagName("tr");

    document.getElementById("searchSubject").value = "";

    for (let i = 1; i < rows.length; i++) {
        rows[i].style.display = "";
    }
}