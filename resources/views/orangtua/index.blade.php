{{--
    View: orangtua/index.blade.php
    Deskripsi: Halaman utama CRUD orangtua.
    Fitur:
      - Menampilkan daftar orangtua dalam bentuk tabel
      - Tambah, Edit, dan Hapus orangtua secara dinamis menggunakan AJAX (tanpa reload halaman)
      - Modal dialog DaisyUI untuk setiap operasi (tambah, edit, hapus)
--}}
<x-app-layout>

    {{-- =========================================================
         SECTION: TABEL orangtua
         Menampilkan daftar seluruh orangtua yang ada di database.
         Setiap baris memiliki tombol Edit dan Hapus.
    ========================================================= --}}
    <div class="max-w-4xl mx-auto mt-10">
        <div class="p-6 bg-white rounded-lg shadow-md">

            {{-- Header: Judul halaman dan tombol Tambah --}}
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-lg font-semibold">CRUD orangtua</h4>

                {{-- Tombol Tambah: membuka modal tambah orangtua --}}
                <button class="px-4 py-2 text-white bg-green-600 rounded hover:bg-green-700"
                    onclick="add_modal.showModal()">
                    Tambah
                </button>
            </div>

            {{-- Tabel daftar orangtua --}}
            <table class="w-full border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border">No</th>
                        <th class="px-4 py-2 border">Nama orangtua</th>
                        <th class="px-4 py-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody id="orangtua-tbody">
                    {{--
                        Loop setiap orangtua dari controller.
                        Setiap <tr> diberi id="row-{id}" agar mudah dimanipulasi DOM via JavaScript.
                        @forelse digunakan agar bisa menampilkan pesan ketika data kosong (@empty).
                    --}}
                    @forelse ($orangtua as $index => $kls)
                        <tr id="row-{{ $kls->id }}">
                            {{-- Kolom nomor urut, diperbarui otomatis via JS (class="nomor") --}}
                            <th class="px-4 py-2 border nomor">{{ $index + 1 }}</th>

                            {{-- Kolom nama orangtua --}}
                            <td class="px-4 py-2 border">{{ $kls->nama }}</td>

                            {{-- Kolom aksi: tombol Edit dan Hapus --}}
                            <td class="px-4 py-2 space-x-1 border">
                                {{--
                                    Tombol Edit:
                                    - data-id   : id orangtua, dikirim ke fungsi openEditModal()
                                    - data-nama : nama orangtua saat ini, ditampilkan di form edit
                                --}}
                                <button class="px-2 py-1 text-white bg-blue-600 rounded hover:bg-blue-700"
                                    onclick="openEditModal(this)" data-id="{{ $kls->id }}"
                                    data-nama="{{ $kls->nama }}">
                                    Edit
                                </button>

                                {{--
                                    Tombol Hapus:
                                    - data-id : id orangtua yang akan dihapus, dikirim ke fungsi openDeleteModal()
                                --}}
                                <button class="px-2 py-1 text-white bg-red-500 rounded hover:bg-red-700"
                                    onclick="openDeleteModal(this)" data-id="{{ $kls->id }}">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        {{-- Baris placeholder ketika tidak ada data orangtua --}}
                        <tr id="empty-row">
                            <td colspan="3" class="py-4 text-center text-gray-400">Tidak ada orangtua tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
    {{-- END SECTION: TABEL orangtua --}}


    {{-- =========================================================
         SECTION: MODAL TAMBAH orangtua
         Dialog untuk memasukkan nama orangtua baru.
         Submit form akan diarahkan ke event listener AJAX di bawah.
    ========================================================= --}}
    <dialog id="add_modal" class="modal">
        <form class="modal-box" id="form-tambah">
            @csrf
            <h3 class="mb-4 text-lg font-bold">Tambah orangtua</h3>

            <div class="w-full mb-4 form-control">
                <label class="mb-2 label">
                    <span class="label-text">Nama orangtua</span>
                </label>
                {{-- Input nama orangtua baru --}}
                <input type="text" name="nama" id="tambah-nama-orangtua" class="w-full input input-bordered"
                    placeholder="Contoh: XII RPL 1" required />
            </div>

            <div class="modal-action">
                <button type="submit"
                    class="px-3 py-1 text-white bg-blue-600 rounded hover:bg-blue-700">Simpan</button>
                <button type="reset" class="px-3 py-1 text-white bg-red-600 rounded hover:bg-red-700"
                    onclick="add_modal.close()">Batal</button>
            </div>
        </form>
    </dialog>
    {{-- END SECTION: MODAL TAMBAH orangtua --}}


    {{-- =========================================================
         SECTION: MODAL EDIT orangtua
         Dialog untuk mengubah nama orangtua yang sudah ada.
         - #edit-id   : menyimpan id orangtua yang sedang diedit (hidden field)
         - #edit-nama-orangtua : input nama orangtua yang akan diubah
         Submit form akan diarahkan ke event listener AJAX di bawah.
    ========================================================= --}}
    <dialog id="edit_modal" class="modal">
        <form class="modal-box" id="form-edit">
            {{-- Hidden field untuk menyimpan id orangtua yang sedang diedit --}}
            <input type="hidden" id="edit-id" />

            <h3 class="mb-4 text-lg font-bold">Edit orangtua</h3>

            <div class="w-full mb-4 form-control">
                <label class="mb-2 label">
                    <span class="label-text">Nama orangtua</span>
                </label>
                {{-- Input nama orangtua, akan diisi otomatis oleh openEditModal() --}}
                <input type="text" id="edit-nama-orangtua" class="w-full input input-bordered"
                    placeholder="Masukkan nama orangtua" required />
            </div>

            <div class="modal-action">
                <button type="submit"
                    class="px-3 py-1 text-white bg-blue-600 rounded hover:bg-blue-700">Simpan</button>
                <button type="reset" class="px-3 py-1 text-white bg-red-600 rounded hover:bg-red-700"
                    onclick="edit_modal.close()">Batal</button>
            </div>
        </form>
    </dialog>
    {{-- END SECTION: MODAL EDIT orangtua --}}


    {{-- =========================================================
         SECTION: MODAL HAPUS orangtua
         Dialog konfirmasi sebelum menghapus orangtua.
         Tombol #confirm-delete-btn di-assign handler-nya secara dinamis
         oleh fungsi openDeleteModal() berdasarkan id orangtua yang diklik.
    ========================================================= --}}
    <dialog id="delete_modal" class="modal">
        <div class="modal-box">
            <h3 class="mb-2 text-lg font-bold">Hapus orangtua</h3>
            <p class="mb-4 text-gray-600">Apakah Anda yakin ingin menghapus orangtua ini?</p>

            <div class="modal-action">
                {{-- Tombol konfirmasi hapus; onclick di-set dinamis oleh openDeleteModal() --}}
                <button id="confirm-delete-btn"
                    class="px-3 py-1 text-white bg-red-600 rounded hover:bg-red-700">Hapus</button>
                <button type="button" class="px-3 py-1 text-white bg-gray-400 rounded hover:bg-gray-500"
                    onclick="delete_modal.close()">Batal</button>
            </div>
        </div>
    </dialog>
    {{-- END SECTION: MODAL HAPUS orangtua --}}


    {{-- =========================================================
         SECTION: JAVASCRIPT - AJAX CRUD
         Seluruh operasi CRUD dilakukan secara asinkron (AJAX) menggunakan
         Fetch API, sehingga halaman tidak perlu di-reload.

         Fungsi Utama:
           - reindexRows()     : Mengurutkan ulang nomor baris setelah tambah/hapus
           - syncEmptyRow()    : Menampilkan/menyembunyikan baris "tidak ada data"
           - createRow()       : Membuat elemen <tr> baru untuk ditambahkan ke tabel
           - ajaxFetch()       : Wrapper Fetch API yang menyertakan CSRF token secara otomatis
           AJAX Tambah  → POST   /orangtua
           AJAX Edit    → POST   /orangtua/{id} (method spoofing _method: PUT)
           AJAX Hapus   → DELETE /orangtua/{id}
    ========================================================= --}}
    <script>
        /** Token CSRF dari Laravel, disisipkan ke setiap header request AJAX. */
        const CSRF = "{{ csrf_token() }}";

        /**
         * Mengurutkan ulang kolom nomor urut pada setiap baris tabel.
         * Dipanggil setelah operasi tambah atau hapus data agar nomor tetap berurutan.
         */
        function reindexRows() {
            document.querySelectorAll('#orangtua-tbody tr[id^="row-"]').forEach((row, i) => {
                row.querySelector('.nomor').textContent = i + 1;
            });
        }

        /**
         * Menyinkronkan tampilan baris kosong ("Tidak ada orangtua tersedia.").
         * - Menambahkan baris kosong jika tidak ada data orangtua di tabel.
         * - Menghapus baris kosong jika sudah ada minimal satu data orangtua.
         */
        function syncEmptyRow() {
            const tbody = document.getElementById('orangtua-tbody');
            const hasRows = tbody.querySelectorAll('tr[id^="row-"]').length > 0;
            let emptyRow = document.getElementById('empty-row');

            if (!hasRows && !emptyRow) {
                emptyRow = document.createElement('tr');
                emptyRow.id = 'empty-row';
                emptyRow.innerHTML =
                    `<td colspan="3" class="py-4 text-center text-gray-400">Tidak ada orangtua tersedia.</td>`;
                tbody.appendChild(emptyRow);
            } else if (hasRows && emptyRow) {
                emptyRow.remove();
            }
        }

        /**
         * Membuat elemen <tr> baru untuk ditambahkan ke tabel orangtua.
         * Dipanggil setelah operasi tambah berhasil, menggunakan data dari response JSON controller.
         *
         * @param {number} id   - ID orangtua dari database
         * @param {string} nama - Nama orangtua
         * @returns {HTMLTableRowElement} Elemen <tr> yang sudah berisi data dan tombol aksi
         */
        function createRow(id, nama) {
            const tr = document.createElement('tr');
            tr.id = `row-${id}`;
            tr.innerHTML = `
                <th class="px-4 py-2 border nomor"></th>
                <td class="px-4 py-2 border">${nama}</td>
                <td class="px-4 py-2 space-x-1 border">
                    <button class="px-2 py-1 text-white bg-blue-600 rounded hover:bg-blue-700"
                        onclick="openEditModal(this)" data-id="${id}" data-nama="${nama}">
                        Edit
                    </button>
                    <button class="px-2 py-1 text-white bg-red-500 rounded hover:bg-red-700"
                        onclick="openDeleteModal(this)" data-id="${id}">
                        Hapus
                    </button>
                </td>
            `;
            return tr;
        }

        /**
         * Wrapper Fetch API untuk request AJAX ke server Laravel.
         * Secara otomatis menyertakan CSRF token, Content-Type JSON,
         * dan header X-Requested-With untuk identifikasi request AJAX.
         *
         * @param {string}      url    - URL endpoint yang dituju
         * @param {string}      method - HTTP method (GET, POST, DELETE, dll.)
         * @param {Object|null} body   - Data yang dikirim sebagai JSON body (opsional)
         * @returns {Promise<Object>} Promise yang me-resolve dengan data JSON dari server
         * @throws {Error} Jika response server tidak OK (status di luar 2xx)
         */
        function ajaxFetch(url, method, body = null) {
            return fetch(url, {
                method,
                headers: {
                    'X-CSRF-TOKEN': CSRF,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: body ? JSON.stringify(body) : null,
            }).then(res => {
                if (!res.ok) throw new Error('Server error');
                return res.json();
            });
        }

        // ---------------------------------------------------------
        // AJAX TAMBAH orangtua
        // Alur: submit form → POST /orangtua → terima response → append baris baru ke tabel
        // ---------------------------------------------------------
        document.getElementById('form-tambah').addEventListener('submit', function(e) {
            e.preventDefault();

            // Ambil nilai input dan hapus spasi di awal/akhir
            const nama = document.getElementById('tambah-nama-orangtua').value.trim();

            // Kirim request POST ke /orangtua dengan data nama
            ajaxFetch('/orangtua', 'POST', {
                    nama: nama
                })
                .then(data => {
                    if (!data.success) return;

                    // Buat baris baru dari data response controller (data.orangtua),
                    // lalu tambahkan ke tbody, perbarui nomor urut, dan sinkronkan empty row
                    const newRow = createRow(data.orangtua.id, data.orangtua.nama);
                    document.getElementById('orangtua-tbody').appendChild(newRow);
                    syncEmptyRow();
                    reindexRows();

                    add_modal.close();
                    this.reset();
                })
                .catch(() => alert('Gagal menambah data.'));
        });

        // ---------------------------------------------------------
        // AJAX EDIT orangtua
        // Alur: klik tombol Edit → isi form modal → submit → POST /orangtua/{id} (_method: PUT)
        //       → terima response → update teks nama orangtua di baris tabel
        // ---------------------------------------------------------

        /**
         * Membuka modal edit dan mengisi form dengan data orangtua yang dipilih.
         * Dipanggil dari atribut onclick pada tombol Edit di setiap baris tabel.
         *
         * @param {HTMLButtonElement} btn - Tombol Edit yang diklik,
         *                                  harus memiliki atribut data-id dan data-nama
         */
        function openEditModal(btn) {
            document.getElementById('edit-id').value = btn.dataset.id;
            document.getElementById('edit-nama-orangtua').value = btn.dataset.nama;
            edit_modal.showModal();
        }

        document.getElementById('form-edit').addEventListener('submit', function(e) {
            e.preventDefault();

            // Ambil id dan nama orangtua dari form modal edit
            const id = document.getElementById('edit-id').value;
            const nama = document.getElementById('edit-nama-orangtua').value.trim();

            // Kirim request POST dengan _method: PUT (Laravel method spoofing)
            // ke endpoint /orangtua/{id}
            ajaxFetch(`/orangtua/${id}`, 'POST', {
                    _method: 'PUT',
                    nama: nama
                })
                .then(data => {
                    if (!data.success) return;

                    // Perbarui teks nama orangtua di kolom kedua baris yang sesuai
                    const row = document.getElementById(`row-${id}`);
                    row.cells[1].textContent = nama;

                    // Perbarui atribut data-nama pada tombol Edit di baris tersebut
                    // agar nilai terbaru tersedia saat modal edit dibuka kembali
                    row.querySelectorAll('[data-nama]').forEach(btn => btn.dataset.nama = nama);

                    edit_modal.close();
                })
                .catch(() => alert('Gagal mengedit data.'));
        });

        // ---------------------------------------------------------
        // AJAX HAPUS orangtua
        // Alur: klik tombol Hapus → tampilkan modal konfirmasi → klik konfirmasi
        //       → DELETE /orangtua/{id} → terima response → hapus baris dari tabel
        // ---------------------------------------------------------

        /**
         * Membuka modal konfirmasi hapus dan menetapkan handler untuk tombol konfirmasi.
         * Handler di-assign ulang setiap kali fungsi ini dipanggil agar selalu
         * mengacu pada id orangtua yang benar.
         *
         * @param {HTMLButtonElement} btn - Tombol Hapus yang diklik,
         *                                  harus memiliki atribut data-id
         */
        function openDeleteModal(btn) {
            const id = btn.dataset.id;
            delete_modal.showModal();

            // Tetapkan handler konfirmasi hapus secara dinamis berdasarkan id yang dipilih
            document.getElementById('confirm-delete-btn').onclick = function() {
                // Kirim request DELETE ke /orangtua/{id}
                ajaxFetch(`/orangtua/${id}`, 'DELETE')
                    .then(data => {
                        if (!data.success) return;

                        // Hapus baris dari tabel, perbarui nomor urut, dan sinkronkan empty row
                        document.getElementById(`row-${id}`).remove();
                        reindexRows();
                        syncEmptyRow();
                        delete_modal.close();
                    })
                    .catch(() => alert('Gagal menghapus data.'));
            };
        }
    </script>
    {{-- END SECTION: JAVASCRIPT - AJAX CRUD --}}

</x-app-layout>
