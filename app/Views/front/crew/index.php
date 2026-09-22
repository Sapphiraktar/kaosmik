<div class="row">
    <div class="col d-flex">
        <div>
            <h1 class="shadow text-white">Mon équipage</h1>
            <span class="text-white">Ici, on gère nos mercenaires</span>
        </div>
    </div>
</div>

<div class="row g-3 justify-content-end mb-4">
    <div class="col-auto">
        <button type="button" class="btn btn-outline-kaosmik" id="toggle-bulk-mode">
            Licencier en masse
        </button>
    </div>

    <div class="col-auto">
        <?= form_open('equipage/sell-bulk', ['id' => 'form-sell-bulk', 'class' => 'd-none']); ?>
        <div id="bulk-inputs"></div>
        <button type="submit" id="btn-sell-bulk" class="btn btn-danger" disabled>
            Licencier la selection ( <i class="fa-solid fa-cent-sign"></i> <span id="bulk-price">0</span> )
        </button>
        <?= form_close(); ?>
    </div>
</div>

<div class="row row-cols-6 g-3">
    <?php foreach ($logged_user->getPlayer()->getHeroes() as $hero): ?>
        <div class="col">
            <?= view_cell('HeroCell', ['character' => $hero, 'context' => 'crew',]) ?>
        </div>
    <?php endforeach; ?>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Gestion de la confirmation pour la vente INDIVIDUELLE
        document.querySelectorAll('.js-form-sell').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const btn = this.querySelector('button[type="submit"]');
                const heroName = btn.dataset.heroName || 'ce mercenaire';

                Swal.fire({
                    title: 'Résilier le contrat ?',
                    text: `Êtes-vous sûr de vouloir licencier ce mercenaire ${heroName} ?`,
                    showCancelButton: true,
                    confirmButtonText: 'oui !',
                    cancelButtonText: 'annuler !',
                    icon: 'warning',
                    customClass: {
                        confirmButton: 'btn btn-kaosmik',
                        cancelButton: 'btn btn-secondary'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });
        // Déclaration des variables pour la vente en lot
        const toggleBtn = document.getElementById('toggle-bulk-mode');
        const bulkForm = document.getElementById('form-sell-bulk');
        const bulkInputs = document.getElementById('bulk-inputs');
        const bulkPrice = document.getElementById('bulk-price');
        const btnSellBulk = document.getElementById('btn-sell-bulk');

        // Bouton de bascule pour la vente en lot
        toggleBtn.addEventListener('click', () => {
            const isBulkInactive = bulkForm.classList.contains('d-none');

            if (isBulkInactive) {
                // Activation de la vente en lot
                bulkForm.classList.remove('d-none');
                toggleBtn.classList.replace('btn-outline-kaosmik', 'btn-warning');
                toggleBtn.textContent = 'Annuler';
            } else {
                // Désactivation de la vente en lot
                bulkForm.classList.add('d-none');
                toggleBtn.classList.replace('btn-warning', 'btn-outline-kaosmik');
                toggleBtn.textContent = 'Licencier en masse';

                // Décocher toutes les cases
                document.querySelectorAll('.js-hero-select').forEach(el => {
                    el.checked = false;
                });
                updateBulkTotal();
            }
            // Masquer / Afficher le formulaire de vente en lot
            document.querySelectorAll('.js-bulk-checkbox-container').forEach(el => {
                el.classList.toggle('d-none', !isBulkInactive);
            });
            // Afficher / cacher les boutons de licenciement individuel
            document.querySelectorAll('.js-single-sell-form').forEach(el => {
                el.classList.toggle('d-none', isBulkInactive);
            });
        });
        // Gestion du clic sur la carte pour cocher / décocher
        document.querySelectorAll('.js-hero-card').forEach(card => {
            card.addEventListener('click', (e) => {
                // Si la vente en lot n'est pas active, on ne clique pas DIRECTEMENT sur la checkbox
                if (bulkForm.classList.contains('d-none')) {
                    return;
                }
                // Si on clique directement sur la checkbox,
                // on laisse le navigateur gérer le changement
                if (e.target.classList.contains('js-hero-select')) {
                    updateBulkTotal();
                    return;
                }
                // Récupération de la checkbox de cette carte
                const checkbox = card.querySelector('.js-hero-select');
                if (checkbox) {
                    checkbox.click();
                }
            });
        });
        //Ecoute du changement sur chaque checkBox
        document.querySelectorAll('.js-hero-select').forEach(checkbox => {
            checkbox.addEventListener('change', updateBulkTotal);
        });
        //Confirmation Swal2 pour la vente en lot
        bulkForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const total = parseInt(bulkPrice.textContent) || 0;

            Swal.fire({
                title: `Voulez-vous vraiment licencier ces mercenaires ?`,
                text: `Vous allez licencier pour ${total} crédits`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'oui !',
                cancelButtonText: 'Annuler !',
                customClass: {
                    confirmButton: 'btn btn-kaosmik',
                    cancelButton: 'btn btn-secondary'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
        // Recalcul du total
        function updateBulkTotal() {
            let total = 0;
            let count = 0;

            bulkInputs.innerHTML = '';
            document.querySelectorAll('.js-hero-select').forEach(checkbox => {
                const card = checkbox.closest('.js-hero-card');

                if (checkbox.checked) {

                    card.classList.add('is-selected');
                    const price = parseInt(card.dataset.sellPrice) || 0;
                    const heroId = card.dataset.id;
                    total += price;
                    count++;

                    //Ajouté mon input caché
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'ids[]';
                    hiddenInput.value = heroId;
                    bulkInputs.appendChild(hiddenInput);
                } else {
                    card.classList.remove('is-selected');
                }
            });
            bulkPrice.textContent = total;
            btnSellBulk.disabled = (count === 1 || count === 0);
        }
    });
</script>
<style>
    .js-hero-card.is-selected {
        filter: brightness(0.6);
        opacity: 0.8;
    }
</style>