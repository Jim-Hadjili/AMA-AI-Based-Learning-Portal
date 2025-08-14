// Filtering
const searchInput = document.getElementById("rosterSearch");
const statusFilter = document.getElementById("statusFilter");
const rows = document.querySelectorAll(".student-row");

function applyFilters() {
  const q = (searchInput?.value || "").trim().toLowerCase();
  const status = (statusFilter?.value || "").toLowerCase();

  rows.forEach((r) => {
    const name = r.dataset.name;
    const st = r.dataset.status;
    const matchName = !q || name.includes(q);
    const matchStatus = !status || st === status;
    r.classList.toggle("hidden", !(matchName && matchStatus));
  });
}

searchInput?.addEventListener("input", applyFilters);
statusFilter?.addEventListener("change", applyFilters);

// Modal functions (existing)
function openStudentModal(index) {
  const modal = document.getElementById(`studentModal-${index}`);
  if (modal) {
    modal.classList.add("active");
    document.body.style.overflow = "hidden";
  }
}

function closeStudentModal(index) {
  const modal = document.getElementById(`studentModal-${index}`);
  if (modal) {
    modal.classList.remove("active");
    document.body.style.overflow = "";
  }
}
document.addEventListener("click", (e) => {
  document.querySelectorAll(".modal-backdrop.active").forEach((modal) => {
    if (e.target === modal) {
      const i = modal.id.replace("studentModal-", "");
      closeStudentModal(i);
    }
  });
});
document.addEventListener("keydown", (e) => {
  if (e.key === "Escape") {
    const activeModal = document.querySelector(".modal-backdrop.active");
    if (activeModal) {
      const i = activeModal.id.replace("studentModal-", "");
      closeStudentModal(i);
    }
  }
});

// Profile image preview (existing)
function openProfileImagePreview(index) {
  const modal = document.getElementById(`profileImageModal-${index}`);
  if (modal) {
    modal.classList.remove("hidden");
    modal.classList.add("flex");
    document.body.style.overflow = "hidden";
  }
}

function closeProfileImagePreview(index) {
  const modal = document.getElementById(`profileImageModal-${index}`);
  if (modal) {
    modal.classList.add("hidden");
    modal.classList.remove("flex");
    document.body.style.overflow = "";
  }
}
document.addEventListener("click", (e) => {
  document.querySelectorAll('[id^="profileImageModal-"]').forEach((modal) => {
    if (e.target === modal) {
      const i = modal.id.replace("profileImageModal-", "");
      closeProfileImagePreview(i);
    }
  });
});
document.addEventListener("keydown", (e) => {
  if (e.key === "Escape") {
    const activeProfileImageModal = document.querySelector(
      '[id^="profileImageModal-"].flex'
    );
    if (activeProfileImageModal) {
      const i = activeProfileImageModal.id.replace("profileImageModal-", "");
      closeProfileImagePreview(i);
    }
  }
});
