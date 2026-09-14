<?php helper('form'); ?>
<div class="row align-items-center mb-3">
    <div class="col">
        <div class="page-title">Gestion des spécialisations</div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="card-title">Nouvelle spécialisation</div>

                <?= form_open('admin/specialization/create') ?>

                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-tag"></i>
                    </span>
                    <input type="text" name="name" class="form-control" placeholder="Nom de la spécialisation" value="" title="Spécialisation" required>
                </div>

                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-align-left"></i>
                    </span>
                    <textarea name="description" class="form-control" placeholder="Description de la spécialisation" title="Description" rows="5"></textarea>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-floppy-disk me-2"></i>Créer
                    </button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="card h-100">
            <div class="card-body table-responsive">
                <table class="table table-hover table-striped table-sm" data-toggle="table" data-pagination="true" data-page-size="15" data-sortable="true">

                    <thead>
                    <tr>
                        <th data-sortable="true">Nom</th>
                        <th data-sortable="true">Description</th>
                        <th data-sortable="true">Créée le</th>
                        <th data-sortable="true">Modifiée le</th>
                        <th data-sortable="false">Actions</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php foreach ($specializations as $specialization) : ?>
                        <tr>
                            <td><?= $specialization['name']; ?></td>
                            <td><?= $specialization['description']; ?></td>
                            <td><?= $specialization['created_at']; ?></td>
                            <td><?= $specialization['updated_at']; ?></td>
                            <td class="d-flex">

                                <!-- Bouton Modification : disponible pour toutes les spécialisations -->
                                <button type="button" class="btn btn-sm btn-warning openEditModal me-2" data-bs-toggle="modal"
                                        data-bs-target="#editModal" data-id="<?= $specialization['id']; ?>" data-name="<?= $specialization['name']; ?>" data-description="<?= $specialization['description']; ?>">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>

                                <!-- Suppression : interdite pour l'ID 1 -->
                                <?php if ($specialization['id'] != 1) : ?>

                                    <?= form_open('admin/specialization/delete'); ?>
                                    <?= form_hidden('id', $specialization['id']); ?>

                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                    <?= form_close(); ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Modification</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <?= form_open('admin/specialization/update'); ?>

            <input type="hidden" id="updateId" value="" name="id">
            <div class="modal-body">
                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-tag"></i>
                    </span>

                    <input id="updateName" type="text" name="name" class="form-control" placeholder="Nom de la spécialisation" value="" title="Spécialisation" required>
                </div>

                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-align-left"></i>
                    </span>

                    <textarea id="updateDescription" name="description" class="form-control" placeholder="Description de la spécialisation" title="Description" rows="5"></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-primary">Sauvegarder</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<style>
    /* Annule le flex: 0 0 50% de Tabler sur les boutons de pagination */
    .bootstrap-table .pagination .page-item.page-next,
    .bootstrap-table .pagination .page-item.page-prev {
        flex: none !important;
        text-align: inherit !important;
    }
</style>

<script>
    $(document).ready(function(){
        // A n'écouter qu'en JS natif : tabler.min.js dispatche un évènement DOM
        // dont le "type" est littéralement "show.bs.modal". jQuery .on('show.bs.modal', ...)
        // interprète le point comme un namespace et n'écoute que "show", donc ne se déclenche jamais.
        document.getElementById('editModal').addEventListener('show.bs.modal', function (event) {
            let button = event.relatedTarget;
            let id = button.getAttribute('data-id');
            let name = button.getAttribute('data-name');
            let description = button.getAttribute('data-description');
            $('#updateId').val(id);
            $('#updateName').val(name);
            $('#updateDescription').val(description);
        })

        $(document).on('submit', 'form[action*="delete"]', function(e) {
            e.preventDefault();
            let form = $(this);
            Swal.fire({
                title:'Êtes-vous sûr ?',
                text : 'Cette action est irréversible !',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.get(0).submit();
                }
            })
        })
    });
</script>
