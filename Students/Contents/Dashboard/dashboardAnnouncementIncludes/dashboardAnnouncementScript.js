// Modal logic (same as other dashboards)
document.querySelectorAll(".flex.items-center.gap-4").forEach(function (card) {
  card.addEventListener("click", function (e) {
    if (e.currentTarget.tagName.toLowerCase() !== "a") return;
    e.preventDefault();
    var className = card
      .querySelector(".text-sm")
      .textContent.split("·")[0]
      .trim();
    var message =
      "You are about to view content from " + className + " Class" + ".";
    document.getElementById("confirmMessage").textContent = message;
    document.getElementById("confirmModal").classList.remove("hidden");
    var href = card.getAttribute("href");
    document.getElementById("confirmBtn").onclick = function () {
      window.location.href = href;
    };
    document.getElementById("cancelBtn").onclick = function () {
      document.getElementById("confirmModal").classList.add("hidden");
    };
  });
});

// Simple search filter (client-side, only filters current page)
document
  .getElementById("announcementSearch")
  .addEventListener("input", function () {
    var filter = this.value.toLowerCase();
    document.querySelectorAll("#announcementList li").forEach(function (li) {
      var text = li.textContent.toLowerCase();
      li.style.display = text.includes(filter) ? "" : "none";
    });
  });
