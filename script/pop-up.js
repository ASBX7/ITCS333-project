const modal = document.getElementById("myModal");
const span = document.getElementsByClassName("close")[0];
const closeBtn = document.getElementById("closeModal");

span.addEventListener("click", function () {
  modal.style.display = "none";
});

closeBtn.addEventListener("click", function () {
  modal.style.display = "none";
});

window.addEventListener("click", function (event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
});
