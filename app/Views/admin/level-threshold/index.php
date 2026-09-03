<div class="row align-items-center">
    <div class="col">
        <div class="page-title">Courbe des niveaux</div>
    </div>
</div>

<div class="row mt-3">

    <!-- AJOUT D'UN NIVEAU : 1/3 -->
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header"> Ajouter un niveau </div>
            <div class="card-body">
                <form method="POST" action="<?= base_url('level/add'); ?>">

                    <div class="mb-3">
                        <label for="level" class="form-label"> Niveau </label>
                        <input type="number" class="form-control" id="level" name="level" min="1" placeholder="Niveau" required>
                    </div>

                    <div class="mb-3">
                        <label for="experience_required" class="form-label">Expérience requise</label>
                        <input type="number" class="form-control" id="experience_required" name="experience_required" min="0" placeholder="XP" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fa-solid fa-plus me-1"></i> Ajouter</button>
                </form>
            </div>
        </div>
    </div>
    <!-- TABLEAU DES NIVEAUX : 2/3 -->
    <div class="col-md-8">
        <div class="card h-100">
            <div class="card-body">
                <table class="table table-hover table-striped" id="levelThresholdTable">
                    <thead>
                    <tr>
                        <th><div class="d-flex align-items-center justify-content-center">
                                <input type="number" class="form-control" id="filter_level" name="filter_level" min="1" placeholder="Niveau" required>
                            </div>
                        </th>
                        <th>
                            <div class="d-flex align-items-center justify-content-center">
                                <input type="number" class="form-control" id="filter_experience" name="filter_experience" min="0" placeholder="Experience requise" required>
                            </div>
                        </th>
                        <th><div class="d-flex align-items-center justify-content-center">
                                <input type="text" class="form-control" id="filter_actions" name="filter_actions" placeholder="Actions" required>
                            </div>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($levelThresholds as $levelThreshold) : ?>
                        <tr>
                            <td><?= $levelThreshold['level']; ?></td>
                            <td><?= $levelThreshold['experience_required']; ?> XP</td>
                            <!-- SUPPRESSION -->        <td>
                                <form method="POST" action="<?= base_url('level/delete'); ?>" class="d-inline" onsubmit="return confirm('Voulez-vous vraiment supprimer ce seuil ?');">
                                    <input type="hidden" name="id" value="<?= $levelThreshold['id']; ?>">
                                    <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                                        <i class="fa-solid fa-trash-alt"></i>
                                    </button>
                                </form>
                                <!-- MODIFICATION -->
                                <button type="button" class="btn btn-sm btn-warning openEditModal" data-id="<?= $levelThreshold['id']; ?>" data-level="<?= $levelThreshold['level']; ?>"
                                        data-experience="<?= $levelThreshold['experience_required']; ?>" title="Modifier">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- MODALE DE MODIFICATION -->
                <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5">Modification</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <form method="POST" action="<?= base_url('admin/level-threshold/update'); ?>">
                                <input type="hidden" id="updateid" name="id" value="">

                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="updatelevel" class="form-label">Niveau</label>
                                        <input type="number" class="form-control" id="updatelevel" name="level" min="1" placeholder="Niveau" required></div>

                                    <div class="mb-3">
                                        <label for="updateExperience" class="form-label">Expérience requise</label>
                                        <input type="number" class="form-control" id="updateExperience" name="experience_required" min="0" placeholder="XP" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                    <button type="submit" class="btn btn-primary">Sauvegarder</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- PAGINATION -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div id="levelThresholdShowing">
                        Showing 1 to 10 of <?= count($levelThresholds); ?> entries
                    </div>
                    <ul class="pagination pagination-sm mb-0"
                        id="levelThresholdPagination">
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const table =
            document.getElementById('levelThresholdTable');
        const tbody =
            table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));
        const pagination =
            document.getElementById('levelThresholdPagination');
        const showing =
            document.getElementById('levelThresholdShowing');

        /** Nombre maximum de pages */
        const totalPages = Math.min(2, Math.ceil(rows.length / 1));

        /** Nombre de niveaux par page */
        const rowsPerPage = Math.ceil(rows.length / totalPages);
        let currentPage = 1;

        /** Affichage d'une page*/
        function displayPage(page) {
            currentPage = page;
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            rows.forEach(function (row, index) {

                if (index >= start && index < end) {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
                }
            });

            /** Showing*/
            const totalEntries = rows.length;
            const firstEntry =
                totalEntries === 0 ? 0 : start + 1;

            const lastEntry =
                Math.min(end, totalEntries);
            showing.textContent =
                `Showing ${firstEntry} to ${lastEntry} of ${totalEntries} entries`;
            updatePagination();
        }
        /** Pagination **/
        function updatePagination() {
            pagination.innerHTML = '';
            if (totalPages === 0) {
                return;
            }
            /** Bouton précédent*/
            const previous =
                document.createElement('li');
            previous.className =
                'page-item';
            if (currentPage === 1) {
                previous.classList.add('disabled');
            }
            previous.innerHTML = `
            <a class="page-link" href="#">
                <i class="fa-solid fa-chevron-left"></i>
            </a>
        `;
            previous.addEventListener('click', function (event) {
                event.preventDefault();
                if (currentPage > 1) {
                    displayPage(currentPage - 1);
                }
            });
            pagination.appendChild(previous);
            /** Numéros des pages*/
            for (
                let page = 1;
                page <= totalPages;
                page++
            ) {
                const item =
                    document.createElement('li');
                item.className =
                    'page-item';
                if (page === currentPage) {
                    item.classList.add('active');
                }
                item.innerHTML = `
                <a class="page-link" href="#">
                    ${page}
                </a>
            `;
                item.addEventListener('click', function (event) {
                    event.preventDefault();
                    displayPage(page);
                });
                pagination.appendChild(item);
            }
            /** Bouton suivant**/
            const next =
                document.createElement('li');
            next.className =
                'page-item';
            if (currentPage === totalPages) {
                next.classList.add('disabled');
            }
            next.innerHTML = `
            <a class="page-link" href="#">
                <i class="fa-solid fa-chevron-right"></i>
            </a>
        `;
            next.addEventListener('click', function (event) {
                event.preventDefault();
                if (currentPage < totalPages) {
                    displayPage(currentPage + 1);
                }
            });
            pagination.appendChild(next);
        }
        /** Affichage de la première page*/
        if (totalPages > 0) {
            displayPage(1);
        }
    });
</script>

<script>
    $(document).ready(function () {
        const modalEdit = new bootstrap.Modal(
            document.getElementById('editModal')
        );
        $(document).on('click', '.openEditModal', function () {
            let id = $(this).data('id');
            let level = $(this).data('level');
            let experience = $(this).data('experience');
            $('#updateid').val(id);
            $('#updatelevel').val(level);
            $('#updateExperience').val(experience);

            modalEdit.show();
        });
    });
</script>
