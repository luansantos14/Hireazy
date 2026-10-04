const toggle = document.querySelector(".menu-toggle");
const nav = document.querySelector(".nav-links");
if (toggle)
  toggle.addEventListener("click", () => nav.classList.toggle("open"));
const search = document.querySelector("#professional-search");
const cards = [...document.querySelectorAll("[data-profession]")];
if (search)
  search.addEventListener("input", () => {
    const q = search.value.toLowerCase();
    cards.forEach(
      (c) =>
        (c.hidden =
          !c.dataset.profession.toLowerCase().includes(q) &&
          !c.dataset.city.toLowerCase().includes(q)),
    );
  });
document.querySelectorAll("[data-password-toggle]").forEach((btn) =>
  btn.addEventListener("click", () => {
    const input = document.querySelector(btn.dataset.passwordToggle);
    input.type = input.type === "password" ? "text" : "password";
    btn.textContent = input.type === "password" ? "Mostrar" : "Ocultar";
  }),
);
setTimeout(
  () => document.querySelector(".flash")?.classList.add("fade-out"),
  4500,
);
