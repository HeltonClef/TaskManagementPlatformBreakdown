const input = document.getElementById("search");
const results = document.getElementById("results");
let selectedIndex = -1;

function debounce(fn, delay) {
  let timer;
  return (...args) => {
    clearTimeout(timer);
    timer = setTimeout(() => fn(...args), delay);
  };
}

async function searchTasks(query) {
  if (!query) {
    results.innerHTML = "<li>No results</li>";
    return;
  }

  try {
    const res = await fetch(`/api/search/tasks?q=${query}`);
    const data = await res.json();

    results.innerHTML = data
      .map(
        (item, i) =>
          `<li class="${i === selectedIndex ? "active" : ""}">
        ${item.title.replace(
          new RegExp(query, "gi"),
          (m) => `<mark>${m}</mark>`
        )}
      </li>`
      )
      .join("");
  } catch {
    results.innerHTML = "<li>Error loading results</li>";
  }
}

input.addEventListener(
  "input",
  debounce((e) => searchTasks(e.target.value), 300)
);

input.addEventListener("keydown", (e) => {
  if (e.key === "ArrowDown") selectedIndex++;
  if (e.key === "ArrowUp") selectedIndex--;
});
