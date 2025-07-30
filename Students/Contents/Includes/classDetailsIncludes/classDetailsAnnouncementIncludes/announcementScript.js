// Simple search and filter
function filterAnnouncements() {
  var search = document
    .getElementById("announcementSearch")
    .value.toLowerCase();
  var pinned = document.getElementById("filterPinned").value;
  var sort = document.getElementById("sortAnnouncements").value;
  var list = document.getElementById("announcementList");
  var items = Array.from(list.querySelectorAll("li"));

  // Filter
  items.forEach(function (li) {
    var title = li.getAttribute("data-title");
    var content = li.getAttribute("data-content");
    var isPinned = li.getAttribute("data-pinned");
    var show = true;
    if (search && !(title.includes(search) || content.includes(search)))
      show = false;
    if (pinned && isPinned !== pinned) show = false;
    li.style.display = show ? "" : "none";
  });

  // Sort
  var visibleItems = items.filter((li) => li.style.display !== "none");
  visibleItems.sort(function (a, b) {
    if (sort === "oldest") {
      return (
        new Date(a.getAttribute("data-date")) -
        new Date(b.getAttribute("data-date"))
      );
    } else if (sort === "newest") {
      return (
        new Date(b.getAttribute("data-date")) -
        new Date(a.getAttribute("data-date"))
      );
    } else if (sort === "az") {
      return a
        .getAttribute("data-title")
        .localeCompare(b.getAttribute("data-title"));
    } else if (sort === "za") {
      return b
        .getAttribute("data-title")
        .localeCompare(a.getAttribute("data-title"));
    }
    return 0;
  });
  // Re-append sorted items
  visibleItems.forEach((li) => list.appendChild(li));
}
document
  .getElementById("announcementSearch")
  .addEventListener("input", filterAnnouncements);
document
  .getElementById("filterPinned")
  .addEventListener("change", filterAnnouncements);
document
  .getElementById("sortAnnouncements")
  .addEventListener("change", filterAnnouncements);
