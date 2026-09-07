<div class="row align-items-center mb-3">
    <div class="col">
        <div class="page-title">Niveaux de rareté</div>
    </div>
</div>

<div class="row mb-3">
    <!-- AJOUT D'UNE RARETÉ -->
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="card-title">Ajouter une rareté</div>
                <?= form_open('admin/rarity-level/create') ?>
                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-n fa-xs"></i>
                        <i class="fa-solid fa-r fa-xs"></i>
                    </span>
                    <input type="text" name="name" class="form-control" placeholder="Nom" maxlength="50" required title="Nom">
                </div>

                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-palette fa-xs"></i>
                    </span>
                    <input type="color" name="color" class="form-control form-control-color w-100" value="#ffffff" required title="Couleur">
                </div>

                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-bolt fa-xs"></i>
                    </span>
                    <input type="number" name="power_multiplier" class="form-control" placeholder="Multiplicateur de puissance" min="0" step="0.01" required title="Multiplicateur de puissance">
                </div>

                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-coins fa-xs"></i>
                    </span>
                    <input type="number" name="cost_multiplier" class="form-control" placeholder="Multiplicateur de coût" min="0" step="0.01" required title="Multiplicateur de coût">
                </div>

                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-percent fa-xs"></i>
                    </span>
                    <input type="number" name="appearance_rate" class="form-control" placeholder="Taux d'apparition" min="0" step="1" required title="Taux d'apparition">
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-regular fa-floppy-disk me-2"></i>
                        Ajouter
                    </button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>

    <!-- TABLEAU DES RARETÉS -->
    <div class="col-md-9">
        <div class="card h-100">
            <div class="card-body table-responsive">
                <table class="table table-hover table-striped table-sm" id="rarityLevelTable" data-toggle="table" data-pagination="true" data-page-size="10" data-page-list="[10, 15, 20, 30]" data-sortable="true">
                    <thead>
                    <tr>
                        <th data-sortable="true">Nom</th>
                        <th data-sortable="true">Couleur</th>
                        <th data-sortable="true">Puissance</th>
                        <th data-sortable="true">Coût</th>
                        <th data-sortable="true">Apparition</th>
                        <th data-sortable="false">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($rarityLevels as $rarityLevel) : ?>
                        <tr>
                            <td><?= esc($rarityLevel['name']); ?>
                            </td>

                            <td>
                                <span style="display:inline-block;width:25px;height:25px;background-color:<?= esc($rarityLevel['color']); ?>;vertical-align:middle;margin-right:5px;"></span>
                                <?= esc($rarityLevel['color']); ?>
                            </td>
                            <td><?= $rarityLevel['power_multiplier']; ?></td>
                            <td><?= $rarityLevel['cost_multiplier']; ?></td>
                            <td><?= $rarityLevel['appearance_rate']; ?></td>
                            <td class="d-flex">

                                <!-- SUPPRESSION -->
                                <?= form_open('admin/rarity-level/delete', ['class' => 'd-inline']); ?>

                                <?= form_hidden(
                                        'id',
                                        (string) $rarityLevel['id']
                                ); ?>

                                <button type="button" class="btn btn-danger btn-sm openDeleteModal" data-id="<?= $rarityLevel['id']; ?>" data-name="<?= esc($rarityLevel['name']); ?>" title="Supprimer">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                                <?= form_close(); ?>

                                <!-- MODIFICATION -->
                                <span
                                        class="ms-2 btn btn-sm btn-warning openEditModal"
                                        data-name="<?= esc($rarityLevel['name']); ?>"
                                        data-color="<?= esc($rarityLevel['color']); ?>"
                                        data-power="<?= $rarityLevel['power_multiplier']; ?>"
                                        data-cost="<?= $rarityLevel['cost_multiplier']; ?>"
                                        data-rate="<?= $rarityLevel['appearance_rate']; ?>"
                                        data-id="<?= $rarityLevel['id']; ?>"
                                        title="Modifier">
                                    <i class="fa-solid fa-pen"></i>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODALE DE MODIFICATION -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Modification</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <?= form_open('admin/rarity-level/update'); ?>

            <input type="hidden" id="updateId" value="" name="id">
            <div class="modal-body">
                <div class="mb-3">
                    <label for="updateName" class="form-label">Nom</label>
                    <input id="updateName" type="text" name="name" class="form-control" placeholder="Nom" maxlength="50" required title="Nom">
                </div>

                <div class="mb-3">
                    <label for="updateColor" class="form-label">Couleur</label>
                    <input id="updateColor" type="color" name="color" class="form-control form-control-color w-100"
                            required title="Couleur">
                </div>

                <div class="mb-3">
                    <label for="updatePower" class="form-label">Multiplicateur de puissance</label>
                    <input id="updatePower" type="number" name="power_multiplier" class="form-control" placeholder="Multiplicateur de puissance" min="0" step="0.01" required title="Multiplicateur de puissance">
                </div>

                <div class="mb-3">
                    <label for="updateCost" class="form-label">Multiplicateur de coût</label>
                    <input id="updateCost" type="number" name="cost_multiplier" class="form-control" placeholder="Multiplicateur de coût" min="0" step="0.01" required title="Multiplicateur de coût">
                </div>

                <div class="mb-3">
                    <label for="updateRate" class="form-label">Taux d'apparition</label>
                    <input id="updateRate" type="number" name="appearance_rate" class="form-control" placeholder="Taux d'apparition" min="0" step="0.0001" required title="Taux d'apparition">
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

