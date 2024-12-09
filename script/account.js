const info = document.querySelector("#info");
const pass = document.querySelector("#pass");
const fees = document.querySelector("#fees");
const not = document.querySelector("#not");

const update = document.querySelector("#update-info");
const change = document.querySelector("#change-password");
const payment = document.querySelector("#payment");
const notification = document.querySelector("#notification");

info.addEventListener("click", function () {
  update.style.display = "block";
  change.style.display = "none";
  payment.style.display = "none";
  notification.style.display = "none";
});
pass.addEventListener("click", function () {
  update.style.display = "none";
  change.style.display = "block";
  payment.style.display = "none";
  notification.style.display = "none";
});
fees.addEventListener("click", function () {
  update.style.display = "none";
  change.style.display = "none";
  payment.style.display = "block";
  notification.style.display = "none";
});
not.addEventListener("click", function () {
  update.style.display = "none";
  change.style.display = "none";
  payment.style.display = "none";
  notification.style.display = "block";
});
