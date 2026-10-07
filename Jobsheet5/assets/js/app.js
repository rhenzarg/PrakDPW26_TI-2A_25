function initNavToggle() {
  const toggleBtn = document.getElementById("nav-toggle-btn");
  const nav = document.querySelector(".navbar-collapse");
  if (!toggleBtn || !nav) return;

  toggleBtn.addEventListener("click", function () {
    nav.classList.toggle("show");
  });
}

function initHapusConfirm() {
  document.querySelectorAll(".btn-hapus").forEach(function (btn) {
    btn.addEventListener("click", function () {
      const row = btn.closest("tr");
      const nama = row ? row.querySelector("td")?.textContent : "data ini";
      const yakin = confirm('Yakin ingin menghapus "' + nama + '"?');
      if (yakin && row) {
        row.remove();
      }
    });
  });
}

function initTableFilter() {
  const input = document.getElementById("search-input");
  const table = document.querySelector(".table-responsive table");
  if (!input || !table) return;

  input.addEventListener("keyup", function () {
    const keyword = input.value.toLowerCase();
    table.querySelectorAll("tbody tr").forEach(function (row) {
      const teks = row.textContent.toLowerCase();
      row.style.display = teks.includes(keyword) ? "" : "none";
    });
  });
}

function tampilkanError(input, pesan) {
  hapusError(input);
  const span = document.createElement("span");
  span.className = "error";
  span.textContent = pesan;
  input.insertAdjacentElement("afterend", span);
}

function hapusError(input) {
  const next = input.nextElementSibling;
  if (next && next.classList.contains("error")) {
    next.remove();
  }
}

function initValidasiForm() {
  const form = document.getElementById("form-tambah");
  if (!form) return;

  const wajibIsi = (v) => v.trim() !== "";
  const angkaValid = (v, min, max) => {
    const n = parseInt(v, 10);
    return !isNaN(n) && n >= min && n <= max;
  };

  const aturan = [
    { selector: "[name='judul'], [name='nama']", cek: wajibIsi, pesan: "Field ini wajib diisi." },
    { selector: "[name='pengarang']", cek: wajibIsi, pesan: "Field ini wajib diisi." },
    { selector: "[name='no_anggota']", cek: wajibIsi, pesan: "Field ini wajib diisi." },
    { selector: "[name='tahun']", cek: (v) => angkaValid(v, 1900, 2026), pesan: "Tahun harus di antara 1900-2026." },
    { selector: "[name='stok']", cek: (v) => angkaValid(v, 0, Infinity), pesan: "Stok tidak boleh negatif." },
  ];

  form.addEventListener("submit", function (e) {
    let valid = true;

    aturan.forEach(function (r) {
      const field = form.querySelector(r.selector);
      if (!field) return; 

      if (!r.cek(field.value)) {
        tampilkanError(field, r.pesan);
        valid = false;
      } else {
        hapusError(field);
      }
    });

    if (!valid) e.preventDefault();
  });
}

document.addEventListener("DOMContentLoaded", function () {
  initNavToggle();
  initHapusConfirm();
  initTableFilter();
  initValidasiForm();
});