<!-- MODALE DE CONFIRMATION DE SUPPRESSION -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">
                    <i class="fa-solid fa-triangle-exclamation text-danger me-2"></i>Confirmation
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <div class="mb-3">
                    <i class="fa-solid fa-trash-can text-danger" style="font-size: 3rem;"></i>
                </div>

                <p class="mb-1">Voulez-vous vraiment supprimer cette rareté ?
                </p>
                <strong id="deleteRarityName"></strong>
                <div class="alert alert-warning mt-3 mb-0">
                    <i class="fa-solid fa-triangle-exclamation me-1"></i>Cette action est définitive.
                </div>
            </div>

            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler
                </button>

                <button type="button" class="btn btn-danger" id="confirmDelete">
                    <i class="fa-solid fa-trash me-1"></i>Supprimer définitivement
                </button>
            </div>
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
    $(document).ready(function () {

        /*
         * MODALE DE MODIFICATION
         */
        const modalEdit = new bootstrap.Modal('#editModal');

        $(document).on('click', '.openEditModal', function () {

            let id = $(this).data('id');
            let name = $(this).data('name');
            let color = $(this).data('color');
            let power = $(this).data('power');
            let cost = $(this).data('cost');
            let rate = $(this).data('rate');

            $('#updateId').val(id);
            $('#updateName').val(name);
            $('#updateColor').val(color);
            $('#updatePower').val(power);
            $('#updateCost').val(cost);
            $('#updateRate').val(rate);

            modalEdit.show();
        });

        /*
         * MODALE DE SUPPRESSION
         */
        const modalDelete = new bootstrap.Modal('#deleteModal');
        $(document).on('click', '.openDeleteModal', function () {

            let id = $(this).data('id');
            let name = $(this).data('name');
            $('#deleteRarityName').text(name);
            $('#confirmDelete').data('id', id);

            modalDelete.show();
        });

        /*
         * CONFIRMATION DE SUPPRESSION
         */
        $('#confirmDelete').on('click', function () {

            let id = $(this).data('id');

            let form = $('<form>', {
                method: 'POST',
                action: '<?= base_url('admin/rarity-level/delete'); ?>'
            });

            $('<input>', {
                type: 'hidden',
                name: 'id',
                value: id
            }).appendTo(form);

            form.appendTo('body').submit();
        });
    });
</script>

