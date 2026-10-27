
const searchInput = document.getElementById("searchInput");
const yearFilter = document.getElementById("yearFilter");
const searchBtn = document.getElementById("searchBtn");
const cars = document.querySelectorAll(".car-card");
const emptyMessage = document.getElementById("emptyMessage");

function filterCars() {
    const searchText = searchInput.value.toLowerCase().trim();
    const selectedYear = yearFilter.value;
    let visibleCount = 0;

    cars.forEach(function (car) {
        const name = car.dataset.name.toLowerCase();
        const year = car.dataset.year;

        const matchesName = name.includes(searchText);
        const matchesYear = selectedYear === "" || year === selectedYear;

        if (matchesName && matchesYear) {
            car.hidden = false;
            visibleCount++;
        } else {
            car.hidden = true;
        }
    });

    emptyMessage.hidden = visibleCount !== 0;
}

searchBtn.addEventListener("click", filterCars);

searchInput.addEventListener("input", filterCars);

yearFilter.addEventListener("change", filterCars);
