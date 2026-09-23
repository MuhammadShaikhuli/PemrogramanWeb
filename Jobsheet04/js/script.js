document.addEventListener("DOMContentLoaded", () => {
    // 1. Navigation Hamburger Toggle
    const menuBtn = document.getElementById("menu-btn");
    const navMenu = document.querySelector("header nav");
    if (menuBtn && navMenu) {
        menuBtn.addEventListener("click", () => {
            navMenu.classList.toggle("nav-open");
        });
    }

    // 2. Fetch API & Render Data Buku
    const bukuTbody = document.getElementById("buku-tbody");
    const loadingIndicator = document.getElementById("loading-indicator");

    if (bukuTbody) {
        async function fetchBuku() {
            try {
                const response = await fetch("../data/buku.json");
                if (!response.ok) throw new Error("Gagal mengambil data");
                const data = await response.json();

                bukuTbody.innerHTML = data.map(buku => `
                    <tr>
                        <td>${buku.judul}</td>
                        <td>${buku.pengarang}</td>
                        <td>${buku.tahun}</td>
                        <td>${buku.stok}</td>
                        <td>
                            <button type="button">Edit</button>
                            <button type="button" class="btn-detail">Detail</button>
                            <button type="button" class="btn-hapus">Hapus</button>
                        </td>
                    </tr>
                `).join("");
            } catch (error) {
                bukuTbody.innerHTML = `<tr><td colspan="5">Gagal memuat data.</td></tr>`;
            } finally {
                if (loadingIndicator) loadingIndicator.style.display = "none";
            }
        }
        fetchBuku();
    }

    // 3. Filter Tabel Real-time (Khusus Kolom Pertama / Judul)
    const searchInput = document.getElementById("search-input");
    if (searchInput) {
        searchInput.addEventListener("input", (e) => {
            const keyword = e.target.value.toLowerCase();
            const rows = document.querySelectorAll("tbody tr");

            rows.forEach(row => {
                // Mengambil elemen <td> pertama pada baris tersebut
                const firstCell = row.querySelector("td");
                if (firstCell) {
                    const cellText = firstCell.textContent.toLowerCase();
                    row.style.display = cellText.includes(keyword) ? "" : "none";
                }
            });
        });
    }

    // 4. Event Delegation: Konfirmasi Hapus Baris
    document.addEventListener("click", (e) => {
        if (e.target.classList.contains("btn-hapus") || e.target.textContent === "Hapus") {
            const row = e.target.closest("tr");
            if (row && confirm("Apakah Anda yakin ingin menghapus data ini?")) {
                row.remove();
            }
        }
    });

    // 5. Validasi Form Sisi Klien
    const formTambahBuku = document.querySelector("form");
    if (formTambahBuku && window.location.pathname.includes("tambah.html")) {
        formTambahBuku.addEventListener("submit", (e) => {
            let isValid = true;

            // Hapus pesan error lama
            document.querySelectorAll(".error-msg").forEach(el => el.remove());

            // Validasi input wajib (required)
            const inputs = formTambahBuku.querySelectorAll("input[required]");
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    const error = document.createElement("small");
                    error.className = "error-msg";
                    error.style.color = "red";
                    error.textContent = "Field ini wajib diisi!";
                    input.after(error);
                }
            });

            // Validasi khusus ISBN: Hanya angka dan tanda hubung (-)
            const isbnInput = document.getElementById("isbn");
            if (isbnInput && isbnInput.value.trim() !== "") {
                const isbnPattern = /^[0-9-]+$/;
                if (!isbnPattern.test(isbnInput.value.trim())) {
                    isValid = false;
                    const error = document.createElement("small");
                    error.className = "error-msg";
                    error.style.color = "red";
                    error.textContent = "ISBN hanya boleh berisi angka dan tanda hubung (-)!";
                    isbnInput.after(error);
                }
            }

            if (!isValid) e.preventDefault();
        });
    }

    // Fetch & Render Data Anggota
    const anggotaTbody = document.getElementById("anggota-tbody");
    if (anggotaTbody) {
        async function fetchAnggota() {
            try {
                const response = await fetch("../data/anggota.json");
                if (!response.ok) throw new Error("Gagal mengambil data");
                const data = await response.json();

                anggotaTbody.innerHTML = data.map(anggota => `
                <tr>
                    <td>${anggota.no_anggota}</td>
                    <td>${anggota.nama}</td>
                    <td>${anggota.jk}</td>
                    <td>${anggota.alamat}</td>
                    <td>${anggota.no_hp}</td>
                    <td>
                        <button type="button">Edit</button>
                        <button type="button" class="btn-detail">Detail</button>
                        <button type="button" class="btn-hapus">Hapus</button>
                    </td>
                </tr>
            `).join("");
            } catch (error) {
                anggotaTbody.innerHTML = `<tr><td colspan="6">Gagal memuat data.</td></tr>`;
            } finally {
                if (loadingIndicator) loadingIndicator.style.display = "none";
            }
        }
        fetchAnggota();
    }
});