async function muatDaftarBuku() {
  const tbody = document.querySelector(".table-responsive table tbody");
  const loading = document.getElementById("loading-indicator");
  if (!tbody) return;

  loading.style.display = "block";
  tbody.innerHTML = "";

  try {
    await new Promise((resolve) => setTimeout(resolve, 600));

    const res = await fetch("../data/buku.json");
    if (!res.ok) {
      throw new Error("Gagal mengambil data (status " + res.status + ")");
    }
    const daftarBuku = await res.json();

    daftarBuku.forEach(function (buku) {
      const tr = document.createElement("tr");
      tr.innerHTML =
        "<td>" + buku.judul + "</td>" +
        "<td>" + buku.pengarang + "</td>" +
        "<td>" + buku.tahun + "</td>" +
        "<td>" + buku.stok + "</td>" +
        "<td>" +
          "<button type=\"button\" class=\"btn btn-warning btn-sm\">Edit</button> " +
          "<button type=\"button\" class=\"btn btn-info btn-sm\">Detail</button> " +
          "<button type=\"button\" class=\"btn btn-danger btn-sm btn-hapus\">Hapus</button>" +
        "</td>";
      tbody.appendChild(tr);
    });
  } catch (err) {
    tbody.innerHTML =
      "<tr><td colspan=\"5\">Gagal memuat data: " + err.message + "</td></tr>";
  } finally {
    loading.style.display = "none";
  }
}

document.addEventListener("DOMContentLoaded", muatDaftarBuku);